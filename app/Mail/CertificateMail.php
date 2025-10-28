<?php

namespace App\Mail;

use App\Models\Certificate;
use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Certificate $certificate;
    public ?Course $course;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
        
        // Always fetch the single course with ID = 1
        $this->course = Course::find(1);
    }

    public function envelope(): Envelope
    {
        // Dynamically set the subject with course name
        $courseName = $this->course?->name ?? 'Solar Design Course';
        
        return new Envelope(
            subject: "Your {$courseName} Certificate - Institute of Torchbearer Technologies",
        );
    }

    public function content(): Content
    {
        // Add null checks and default values
        return new Content(
            view: 'emails.certificate',
            with: [
                'recipientName' => $this->certificate->recipient_name ?? 'Recipient',
                'courseDescription' => $this->course?->description ?? 'Course completion',
                'courseName' => $this->course?->name ?? 'Solar Design Course',
                'issueDate' => $this->certificate->issue_date ? 
                    \Carbon\Carbon::parse($this->certificate->issue_date)->format('F j, Y') : 
                    now()->format('F j, Y'),
                'certificateId' => $this->certificate->certificate_id ?? 'N/A',
            ]
        );
    }

    public function attachments(): array
    {
        $logoBase64 = $this->getImageAsBase64('https://i.postimg.cc/nhdkjKJr/image-removebg-preview-1.png');
        $stampBase64 = $this->getImageAsBase64('https://i.postimg.cc/DwBTSN0H/Untitled-design.png');
        $qrCodeBase64 = $this->getImageAsBase64('https://i.postimg.cc/nhKqCDbr/My-QR-Code-1-1024.png');

        $pdfData = [
            'recipientName' => $this->certificate->recipient_name ?? 'Recipient',
            'courseDescription' => $this->course?->description ?? 'Successfully completed the solar design course',
            'trainerName' => $this->course?->trainer ?? 'Institute Staff',
            'courseName' => $this->course?->name ?? 'Solar Design Course', 
            'certificateId' => $this->certificate->certificate_id ?? 'N/A',
            'issueDate' => $this->certificate->issue_date ? 
                \Carbon\Carbon::parse($this->certificate->issue_date)->format('F d, Y') : 
                now()->format('F d, Y'),
            'logoBase64' => $logoBase64,
            'stampBase64' => $stampBase64,
            'qrCodeBase64' => $qrCodeBase64,
        ];

        $pdf = Pdf::loadView('certificates.certificate_pdf', $pdfData)
            ->setPaper('a4', 'landscape')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('dpi', 96)
            ->setOption('defaultFont', 'DejaVu Sans')
            ->setOption('margin_top', 0)
            ->setOption('margin_bottom', 0)
            ->setOption('margin_left', 0)
            ->setOption('margin_right', 0)
            ->setOption('chroot', public_path())
            ->setOption('scale', 1)
            ->setOption('enable_remote', true)
            ->setOption('enable_local', true)
            ->setOption('enable_local_file_access', true);

        $pdfContent = $pdf->output();

        // Check if PDF is empty
        if (strlen($pdfContent) < 1000) {
            \Log::error('PDF generation failed - empty output', [
                'certificate_id' => $this->certificate->id ?? 'unknown',
                'pdf_size' => strlen($pdfContent)
            ]);
            throw new \Exception('PDF generation failed - empty output');
        }

        return [
            Attachment::fromData(fn() => $pdfContent, 'certificate.pdf')
                ->withMime('application/pdf'),
        ];
    }

    private function getImageAsBase64(string $url): string
    {
        try {
            // Use file_get_contents with context for better reliability
            $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
                'http' => [
                    'timeout' => 15,
                    'ignore_errors' => true,
                ]
            ]);

            $imageData = file_get_contents($url, false, $context);

            if (!$imageData) {
                throw new \Exception('Failed to fetch image');
            }

            $base64 = base64_encode($imageData);
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($imageData);

            return "data:$mimeType;base64,$base64";
        } catch (\Exception $e) {
            \Log::error('Failed to fetch image: ' . $e->getMessage(), ['url' => $url]);
            // Return a transparent 1x1 pixel PNG as fallback
            return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        }
    }
}