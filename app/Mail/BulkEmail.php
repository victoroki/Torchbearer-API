<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Communication;

class BulkEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $communication;
    public $emailDetails;
    public $recipient;
    public $attachmentPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Communication $communication, $recipient, $attachmentPath = null)
    {
        $this->communication = $communication;
        $this->emailDetails = $communication->emailDetails;
        $this->recipient = $recipient;
        $this->attachmentPath = $attachmentPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject($this->communication->subject)
            ->from($this->emailDetails->from_email, $this->emailDetails->from_name)
            ->view('emails.bulk')
            ->with([
                'content' => $this->communication->content,
                'recipientName' => $this->recipient->name
            ]);

        // Add reply-to if specified
        if (!empty($this->emailDetails->reply_to)) {
            $mail->replyTo($this->emailDetails->reply_to);
        }

        // Add CC if specified
        if (!empty($this->emailDetails->cc)) {
            $ccEmails = array_map('trim', explode(',', $this->emailDetails->cc));
            $mail->cc($ccEmails);
        }

        // Add BCC if specified
        if (!empty($this->emailDetails->bcc)) {
            $bccEmails = array_map('trim', explode(',', $this->emailDetails->bcc));
            $mail->bcc($bccEmails);
        }

        // Add attachment if specified
        if (!empty($this->attachmentPath)) {
            $mail->attach(storage_path('app/public/' . $this->attachmentPath));
        }

        return $mail;
    }
}