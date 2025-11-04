<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/torchbearer-logo.png') }}" alt="Logo">
        </div>
        
        <div class="content">
            @if(!empty($recipientName))
            <p>Dear {{ $recipientName }},</p>
            @else
            <p>Hello,</p>
            @endif
            
            {!! $content !!}
            
            <p>Best regards,<br>
            {{ config('app.name') }} Team</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This email was sent from a notification-only address that cannot accept incoming email.</p>
        </div>
    </div>
</body>
</html>