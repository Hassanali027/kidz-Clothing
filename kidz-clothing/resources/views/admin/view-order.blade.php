@extends('admin.layout')

@section('header_title', 'Order Details')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.orders') }}" style="text-decoration: none; color: #666; font-weight: 600;">
            <i class="fa-solid fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
        <!-- Left: Order Items & Shipping -->
        <div>
            <!-- Order Items -->
            <div class="content-card" style="margin-bottom: 30px;">
                <div class="card-header">
                    <h2>Products in Order</h2>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Image</th>
                            <th>Product</th>
                            <th>Color / Size</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    @if($item->product_image)
                                        <img src="{{ asset($item->product_image) }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 4px;"></div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $item->product_name }}</strong>
                                    @if($item->product)
                                        <br><small style="color: #999;">ID: #{{ $item->product_id }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($item->color)
                                        <span style="font-size: 13px;">Color: <strong>{{ $item->color }}</strong></span>
                                    @endif
                                    @if($item->size)
                                        <br><span style="font-size: 13px;">Size: <strong>{{ $item->size }}</strong></span>
                                    @endif
                                    @if(!$item->color && !$item->size)
                                        <span style="color: #ccc;">N/A</span>
                                    @endif
                                </td>
                                <td>Rs {{ number_format($item->price) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rs {{ number_format($item->price * $item->quantity) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: 700; padding: 20px;">Grand Total:</td>
                            <td style="font-weight: 800; font-size: 18px; color: #000; padding: 20px;">Rs {{ number_format($order->total_amount) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Shipping Info -->
            <div class="content-card">
                <div class="card-header">
                    <h2>Shipping Information</h2>
                </div>
                <div style="padding: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    <div>
                        <p style="margin-bottom: 5px; color: #888; font-size: 12px; font-weight: 700; text-transform: uppercase;">Customer Name</p>
                        <p style="font-weight: 600; font-size: 16px;">{{ $order->first_name }} {{ $order->last_name }}</p>
                    </div>
                    <div>
                        <p style="margin-bottom: 5px; color: #888; font-size: 12px; font-weight: 700; text-transform: uppercase;">Phone Number</p>
                        <p style="font-weight: 600; font-size: 16px;">{{ $order->phone }}</p>
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <p style="margin-bottom: 5px; color: #888; font-size: 12px; font-weight: 700; text-transform: uppercase;">Delivery Address</p>
                        <p style="font-weight: 600; font-size: 16px; line-height: 1.5;">{{ $order->address }}</p>
                    </div>
                    <div>
                        <p style="margin-bottom: 5px; color: #888; font-size: 12px; font-weight: 700; text-transform: uppercase;">City</p>
                        <p style="font-weight: 600; font-size: 16px;">{{ $order->city }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Order Status & Actions -->
        <div>
            <div class="content-card">
                <div class="card-header">
                    <h2>Order Summary</h2>
                </div>
                <div style="padding: 20px;">
                    <div style="margin-bottom: 20px;">
                        <p style="margin-bottom: 5px; color: #888; font-size: 12px; font-weight: 700; text-transform: uppercase;">Order Number</p>
                        <p style="font-weight: 800; font-size: 20px; color: #2196F3;">{{ $order->order_number }}</p>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <p style="margin-bottom: 5px; color: #888; font-size: 12px; font-weight: 700; text-transform: uppercase;">Order Date</p>
                        <p style="font-weight: 600;">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <p style="margin-bottom: 5px; color: #888; font-size: 12px; font-weight: 700; text-transform: uppercase;">Payment Method</p>
                        <p style="font-weight: 600; color: #4caf50;">{{ strtoupper($order->payment_method) }}</p>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <p style="margin-bottom: 5px; color: #888; font-size: 12px; font-weight: 700; text-transform: uppercase;">Current Status</p>
                        <span class="badge badge-{{ $order->status == 'pending' ? 'warning' : 'success' }}" style="font-size: 14px; padding: 6px 15px;">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">

                    <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" onsubmit="confirmDelete(event, this)">
                        @csrf
                        <button type="submit" style="width: 100%; padding: 12px; background: #f44336; color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">
                            <i class="fa-solid fa-trash"></i> Delete Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Undo Delete Notification -->
    <div id="undo-notification" style="display: none; position: fixed; bottom: 30px; right: 30px; background: #1e293b; color: white; padding: 16px 24px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); z-index: 9999; min-width: 300px;">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px;">
            <span id="undo-message">Order will be deleted in <strong id="countdown">5</strong>s</span>
            <button id="undo-btn" style="background: #f06292; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600;">Undo</button>
        </div>
    </div>

    <script>
        let deleteTimeout;
        let countdownInterval;
        let currentForm;

        function confirmDelete(event, form) {
            event.preventDefault();
            currentForm = form;
            showUndoNotification();
        }

        function showUndoNotification() {
            const notification = document.getElementById('undo-notification');
            const countdownEl = document.getElementById('countdown');
            let seconds = 5;

            notification.style.display = 'block';
            countdownEl.textContent = seconds;

            // Clear any existing timers
            if (deleteTimeout) clearTimeout(deleteTimeout);
            if (countdownInterval) clearInterval(countdownInterval);

            // Countdown
            countdownInterval = setInterval(() => {
                seconds--;
                countdownEl.textContent = seconds;
                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);

            // Delete after 5 seconds
            deleteTimeout = setTimeout(() => {
                currentForm.submit();
            }, 5000);
        }

        document.getElementById('undo-btn').addEventListener('click', function() {
            clearTimeout(deleteTimeout);
            clearInterval(countdownInterval);
            document.getElementById('undo-notification').style.display = 'none';
            currentForm = null;
        });
    </script>

    <style>
        .badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-warning { background: #fff3e0; color: #ff9800; }
        .badge-success { background: #e8f5e9; color: #4caf50; }
        
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }
        .admin-table th, .admin-table td {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .admin-table th {
            background: #f9f9f9;
            font-weight: 700;
            color: #555;
            text-transform: uppercase;
            font-size: 12px;
        }
    </style>
@endsection
