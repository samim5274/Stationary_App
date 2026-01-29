<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>income Details - {{ $company->name }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;

            display: flex;
            justify-content: center; /* horizontal center */
            align-items: center;    /* vertical center */
            min-height: 100%;      /* full viewport height */
        }

        .half-page {
            width: 48%; /* half page width */
            padding: 25px;            
            box-sizing: border-box;
            margin-top: 2%;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            margin: 2px 0;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 15px 0;
        }

        .income-card {
            border: 1px solid #000;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .income-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .income-row div {
            width: 48%;
        }

        .label {
            font-weight: bold;
        }

        .amount-box {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            margin-top: 15px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }

        .signature-section {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
        }

        .signature-block {
            width: 45%;
            text-align: center;
        }

        .signature-block .line {
            border-top: 1px solid #000;
            margin: 0 auto 5px auto;
            width: 60%;
        }

        .signature-block small {
            font-size: 12px;
        }

        .note {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
        }

        @media print {
            body { margin: 0; }
            .half-page { page-break-after: always; }
        }
    </style>
</head>
<body>

    <div class="half-page">
        <!-- Header -->
        <div class="header">
            <h1>{{ $company->name }}</h1>
            <p>{{ $company->address }}</p>
            <p>{{ $company->email }} | Phone: {{ $company->phone }} | Website: {{ $company->website }}</p>
            <hr>
            <h2>Income Details</h2>
        </div>

        <!-- income Details Card -->
        <div class="income-card">
            <div class="income-row">
                <div><span class="label">Title:</span> {{ $income->title }}</div>
                <div><span class="label">Date:</span> {{ \Carbon\Carbon::parse($income->date)->format('d M, Y') }}</div>
            </div>

            <div class="income-row">
                <div><span class="label">User:</span> {{ $income->user->first_name ?? '' }} {{ $income->user->last_name ?? '' }}</div>
                <div><span class="label">Category:</span> {{ $income->category->name ?? 'N/A' }}</div>
            </div>

            <div class="income-row">
                <div><span class="label">Subcategory:</span> {{ $income->subcategory->name ?? 'N/A' }}</div>
            </div>
            <div><span class="label">Remark:</span> {{ $income->remark ?? 'N/A' }}</div>

            <div class="amount-box">
                Amount: ৳{{ number_format($income->amount, 2) }}/-
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-block">
                <div class="line"></div>
                <small>Prepared By</small>
            </div>
            <div class="signature-block">
                <div class="line"></div>
                <small>Approved By</small>
            </div>
        </div>

        <!-- Note -->
        <div class="note">
            Developed by <strong>SAMIM-HosseN</strong>. Call: +88015 3302-1557
        </div>
    </div>

    <script>
        window.onload = function () {
            window.print();
            setTimeout(function () {
                window.close();
            }, 500);
        };
    </script>
    
</body>
</html>
