<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $company->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: 80mm auto;
            margin: 0;
        }
        
        html, body {
            margin: 0 !important;
            padding: 0 !important;
        }

        body {
            font-family: 'Consolas', 'Courier New', monospace;
            font-size: 10px;
            width: 68mm;
            margin: 0 auto;
            padding: 2mm 2mm;
            line-height: 1.3;
        }

        .invoice-header {
            text-align: center;
            padding: 5px 0;
            border-bottom: 1px dashed #000;
            margin-bottom: 8px;
        }

        .invoice-header h2 {
            font-size: 14px;
            margin: 2px 0;
            text-transform: uppercase;
        }

        .invoice-header p {
            margin: 0;
            font-size: 10px;
        }

        .invoice-header .order-title {
            font-size: 11px;
            font-weight: bold;
            margin-top: 5px;
        }

        .invoice-subheader {
            margin-bottom: 8px;
            font-size: 10px;
        }

        .invoice-subheader .info-line {
            display: flex;
            justify-content: space-between;
            margin: 1px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 9.5px;
        }

        table th, table td {
            padding: 2px 0;
            border: none;
            text-align: right;
            white-space: pre-wrap;
        }

        table thead {
            border-bottom: 1px dashed #000;
        }

        table th:nth-child(1), table td:nth-child(1) { width: 5%; text-align: left; }
        table th:nth-child(2), table td:nth-child(2) { width: 40%; text-align: left; word-break: break-word; }
        table th:nth-child(3), table td:nth-child(3) { width: 10%; text-align: right; }
        table th:nth-child(4), table td:nth-child(4) { width: 20%; text-align: right; }
        table th:nth-child(5), table td:nth-child(5) { width: 25%; text-align: right; }

        /* -------- Totals Section -------- */
        .totals-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px; 
            margin-bottom: 10px;
        }

        .totals-table tr td {
            padding: 2px 0;
        }

        .totals-table td:first-child {
            text-align: left;
            width: 50%;
        }

        .totals-table td:last-child {
            text-align: right;
            width: 50%;
        }

        .separator {
            border-top: 1px dashed #000;
        }

        .final-total {
            font-weight: bold;
            font-size: 11px;
        }

        .note {
            text-align: center;
            font-size: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            padding-top: 5px;
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

    <div class="invoice-header">
        <h2>{{ $company->name }}</h2>
        <p>{{ $company->address }}</p>
        <p>{{ $company->email }} || {{ $company->phone }}</p>
        <p class="order-title">INVOICE</p>
    </div>

    <div class="invoice-subheader">
        <div class="info-line">
            <span><strong>Bill Officer:</strong> {{ $cartItems[0]->user->first_name ?? 'N/A' }} {{ $cartItems[0]->user->last_name ?? 'N/A' }}</span>
            <span><strong>Customer:</strong> {{ $order->customerName }}</span>
        </div>
        <div class="info-line">
            <span><strong>C.Phone:</strong> {{ $order->customerPhone }}</span>
            <span><strong>Date:</strong> {{ $order->created_at->format('d-m-Y') }}</span>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Qty</th>
                <th>৳/Unit</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $key => $val)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ \Illuminate\Support\Str::limit($val->product->name ?? '', 20, '...') }}</td>
                <td>{{ $val->quantity }}</td>
                <td>{{ number_format($val->price, 2) }}</td>
                <td>{{ number_format($val->price * $val->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr class="separator">
            <td>Subtotal:</td>
            <td>৳{{ number_format($paymentDetail->total ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td>Discount:</td>
            <td>- ৳{{ number_format($paymentDetail->discount ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td>VAT:</td>
            <td>+ ৳{{ number_format($paymentDetail->vat ?? 0, 2) }}</td>
        </tr>
        <tr class="separator final-total">
            <td>Payable:</td>
            <td>৳{{ number_format($paymentDetail->payable ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td>Paid:</td>
            <td>৳{{ number_format($paymentDetail->pay ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td class="final-total">Due:</td>
            <td class="final-total">৳{{ number_format($paymentDetail->due ?? 0, 2) }}</td>
        </tr>

        <tr class="separator">
            <td>Payment:</td>
            <td>{{ $paymentMethod->name ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="note">
        <strong>নোট:</strong>
            বিক্রয়ের পর পণ্য ফেরত বা পরিবর্তন করা যাবে না।
            যদি পণ্যে প্রস্তুতকারকজনিত কোনো ত্রুটি পাওয়া যায়, তবে বিলসহ ২৪ ঘণ্টার মধ্যে জানাতে হবে।
            ডিসকাউন্টকৃত পণ্য ফেরতযোগ্য নয়। <br>
            এই বিলটি ভবিষ্যৎ যেকোনো অভিযোগ বা সেবার জন্য সংরক্ষণ করুন। <br>
            <strong>Thank you for shopping with us.</strong><br>
            আমাদের সাথে কেনাকাটার জন্য ধন্যবাদ।
    </div>

    <div class="note">
        Developed by <strong>SAMIM-HosseN</strong> || +8801533021557
    </div>
    
    <div class="note">.</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.print();
            setTimeout(() => window.close(), 300);
        });
    </script>
</body>
</html>
