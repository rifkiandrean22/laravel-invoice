<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .company { font-weight: bold; font-size: 18px; }
        .invoice-details { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company">My Company</div>
        <div>Invoice #{{ $invoice->id }}</div>
        <div>{{ $invoice->created_at->format('d M Y') }}</div>
    </div>

    <div class="invoice-details">
        <strong>Customer:</strong> {{ $invoice->customer_name }} <br>
        <strong>Keterangan Pembayaran:</strong> {{ $invoice->payment_note }} <br>
        <strong>Status:</strong> {{ ucfirst($invoice->status) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            {{-- Jika ada relasi items --}}
            @foreach($invoice->items ?? [] as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
            {{-- Total --}}
            <tr>
                <td colspan="3" class="total">Total</td>
                <td class="total">{{ number_format($invoice->total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <strong>Tanda Bukti Pembayaran:</strong><br>
        @if($invoice->payment_proof)
            <img src="{{ storage_path('app/public/payment-proofs/'.$invoice->payment_proof) }}" width="150">
        @else
            Tidak ada bukti pembayaran
        @endif
    </div>
</body>
</html>
