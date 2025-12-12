<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Certificate</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="color: #FFD700; margin: 0; font-size: 28px; font-weight: bold;">
                                Torchbearer Institute
                            </h1>
                            <p style="color: #ffffff; margin: 10px 0 0 0; font-size: 14px;">
                                {{ $courseName }}
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="color: #1e3a8a; margin: 0 0 20px 0; font-size: 24px;">
                                Congratulations, {{ $recipientName }}!
                            </h2>
                            
                            <p style="color: #333333; line-height: 1.6; margin: 0 0 15px 0; font-size: 16px;">
                                We are pleased to inform you that you have successfully completed the 
                                <strong style="color: #1e3a8a;">{{ $courseName }}</strong>.
                            </p>
                            
                            <!-- <p style="color: #333333; line-height: 1.6; margin: 0 0 15px 0; font-size: 16px;">
                                {{ $courseDescription }}
                            </p> -->
                            
                            <p style="color: #333333; line-height: 1.6; margin: 0 0 25px 0; font-size: 16px;">
                                Your certificate is attached to this email. Please download and keep it for your records.<br>
                                Share your achievement and tag us on <a href="https://www.linkedin.com/company/torchbearer-institute-of-technologies/posts/?feedView=all" style="color: #1e3a8a; text-decoration: none;">LinkedIn</a>!
                            </p>
                            
                            <!-- Certificate Details Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9fa; border-left: 4px solid #FFD700; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 10px 0; color: #666666; font-size: 14px;">
                                            <strong style="color: #1e3a8a;">Certificate ID:</strong> {{ $certificateId }}
                                        </p>
                                        <p style="margin: 0; color: #666666; font-size: 14px;">
                                            <strong style="color: #1e3a8a;">Issue Date:</strong> {{ $issueDate }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="color: #333333; line-height: 1.6; margin: 25px 0 0 0; font-size: 16px;">
                                We wish you continued success in your solar design career!
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1e3a8a; padding: 30px; text-align: center;">
                            <p style="color: #FFD700; margin: 0 0 10px 0; font-size: 18px; font-weight: bold;">
                                Institute of Torchbearer Technologies
                            </p>
                            <p style="color: #ffffff; margin: 0; font-size: 14px; line-height: 1.6;">
                                Empowering the future of renewable energy<br>
                                This is an automated email. Please do not reply.
                            </p>
                        </td>
                    </tr>
                    
                </table>
                
                <!-- Email Footer -->
                <table width="600" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <p style="color: #999999; font-size: 12px; margin: 0; line-height: 1.6;">
                                © {{ date('Y') }} Institute of Torchbearer Technologies. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>