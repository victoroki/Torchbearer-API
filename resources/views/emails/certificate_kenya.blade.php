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
                    
                    <!-- Header with gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #006600 0%, #00aa00 50%, #FFD700 100%); padding: 5px 30px; text-align: center; position: relative;">
                            <div style="background-color: rgba(255, 255, 255, 0.95); padding: 35px 20px; margin: 15px 0;">
                                <h1 style="color: #006600; margin: 0; font-size: 28px; font-weight: bold;">
                                    Kenstane Energy Limited
                                </h1>
                                <p style="color: #555555; margin: 10px 0 0 0; font-size: 14px; font-weight: 600;">
                                    Renewable Energy Webinar
                                </p>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="color: #000000; margin: 0 0 20px 0; font-size: 24px;">
                                Congratulations, {{ $recipientName }}!
                            </h2>
                            
                            <p style="color: #333333; line-height: 1.6; margin: 0 0 15px 0; font-size: 16px;">
                                We are pleased to inform you that you have successfully participated in the 
                                <strong style="color: #006600;">Renewable Energy Webinar</strong> conducted on 
                                <strong>5th November 2025</strong> from 1700hrs to 1900hrs.
                            </p>
                            
                            <p style="color: #333333; line-height: 1.6; margin: 0 0 15px 0; font-size: 16px;">
                                Led by <strong>Parvez Butt</strong>, Principal Risk Powergen Engineer, this webinar covered 
                                essential renewable energy technologies including Solar, Wind, Hydropower, Geothermal, 
                                Biomass, Ocean Energy, and Green Hydrogen production.
                            </p>
                            
                            <p style="color: #333333; line-height: 1.6; margin: 0 0 25px 0; font-size: 16px;">
                                Your certificate of participation is attached to this email. Please download and keep it for your records.
                            </p>
                            
                            <!-- Certificate Details Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9fa; border-left: 4px solid #006600; border-top: 2px solid #00aa00; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 10px 0; color: #666666; font-size: 14px;">
                                            <strong style="color: #000000;">Certificate ID:</strong> {{ $certificateId }}
                                        </p>
                                        <p style="margin: 0; color: #666666; font-size: 14px;">
                                            <strong style="color: #000000;">Issue Date:</strong> {{ $issueDate }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="color: #333333; line-height: 1.6; margin: 25px 0 0 0; font-size: 16px;">
                                We wish you continued success in advancing renewable energy solutions!
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #006600 0%, #00aa00 100%); padding: 30px; text-align: center;">
                            <p style="color: #ffffff; margin: 0 0 10px 0; font-size: 18px; font-weight: bold;">
                                Kenstane Energy Limited
                            </p>
                            <p style="color: #ffffff; margin: 0; font-size: 14px; line-height: 1.6;">
                                Empowering sustainable energy solutions<br>
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
                                © {{ date('Y') }} Kenstane Energy Limited. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>