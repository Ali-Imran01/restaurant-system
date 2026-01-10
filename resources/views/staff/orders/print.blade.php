<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $order->id }}</title>
    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 80mm;
            margin: 0;
            padding: 5mm;
            font-size: 12px;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 3mm 0; }
        .header { margin-bottom: 5mm; }
        .restaurant-name { font-size: 16px; font-bold: bold; display: block; }
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table td { padding: 1mm 0; vertical-align: top; }
        .item-qty { width: 10mm; }
        .item-name { width: 45mm; }
        .item-price { text-align: right; }
        .totals { margin-top: 5mm; }
        .footer { margin-top: 10mm; font-size: 10px; }
        
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print();">
    <div class="no-print" style="background: #fdf6e3; padding: 10px; text-align: center; border-bottom: 1px solid #eee; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #fff; border: 1px solid #ccc; border-radius: 4px; font-weight: bold; margin-right: 10px;">Print Receipt</button>
        <button onclick="if(window.opener) { window.close(); } else { window.location.href = '{{ route('staff.orders') }}'; }" style="padding: 10px 20px; cursor: pointer; background: #fff; border: 1px solid #ccc; border-radius: 4px; font-weight: bold;">Close Window</button>
    </div>

    <div class="header text-center">
        <span class="restaurant-name bold">{{ $order->table->restaurant->name }}</span>
        <span>{{ $order->table->restaurant->address }}</span><br>
        <span>Table: {{ $order->table->table_number }}</span><br>
        <span>Date: {{ $order->created_at->format('d/m/Y H:i') }}</span><br>
        <span>Cashier: {{ auth()->user()->name }}</span><br>
        <span>Order #{{ $order->id }}</span>
        @if($order->status === 'cancelled')
            <br><span class="bold" style="font-size: 18px; color: #000; display: block; margin-top: 2mm; border: 2px solid #000; padding: 2mm; letter-spacing: 2px;">*** CANCELLED ***</span>
        @endif
    </div>

    <div class="divider"></div>

    <table class="items-table">
        @foreach($order->items as $item)
            <tr>
                <td class="item-qty">{{ $item->quantity }}x</td>
                <td class="item-name">
                    {{ $item->menuItem->name }}
                    @if($item->notes)
                        <br><span style="font-size: 10px; font-style: italic;">*{{ $item->notes }}</span>
                    @endif
                </td>
                <td class="item-price">{{ number_format($item->subtotal, 2) }}</td>
            </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <div class="totals text-right">
        <span>Subtotal: RM {{ number_format($order->total_amount / 1.06, 2) }}</span><br>
        <span>SST (6%): RM {{ number_format($order->total_amount - ($order->total_amount / 1.06), 2) }}</span><br>
        <span class="bold" style="font-size: 14px;">Total: RM {{ number_format($order->total_amount, 2) }}</span>
    </div>

    <div class="divider"></div>

    <div class="text-center">
        <span>Payment: {{ strtoupper($order->payment_method) }}</span>
    </div>

    <div class="footer text-center">
        <p>Thank you for dining with us!</p>
        <p>Powered by RestoQR</p>
    </div>

</body>
</html>
