<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Print Daily Sale Report</title>
    <style>
        @page { size: A4 landscape; margin: 10mm; }

        body{
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            color:#000;
        }

        .wrap{ padding: 10mm; }

        h1,h3,p{ margin:0; text-align:center; }
        h1{ font-size: 22px; }
        p{ font-size: 12px; }
        h3{ margin-top:6px; font-size: 16px; }

        hr{
            margin: 10px 0;
            border: none;
            border-top: 1px solid #000;
        }

        table{
            width:100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th, td{
            border:1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
        }

        thead { display: table-header-group; }  /* page break হলে header repeat */
        tfoot { display: table-footer-group; }

        th{
            background:#f4f4f4;
            font-weight:700;
            text-align:left;
            white-space: nowrap;
        }

        td.num{ text-align:right; white-space:nowrap; }
        th.num{ text-align:right; white-space:nowrap; }
        td.center{ text-align:center; white-space:nowrap; }
        th.center{ text-align:center; white-space:nowrap; }

        .summary{
            margin-top: 6px;
            font-size: 12px;
            display:flex;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }
        .summary div{ white-space: nowrap; }

        .signature-section{
            display:flex;
            justify-content: space-between;
            margin-top: 25mm;
            page-break-inside: avoid;
        }
        .signature-block{
            width: 45%;
            text-align:center;
            border-top:1px solid #000;
            padding-top: 5px;
            font-weight:700;
            font-size: 12px;
        }

        .note{
            font-size: 9px;
            margin-top: 10px;
            text-align:center;
        }

        @media print{
            .no-print{ display:none !important; }
        }
    </style>
</head>
<body>
<div class="wrap">
    <h1>{{ $company->name }}</h1>
    <p>{{ $company->address }}</p>
    <p>Email: {{ $company->email }} | Phone: {{ $company->phone }} | Website: {{ $company->website }}</p>
    <h3>Daily Sale / Payment Report ({{ \Carbon\Carbon::today()->format('d M Y') }})</h3>
    <hr>

    <div class="summary">
        <div><strong>Orders:</strong> {{ $orders->count() }}</div>
        <div><strong>Total Sales:</strong> ৳ {{ number_format($paymentDetails->sum('total'), 2) }}</div>
        <div><strong>Total Pay:</strong> ৳ {{ number_format($paymentDetails->sum('pay'), 2) }}</div>
        <div><strong>Total Due:</strong> ৳ {{ number_format($paymentDetails->sum('due'), 2) }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="center">#</th>
                <th class="center">Date</th>
                <th class="center">Name</th>
                <th class="center">Reg</th>
                <th class="center">Method</th>
                <th class="num">Total (৳)</th>
                <th class="num">Discount (৳)</th>
                <th class="num">VAT (৳)</th>
                <th class="num">Payable (৳)</th>
                <th class="num">Pay (৳)</th>
                <th class="num">Due (৳)</th>
            </tr>
        </thead>

        <tbody>
        @forelse($paymentDetails as $i => $val)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td class="center">{{ optional($val->date)->format('d-m-Y') }}</td>
                <td>
                    {{ $val->user->first_name ?? '-' }}
                    {{ $val->user->last_name ?? '-' }}
                </td>
                <td class="center">INV-{{ $val->reg ?? '-' }}</td>
                <td class="center">{{ $val->paymentMethod->name ?? '-' }}</td>

                <td class="num">৳ {{ number_format((float)$val->total, 2) }}</td>
                <td class="num">৳ {{ number_format((float)$val->discount, 2) }}</td>
                <td class="num">৳ {{ number_format((float)$val->vat, 2) }}</td>
                <td class="num">৳ {{ number_format((float)$val->payable, 2) }}</td>
                <td class="num">৳ {{ number_format((float)$val->pay, 2) }}</td>
                <td class="num">৳ {{ number_format((float)$val->due, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="11" class="center">No data found for today.</td>
            </tr>
        @endforelse
        </tbody>

        <tfoot>
            <tr>
                <th colspan="5" class="num">Total</th>
                <th class="num">৳ {{ number_format($paymentDetails->sum('total'), 2) }}</th>
                <th class="num">৳ {{ number_format($paymentDetails->sum('discount'), 2) }}</th>
                <th class="num">৳ {{ number_format($paymentDetails->sum('vat'), 2) }}</th>
                <th class="num">৳ {{ number_format($paymentDetails->sum('payable'), 2) }}</th>
                <th class="num">৳ {{ number_format($paymentDetails->sum('pay'), 2) }}</th>
                <th class="num">৳ {{ number_format($paymentDetails->sum('due'), 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="signature-section">
        <div class="signature-block">Manager Signature</div>
        <div class="signature-block">Admin Signature</div>
    </div>

    <p class="note">
        <strong>Note:</strong> Developed by <strong>SAMIM-HosseN</strong>. Call: +88015 3302-1557
    </p>
</div>

<script class="no-print">
    window.onload = function () {
        window.print();
        setTimeout(() => window.close(), 300);
    };
</script>
</body>
</html>
