<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Invoice #{{ $invoice->invoice_number }}</h2>
        <p>Date: {{ $invoice->invoice_date->format('d-m-Y') }}</p>
    </div>

    <p><strong>Customer:</strong> {{ $invoice->customer_name }}</p>

    <table class="table">
        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>
<p>
    <strong>Invoice #:</strong> {{ $invoice->invoice_number }}<br>
    <strong>Date:</strong> {{ $invoice->invoice_date->format('d-m-Y') }}<br>
    <strong>Category:</strong> {{ ucfirst($invoice->category) }}
</p>
        <tr>
            <td>Invoice Payment</td>
            <td>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
</body>
</html>
