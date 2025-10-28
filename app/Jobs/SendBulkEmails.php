<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Communication;
use App\Mail\BulkEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendBulkEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $communicationId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($communicationId)
    {
        $this->communicationId = $communicationId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $communication = Communication::with(['emailDetails', 'recipients'])->findOrFail($this->communicationId);
        
        // Update communication status to sending
        $communication->status = 'sending';
        $communication->save();
        
        $attachmentPath = $communication->emailDetails->attachment_path;
        $failedCount = 0;
        
        foreach ($communication->recipients as $recipient) {
            try {
                // Skip if already sent
                if ($recipient->status === 'sent') {
                    continue;
                }
                
                // Update recipient status to pending
                $recipient->status = 'pending';
                $recipient->save();
                
                // Send email
                Mail::to($recipient->email)->send(new BulkEmail($communication, $recipient, $attachmentPath));
                
                // Update recipient status to sent
                $recipient->status = 'sent';
                $recipient->status_message = 'Email sent successfully';
                $recipient->save();
                
                // Add a small delay to prevent overwhelming the mail server
                sleep(1);
                
            } catch (\Exception $e) {
                // Log error
                Log::error('Failed to send email to ' . $recipient->email . ': ' . $e->getMessage());
                
                // Update recipient status to failed
                $recipient->status = 'failed';
                $recipient->status_message = 'Failed to send: ' . $e->getMessage();
                $recipient->save();
                
                $failedCount++;
            }
        }
        
        // Update communication status based on results
        if ($failedCount === $communication->recipients->count()) {
            $communication->status = 'failed';
        } else if ($failedCount > 0) {
            $communication->status = 'partially_sent';
        } else {
            $communication->status = 'sent';
        }
        
        $communication->save();
        
        // Log completion
        Log::info('Bulk email job completed for communication ID: ' . $this->communicationId . 
                 '. Status: ' . $communication->status);
    }
}