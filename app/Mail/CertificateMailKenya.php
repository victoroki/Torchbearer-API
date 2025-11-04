<?php

namespace App\Mail;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateMailKenya extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Certificate $certificate;
    public string $courseDescription;

    public function __construct(Certificate $certificate, string $courseDescription = null)
    {
        $this->certificate = $certificate;
        $this->courseDescription = $courseDescription ?? 'Successfully completed comprehensive training in solar photovoltaic system design, installation best practices, and renewable energy solutions for Kenya.';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your Solar Energy Systems Design Certificate - Institute of Torchbearer Technologies",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.certificate_kenya',
            with: [
                'recipientName' => $this->certificate->recipient_name ?? 'Recipient',
                'courseDescription' => $this->courseDescription,
                'courseName' => 'Solar Energy Systems Design',
                'issueDate' => now()->format('F j, Y'),
                'certificateId' => $this->certificate->certificate_id ?? 'N/A',
            ]
        );
    }

    public function attachments(): array
    {
        // Fetch images when the job is processed (not in constructor)
        $logoBase64 = $this->getImageAsBase64('https://i.postimg.cc/nhdkjKJr/image-removebg-preview-1.png');
        $stampBase64 = $this->getImageAsBase64('https://i.postimg.cc/DwBTSN0H/Untitled-design.png');
        $qrCodeBase64 = $this->getImageAsBase64('https://i.postimg.cc/nhKqCDbr/My-QR-Code-1-1024.png');

        $pdfData = [
            'recipientName' => $this->certificate->recipient_name ?? 'Recipient',
            'courseDescription' => $this->courseDescription,
            'trainerName' => 'Dr. James Kamau',
            'courseName' => 'Solar Energy Systems Design',
            'certificateId' => $this->certificate->certificate_id ?? 'N/A',
            'issueDate' => now()->format('F d, Y'),
            'logoBase64' => $logoBase64,
            'stampBase64' => $stampBase64,
            'qrCodeBase64' => $qrCodeBase64,
        ];

        try {
            // Use the standard, GD-safe certificate template
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
        } catch (\Exception $e) {
            \Log::error('PDF generation error in CertificateMailKenya', [
                'certificate_id' => $this->certificate->id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Get image as base64 - NO EXTENSIONS REQUIRED
     * Uses only URL extension to determine mime type
     */
    private function getImageAsBase64(string $url): string
    {
        try {
            // Use file_get_contents with context
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
                throw new \Exception('Failed to fetch image from URL');
            }

            $base64 = base64_encode($imageData);
            
            // Determine mime type ONLY from URL extension - NO PHP EXTENSIONS NEEDED
            $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
            
            $mimeType = match($extension) {
                'png' => 'image/png',
                'jpg', 'jpeg' => 'image/jpeg',
                'gif' => 'image/gif',
                'svg' => 'image/svg+xml',
                'webp' => 'image/webp',
                default => 'image/png'
            };

            return "data:$mimeType;base64,$base64";
            
        } catch (\Exception $e) {
            \Log::error('Failed to fetch image in CertificateMailKenya', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            
            // Return a transparent 1x1 pixel PNG as fallback
            return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        }
    }
}