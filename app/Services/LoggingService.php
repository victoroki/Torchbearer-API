<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoggingService
{
    /**
     * Log communication activity
     *
     * @param string $action
     * @param mixed $model
     * @param array $additionalData
     * @return void
     */
    public static function logCommunicationActivity($action, $model, $additionalData = [])
    {
        $userId = Auth::id() ?? 'system';
        $userName = Auth::user()->name ?? 'System';
        
        $logData = [
            'user_id' => $userId,
            'user_name' => $userName,
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'data' => $additionalData
        ];
        
        Log::channel('communication')->info(json_encode($logData));
    }
}