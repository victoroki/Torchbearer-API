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

        /* Simplified Kenyan-themed triangles without complex clipping */
        .bg-kenya-top-left {
            top: 0;
            left: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 120px 150px 0 0;
            border-color: #000000 transparent transparent transparent;
        }

        .bg-kenya-top-right {
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 140px 110px 0;
            border-color: transparent #BB0000 transparent transparent;
        }

        .bg-kenya-bottom-left {
            bottom: 0;
            left: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 0 130px 170px;
            border-color: transparent transparent #006600 transparent;
        }

        /* White accent stripes */
        .white-stripe-top {
            position: absolute;
            top: 50px;
            left: 80px;
            width: 180px;
            height: 3px;
            background: white;
            z-index: 6;
        }

        .white-stripe-bottom {
            position: absolute;
            bottom: 50px;
            right: 80px;
            width: 180px;
            height: 3px;
            background: white;
            z-index: 6;
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
            border-left: 2px solid #BB0000;
            border-top: 2px solid #BB0000;
        }

        .corner-decoration.top-right {
            top: 25px;
            right: 25px;
            border-right: 2px solid #006600;
            border-top: 2px solid #006600;
        }

        .corner-decoration.bottom-left {
            bottom: 25px;
            left: 25px;
            border-left: 2px solid #006600;
            border-bottom: 2px solid #006600;
        }

        .corner-decoration.bottom-right {
            bottom: 25px;
            right: 25px;
            border-right: 2px solid #BB0000;
            border-bottom: 2px solid #BB0000;
        }

        /* Simplified border without radius to avoid potential rendering issues */
        .flag-border {
            position: absolute;
            top: 25px;
            left: 25px;
            right: 25px;
            bottom: 25px;
            border: 3px solid #000000;
            z-index: 5;
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

        /* Logo placeholder text instead of image */
        .header-logo {
            position: absolute;
            top: 45px;
            left: 55px;
            z-index: 15;
            font-size: 12px;
            color: #666;
        }

        .main-title {
            font-size: 62px;
            font-weight: 700;
            letter-spacing: 5px;
            color: #000000;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 18px;
            font-weight: 400;
            letter-spacing: 3px;
            color: #BB0000;
            margin-bottom: 35px;
            text-transform: uppercase;
        }

        .presented-to {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 2px;
            color: #006600;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .recipient-name {
            font-size: 48px;
            font-weight: 400;
            font-style: italic;
            color: #BB0000;
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

        /* Stamp placeholder text instead of image */
        .stamp-placeholder {
            width: 110px;
            height: 110px;
            display: block;
            margin: 0 auto 10px;
            border: 2px dashed #ccc;
            text-align: center;
            line-height: 110px;
            font-size: 10px;
            color: #999;
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
        <div class="bg-element bg-kenya-top-left"></div>
        <div class="bg-element bg-kenya-top-right"></div>
        <div class="bg-element bg-kenya-bottom-left"></div>

        <div class="white-stripe-top"></div>
        <div class="white-stripe-bottom"></div>

        <div class="corner-decoration top-left"></div>
        <div class="corner-decoration top-right"></div>
        <div class="corner-decoration bottom-left"></div>
        <div class="corner-decoration bottom-right"></div>

        <div class="flag-border"></div>

        <div class="header-logo">
            Institute Logo
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
                            <div class="signature-title">Technical Instructor</div>
                        </td>
                        <td>
                            <div class="stamp-placeholder">Official Stamp</div>
                            <div class="signature-name">Ondora Dalton</div>
                            <div class="signature-line"></div>
                            <div class="signature-title">Director</div>
                            <div class="signature-subtitle">Torchbearer Institute of Technologies</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="certificate-id">ID: {{ $certificateId }}</div>
        <div class="certificate-date">Date: {{ $issueDate }}</div>
    </div>
</body>
</html>