<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bank Transaction - {{ $company->name }}</title>
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
            min-height: 100%;
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

        .trx-card {
            border: 1px solid #000;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .trx-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .trx-row div {
            width: 48%;
        }

        .label {
            font-weight: bold;
        }

        .status-badge{
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            border: 1px solid #000;
        }

        .deposit{
            background: #dcfce7;
            color: #991b1b;
            border-color: #991b1b;
        }

        .withdraw{
            background: #fee2e2;
            color: #166534;
            border-color: #166534;
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

@php
    $isDeposit = ($transection->status === 'Deposit');
@endphp

<div class="half-page">
    <!-- Header -->
    <div class="header">
        <h1>{{ $company->name }}</h1>
        <p>{{ $company->address }}</p>
        <p>{{ $company->email ?? 'N/A' }} | Phone: {{ $company->phone ?? 'N/A' }} | Website: {{ $company->website ?? 'N/A' }}</p>
        <hr>
        <h2>Bank Transaction Details</h2>
    </div>

    <!-- Transaction Details Card -->
    <div class="trx-card">

        <div class="trx-row">
            <div>
                <span class="label">Date:</span>
                {{ \Carbon\Carbon::parse($transection->date)->format('d M, Y') }}
            </div>
            <div>
                <span class="label">Bank:</span>
                {{ $transection->bank->bank_name ?? 'N/A' }}
            </div>
        </div>

        <div class="trx-row">
            <div>
                <span class="label">Status:</span>
                <span class="status-badge {{ $isDeposit ? 'deposit' : 'withdraw' }}">
                    {{ $transection->status }}
                </span>
            </div>
        </div>

        <div class="trx-row">
            <div>
                <span class="label">Remark:</span>
                {{ $transection->remark ?? 'N/A' }}
            </div>
        </div>

        <div class="amount-box">
            Amount: ৳{{ number_format($transection->amount, 2) }}/-
        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-block">
            {{ Auth::guard('admin')->user()->first_name }}
            {{ Auth::guard('admin')->user()->last_name }}
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