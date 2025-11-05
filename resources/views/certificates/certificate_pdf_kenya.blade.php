<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Renewable Energy Certificate</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 297mm;
            height: 210mm;
            overflow: hidden;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .certificate-container {
            width: 297mm;
            height: 210mm;
            background: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        /* Modern gradient background */
        .bg-gradient {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 180px;
            background: linear-gradient(135deg, #006600 0%, #00aa00 50%, #FFD700 100%);
            opacity: 0.08;
            z-index: 1;
        }

        .bg-gradient-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 120px;
            background: linear-gradient(45deg, #BB0000 0%, #FF6B6B 100%);
            opacity: 0.05;
            z-index: 1;
        }

        /* Decorative elements */
        .deco-circle {
            position: absolute;
            border-radius: 50%;
            z-index: 2;
        }

        .deco-circle-1 {
            top: -60px;
            right: 80px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(0,102,0,0.1) 0%, transparent 70%);
        }

        .deco-circle-2 {
            bottom: -80px;
            left: 60px;
            width: 240px;
            height: 240px;
            background: radial-gradient(circle, rgba(187,0,0,0.08) 0%, transparent 70%);
        }

        .deco-circle-3 {
            top: 50%;
            right: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,215,0,0.06) 0%, transparent 70%);
        }

        /* Border frame */
        .certificate-border {
            position: absolute;
            top: 30px;
            left: 40px;
            right: 40px;
            bottom: 30px;
            border: 3px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #006600, #BB0000, #FFD700) border-box;
            z-index: 3;
            box-shadow: inset 0 0 0 2px white;
        }

        /* Inner decorative corners */
        .corner-accent {
            position: absolute;
            width: 60px;
            height: 60px;
            z-index: 4;
        }

        .corner-accent::before,
        .corner-accent::after {
            content: '';
            position: absolute;
            background: linear-gradient(135deg, #006600, #00aa00);
        }

        .corner-accent.top-left {
            top: 45px;
            left: 55px;
        }

        .corner-accent.top-left::before {
            top: 0;
            left: 0;
            width: 3px;
            height: 30px;
        }

        .corner-accent.top-left::after {
            top: 0;
            left: 0;
            width: 30px;
            height: 3px;
        }

        .corner-accent.top-right {
            top: 45px;
            right: 55px;
        }

        .corner-accent.top-right::before {
            top: 0;
            right: 0;
            width: 3px;
            height: 30px;
        }

        .corner-accent.top-right::after {
            top: 0;
            right: 0;
            width: 30px;
            height: 3px;
        }

        .corner-accent.bottom-left {
            bottom: 45px;
            left: 55px;
        }

        .corner-accent.bottom-left::before {
            bottom: 0;
            left: 0;
            width: 3px;
            height: 30px;
        }

        .corner-accent.bottom-left::after {
            bottom: 0;
            left: 0;
            width: 30px;
            height: 3px;
        }

        .corner-accent.bottom-right {
            bottom: 45px;
            right: 55px;
        }

        .corner-accent.bottom-right::before {
            bottom: 0;
            right: 0;
            width: 3px;
            height: 30px;
        }

        .corner-accent.bottom-right::after {
            bottom: 0;
            right: 0;
            width: 30px;
            height: 3px;
        }

        /* Logo area */
        .header-section {
            position: absolute;
            top: 55px;
            left: 0;
            right: 0;
            z-index: 10;
            text-align: center;
        }

        .institute-logo {
            display: inline-block;
            margin-bottom: 8px;
        }

        .logo-circle {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #006600, #00aa00);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 4px 15px rgba(0,102,0,0.3);
        }

        .logo-text {
            color: white;
            font-size: 26px;
            font-weight: 700;
        }

        .institute-name {
            font-size: 13px;
            font-weight: 600;
            color: #2d2d2d;
            letter-spacing: 1.5px;
            margin-top: 8px;
        }

        /* Main content */
        .certificate-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            text-align: center;
            width: 85%;
            max-width: 900px;
        }

        .main-title {
            font-size: 68px;
            font-weight: 700;
            letter-spacing: 12px;
            background: linear-gradient(135deg, #006600, #00aa00, #FFD700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 20px;
            font-weight: 400;
            letter-spacing: 4px;
            color: #BB0000;
            margin-bottom: 40px;
            text-transform: uppercase;
        }

        .presented-to {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 2px;
            color: #555;
            margin-bottom: 18px;
            text-transform: uppercase;
        }

        .recipient-name {
            font-size: 52px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 30px;
            line-height: 1.3;
            position: relative;
            display: inline-block;
        }

        .recipient-name::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #006600, transparent);
        }

        .course-description {
            font-size: 15px;
            color: #444;
            line-height: 1.8;
            max-width: 700px;
            margin: 0 auto 40px auto;
            text-align: center;
        }

        .energy-topics {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px 20px;
            max-width: 650px;
            margin: 20px auto 40px;
            text-align: left;
            font-size: 12px;
            color: #555;
        }

        .energy-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .energy-icon {
            font-size: 16px;
        }

        /* Signature section */
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 80px;
        }

        .signature-block {
            text-align: center;
        }

        .signature-line {
            width: 220px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #333, transparent);
            margin: 12px auto 8px;
        }

        .signature-name {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .signature-title {
            font-size: 13px;
            font-weight: 500;
            color: #666;
            letter-spacing: 0.5px;
        }

        /* Footer info */
        .certificate-footer {
            position: absolute;
            bottom: 40px;
            left: 70px;
            right: 70px;
            display: flex;
            justify-content: space-between;
            z-index: 10;
            font-size: 11px;
            color: #888;
        }

        .footer-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .footer-label {
            font-weight: 600;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Background decorations -->
        <div class="bg-gradient"></div>
        <div class="bg-gradient-bottom"></div>
        <div class="deco-circle deco-circle-1"></div>
        <div class="deco-circle deco-circle-2"></div>
        <div class="deco-circle deco-circle-3"></div>

        <!-- Border -->
        <div class="certificate-border"></div>

        <!-- Corner accents -->
        <div class="corner-accent top-left"></div>
        <div class="corner-accent top-right"></div>
        <div class="corner-accent bottom-left"></div>
        <div class="corner-accent bottom-right"></div>

        <!-- Header with logo -->
        <div class="header-section">
            <div class="institute-logo">
                <div class="logo-circle">
                    <div class="logo-text">KEL</div>
                </div>
            </div>
            <div class="institute-name">KENTANE ENERGY LIMITED</div>
        </div>

        <!-- Main content -->
        <div class="certificate-content">
            <h1 class="main-title">CERTIFICATE</h1>
            <h2 class="subtitle">of Participation</h2>

            <p class="presented-to">This certificate is proudly presented to</p>

            <h3 class="recipient-name">{{ $recipientName }}</h3>

            <div class="course-description">
                For successfully participating in the <strong>Renewable Energy Webinar</strong> conducted on 
                <strong>5th November 2025</strong> from 1700hrs to 1900hrs, led by <strong>Parvez Butt</strong>, 
                Principal Risk Powergen Engineer, covering essential renewable energy technologies.
            </div>

            <div class="energy-topics">
                <div class="energy-item">
                    <span class="energy-icon">☀️</span>
                    <span>Solar Energy (Photovoltaic & Thermal)</span>
                </div>
                <div class="energy-item">
                    <span class="energy-icon">💨</span>
                    <span>Wind Energy (Turbine Systems)</span>
                </div>
                <div class="energy-item">
                    <span class="energy-icon">🌊</span>
                    <span>Hydropower (Dams & Run-of-River)</span>
                </div>
                <div class="energy-item">
                    <span class="energy-icon">🌍</span>
                    <span>Geothermal Energy</span>
                </div>
                <div class="energy-item">
                    <span class="energy-icon">🌿</span>
                    <span>Biomass Energy & Biofuels</span>
                </div>
                <div class="energy-item">
                    <span class="energy-icon">⚡</span>
                    <span>Ocean Energy (Tidal & Wave)</span>
                </div>
                <div class="energy-item">
                    <span class="energy-icon">💧</span>
                    <span>Green Hydrogen Production</span>
                </div>
            </div>

            <!-- Signature -->
            <div class="signature-section">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-name">Pervez Butt</div>
                    <div class="signature-title">Technical Instructor</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="certificate-footer">
            <div class="footer-item">
                <span class="footer-label">Certificate ID:</span>
                <span>{{ $certificateId }}</span>
            </div>
            <div class="footer-item">
                <span class="footer-label">Issue Date:</span>
                <span>{{ $issueDate }}</span>
            </div>
        </div>
    </div>
</body>
</html>