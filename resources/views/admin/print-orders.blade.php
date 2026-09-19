<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Orders</title>
    <style>
        * { box-sizing: border-box; }
        @page { size: A4; margin: 14mm; }
        body { margin: 0; color: #111827; font-family: Arial, sans-serif; font-size: 12px; }
        .print-order { min-height: 260mm; page-break-after: always; padding: 4mm; }
        .print-order:last-child { page-break-after: auto; }
        .print-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #111827; padding-bottom: 14px; margin-bottom: 18px; }
        .brand { font-size: 25px; font-weight: 800; letter-spacing: -0.5px; }
        .brand span { color: #ef5b93; }
        .invoice-title { text-align: right; }
        .invoice-title h1 { margin: 0 0 6px; font-size: 22px; letter-spacing: 1px; }
        .muted { color: #6b7280; }
        .address-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px; }
        .address-box { border: 1px solid #d1d5db; border-radius: 6px; padding: 12px; min-height: 110px; }
        .address-box h3 { margin: 0 0 8px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #4b5563; }
        .address-box p { margin: 4px 0; line-height: 1.45; }
        .order-meta { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 18px; padding: 12px; background: #f9fafb; border: 1px solid #e5e7eb; }
        .meta-label { display: block; color: #6b7280; font-size: 10px; margin-bottom: 4px; text-transform: uppercase; }
        .meta-value { font-weight: 700; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #111827; color: #fff; padding: 10px 8px; font-size: 10px; text-align: left; text-transform: uppercase; }
        td { padding: 10px 8px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        .align-right { text-align: right; }
        .totals { width: 280px; margin: 16px 0 0 auto; }
        .total-row { display: flex; justify-content: space-between; padding: 6px 0; }
        .grand-total { border-top: 2px solid #111827; margin-top: 6px; padding-top: 9px; font-size: 15px; font-weight: 800; }
        .footer-note { border-top: 1px solid #d1d5db; margin-top: 30px; padding-top: 10px; color: #6b7280; font-size: 10px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <button class="no-print" onclick="window.print()" style="position: fixed; top: 16px; right: 16px; padding: 10px 16px; border: 0; border-radius: 5px; background: #111827; color: #fff; font-weight: 700; cursor: pointer;">Print</button>

    @foreach($orders as $order)
        @php
            $subtotal = $order->items->sum(function ($item) { return $item->price * $item->quantity; });
            $discount = (float) ($order->discount_amount ?? 0);
            $shipping = max(0, (float) $order->total_amount - ($subtotal - $discount));
        @endphp
        <section class="print-order">
            <header class="print-header">
                <div class="brand">Kidz <span>Wear</span></div>
                <div class="invoice-title">
                    <h1>ORDER SHEET</h1>
                    <div class="muted">Order # {{ $order->order_number }}</div>
                </div>
            </header>

            <div class="address-grid">
                <div class="address-box">
                    <h3>Customer & Shipping Details</h3>
                    <p><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p>
                    <p>{{ $order->address }}</p>
                    <p>{{ $order->city }}</p>
                    <p>Phone: {{ $order->phone }}</p>
                </div>
                <div class="address-box">
                    <h3>Delivery Note</h3>
                    <p>Please deliver this order to the address shown.</p>
                    <p class="muted">Customer should be contacted before delivery if needed.</p>
                </div>
            </div>

                <div class="order-meta">
                    <div><span class="meta-label">Order Date</span><span class="meta-value">{{ $order->created_at->format('d M, Y h:i A') }}</span></div>
                    <div><span class="meta-label">Payment Method</span><span class="meta-value">{{ strtoupper($order->payment_method) }}</span></div>
                </div>

            <table>
                <thead>
                    <tr><th>Product</th><th>Size / Color</th><th class="align-right">Price</th><th class="align-right">Quantity</th><th class="align-right">Total</th></tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td><strong>{{ $item->product_name }}</strong></td>
                            <td>{{ $item->size ?: '—' }} @if($item->color)<br><span class="muted">Color: {{ $item->color }}</span>@endif</td>
                            <td class="align-right">Rs {{ number_format($item->price, 2) }}</td>
                            <td class="align-right">{{ $item->quantity }}</td>
                            <td class="align-right">Rs {{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals">
                <div class="total-row"><span>Subtotal</span><span>Rs {{ number_format($subtotal, 2) }}</span></div>
                @if($discount > 0)<div class="total-row"><span>Discount</span><span>- Rs {{ number_format($discount, 2) }}</span></div>@endif
                <div class="total-row"><span>Shipping</span><span>{{ $shipping > 0 ? 'Rs ' . number_format($shipping, 2) : 'Free' }}</span></div>
                <div class="total-row grand-total"><span>Total</span><span>Rs {{ number_format($order->total_amount, 2) }}</span></div>
            </div>

            <div class="footer-note">Thank you for shopping with Kidz Wear. This is a computer-generated order sheet.</div>
        </section>
    @endforeach

    <script>window.addEventListener('load', function () { window.print(); });</script>
</body>
</html>
