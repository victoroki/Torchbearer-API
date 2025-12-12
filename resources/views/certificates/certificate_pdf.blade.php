<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Solar Design Certificate</title>
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
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 297mm;
            height: 210mm;
            overflow: hidden;
        }

        .certificate-container {
            width: 297mm;
            height: 210mm;
            background: white;
            position: relative;
            overflow: hidden;
            page-break-after: avoid;
            page-break-before: avoid;
            page-break-inside: avoid;
        }

        .bg-element {
            position: absolute;
            z-index: 1;
        }

        .bg-yellow-top {
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 140px 110px 0;
            border-color: transparent #FFD700 transparent transparent;
        }

        .bg-navy-bottom {
            bottom: 0;
            left: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 0 130px 170px;
            border-color: transparent transparent #9b5f47 transparent;
        }

        .bg-navy-right {
            top: 0;
            right: 0;
            width: 110px;
            height: 210mm;
            background: #9b5f47;
            clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 30% 100%);
        }

        .bg-navy-left {
            bottom: 0;
            left: 0;
            width: 90px;
            height: 300px;
            background: #9b5f47;
            clip-path: polygon(0% 20%, 70% 0%, 100% 100%, 0% 100%);
        }

        .corner-decoration {
            position: absolute;
            z-index: 6;
            width: 45px;
            height: 45px;
        }

        .corner-decoration.top-left {
            top: 25px;
            left: 25px;
            border-left: 2px solid #DAA520;
            border-top: 2px solid #DAA520;
        }

        .corner-decoration.top-right {
            top: 25px;
            right: 25px;
            border-right: 2px solid #DAA520;
            border-top: 2px solid #DAA520;
        }

        .corner-decoration.bottom-left {
            bottom: 25px;
            left: 25px;
            border-left: 2px solid #DAA520;
            border-bottom: 2px solid #DAA520;
        }

        .corner-decoration.bottom-right {
            bottom: 25px;
            right: 25px;
            border-right: 2px solid #DAA520;
            border-bottom: 2px solid #DAA520;
        }

        .gold-border {
            position: absolute;
            top: 25px;
            left: 25px;
            right: 25px;
            bottom: 25px;
            border: 3px solid #DAA520;
            z-index: 5;
            border-radius: 8px;
            background: white;
        }

        .certificate-content {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 10;
            display: table;
            width: 100%;
            height: 100%;
            padding: 60px 80px 80px 80px;
            text-align: center;
        }

        .content-wrapper {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .header-logo {
            position: absolute;
            top: 45px;
            left: 55px;
            z-index: 15;
        }

        .header-logo img {
            max-width: 180px;
            max-height: 90px;
            display: block;
        }

        .main-title {
            font-size: 62px;
            font-weight: 700;
            letter-spacing: 5px;
            color: #1a1a1a;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 18px;
            font-weight: 400;
            letter-spacing: 3px;
            color: #4a4a4a;
            margin-bottom: 35px;
            text-transform: uppercase;
        }

        .presented-to {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 2px;
            color: #B8860B;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .recipient-name {
            font-size: 48px;
            font-weight: 400;
            font-style: italic;
            color: #9b5f47;
            margin-bottom: 25px;
            line-height: 1.2;
        }

        .course-description {
            font-size: 15px;
            color: #2d2d2d;
            line-height: 1.5;
            max-width: 540px;
            margin: 0 auto 35px auto;
            text-align: center;
        }

        .signatures-table {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .signatures-table td {
            width: 50%;
            vertical-align: bottom;
            padding: 0 20px;
        }

        .signature-name {
            margin-bottom: 8px;
            font-size: 14px;
            color: #1a1a1a;
        }

        .signature-line {
            width: 180px;
            height: 1px;
            background: #333;
            margin: 8px auto;
        }

        .signature-title {
            font-size: 12px;
            font-weight: 500;
            color: #444;
            margin-top: 5px;
        }

        .signature-subtitle {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }

        .stamp-img {
            width: 110px;
            height: 110px;
            display: block;
            margin: 0 auto 10px;
        }

        /* Adjusted QR code position only */
        .qr-code-container {
            position: absolute;
            bottom: 95px;
            /* increased from 70px to 95px */
            left: 55px;
            /* aligned better under the certificate ID */
            z-index: 15;
            text-align: center;
        }

        .qr-code-img {
            width: 80px;
            height: 80px;
            display: block;
            margin: 0 auto;
            border: 2px solid #DAA520;
            padding: 3px;
            background: white;
        }

        .certificate-date {
            position: absolute;
            bottom: 35px;
            right: 55px;
            font-size: 11px;
            color: #666;
            z-index: 15;
        }

        .certificate-id {
            position: absolute;
            bottom: 35px;
            left: 55px;
            font-size: 11px;
            color: #666;
            z-index: 15;
        }
    </style>
</head>

<body>
    <div class="certificate-container">
        <div class="bg-element bg-yellow-top"></div>
        <div class="bg-element bg-navy-bottom"></div>
        <div class="bg-element bg-navy-right"></div>
        <div class="bg-element bg-navy-left"></div>

        <div class="corner-decoration top-left"></div>
        <div class="corner-decoration top-right"></div>
        <div class="corner-decoration bottom-left"></div>
        <div class="corner-decoration bottom-right"></div>

        <div class="gold-border"></div>

        <div class="header-logo">
            <img src="{{ $logoBase64 }}" alt="Logo">
        </div>

        <div class="certificate-content">
            <div class="content-wrapper">
                <h1 class="main-title">CERTIFICATE</h1>
                <h2 class="subtitle">of achievement</h2>

                <p class="presented-to">this certificate is presented to</p>

                <h3 class="recipient-name">{{ $recipientName }}</h3>

                <div class="course-description">{{ $courseDescription }}</div>

                <table class="signatures-table">
                    <tr>
                        <td>
                            <div class="signature-name">{{ $trainerName }}</div>
                            <div class="signature-line"></div>
                            <div class="signature-title">Managing Director</div>
                        </td>
                        <td>
                            <img src="{{ $stampBase64 }}" alt="Stamp" class="stamp-img">
                            <div class="signature-name">Ondora Dalton</div>
                            <div class="signature-line"></div>
                            <div class="signature-title">Technical Director</div>
                            <div class="signature-subtitle">Torchbearer Institute of Technologies</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="certificate-id">ID: {{ $certificateId }}</div>
        <div class="certificate-date">Date: {{ $issueDate }}</div>

        <!-- QR code repositioned and label removed -->
        <div class="qr-code-container">
            <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="qr-code-img">
        </div>
    </div>
</body>

</html>