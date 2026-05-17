@extends('admin.layout')

@section('header_title', 'Order Management')

@section('content')
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="content-card">
        <div class="card-header">
            <h2>Recent Orders</h2>
        </div>
        
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>City</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}<br><small>{{ $order->phone }}</small></td>
                            <td>{{ $order->city }}</td>
                            <td>Rs {{ number_format($order->total_amount) }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status == 'pending' ? 'warning' : 'success' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.orders.view', $order->id) }}" class="btn-action btn-edit" title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" onsubmit="confirmDelete(event, this)" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action btn-delete" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #999;">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
            margin-top: 20px;
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
            font-size: 13px;
        }
        .btn-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            color: #fff;
            margin-right: 5px;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-edit { background: #2196F3; }
        .btn-delete { background: #f44336; }
        .btn-action:hover { opacity: 0.8; }
    </style>
@endsection
