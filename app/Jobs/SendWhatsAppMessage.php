<?php

namespace App\Jobs;

use App\Models\WhatsAppMessage;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $messageId;

    /**
     * Create a new job instance.
     */
    public function __construct($messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $whatsAppService): void
    {
        $message = WhatsAppMessage::find($this->messageId);

        if (!$message) {
            Log::error('WhatsApp message not found', ['message_id' => $this->messageId]);
            return;
        }

        try {
            // Send message based on type
            if ($message->media_type && $message->media_url) {
                $result = $whatsAppService->sendMediaMessage(
                    $message->recipient_phone,
                    $message->message,
                    $message->media_type,
                    $message->media_url,
                    $message->media_caption
                );
            } else {
                $result = $whatsAppService->sendTextMessage(
                    $message->recipient_phone,
                    $message->message
                );
            }

            if ($result['success']) {
                $message->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            } else {
                $message->update([
                    'status' => 'failed',
                    'error_message' => $result['error'] ?? 'Unknown error',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error sending WhatsApp message', [
                'message_id' => $this->messageId,
                'error' => $e->getMessage(),
            ]);

            $message->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
