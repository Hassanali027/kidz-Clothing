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

        @if($newOrdersCount > 0)
            <div class="new-orders-notice">
                <i class="fa-solid fa-bell"></i>
                <strong>{{ $newOrdersCount }} New {{ $newOrdersCount === 1 ? 'Order' : 'Orders' }}</strong>
                <span>awaiting your review</span>
            </div>
        @endif

        <form method="GET" action="{{ route('admin.orders') }}" style="display: flex; align-items: end; gap: 12px; flex-wrap: wrap; margin: 0 0 20px;">
            <div class="form-group" style="margin: 0; min-width: 240px;">
                <label for="order-category-filter">Filter by Order Category</label>
                <select id="order-category-filter" name="category" class="form-control" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $value => $label)
                        <option value="{{ $value }}" {{ $selectedCategory === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            @if($selectedCategory)
                <a href="{{ route('admin.orders') }}" class="btn-secondary" style="text-decoration: none; padding: 10px 14px;">Clear Filter</a>
            @endif
            <button type="button" id="print-selected-orders" class="btn-primary" disabled style="padding: 10px 14px;">
                <i class="fa-solid fa-print"></i> Print Selected (0)
            </button>
        </form>
        
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 44px;"><input type="checkbox" id="select-all-orders" aria-label="Select all orders"></th>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>City</th>
                        <th>Total Amount</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="{{ $order->is_new ? 'new-order-row' : '' }}">
                            <td><input type="checkbox" class="order-selector" value="{{ $order->id }}" aria-label="Select order {{ $order->order_number }}"></td>
                            <td>
                                <strong>{{ $order->order_number }}</strong>
                                @if($order->is_new)<span class="new-order-flag">NEW</span>@endif
                            </td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}<br><small>{{ $order->phone }}</small></td>
                            <td>{{ $order->city }}</td>
                            <td>Rs {{ number_format($order->total_amount) }}</td>
                            <td>
                                <span class="order-category-badge">{{ $categories[$order->workflow_category] ?? 'New Order' }}</span>
                                @if($order->is_contact_address_duplicate)
                                    <span class="order-duplicate-contact">Duplicate contact</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="status-select status-{{ strtolower($order->status) }}">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="hold" {{ $order->status == 'hold' ? 'selected' : '' }}>Hold</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.orders.view', $order->id) }}" class="btn-action btn-edit" title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn-action" style="background: #f59e0b; color: #fff;" title="Edit Order">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    @if($order->postex_tracking_number)
                                        <span class="postex-tracking" title="PostEx tracking number">{{ $order->postex_tracking_number }}</span>
                                    @elseif(!in_array($order->status, ['cancelled', 'delivered']))
                                        <form action="{{ route('admin.orders.postexShipment', $order->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Create a PostEx shipment for order {{ $order->order_number }}?');">
                                            @csrf
                                            <button type="submit" class="btn-action postex-action" title="Create PostEx shipment">
                                                <i class="fa-solid fa-truck"></i>
                                            </button>
                                        </form>
                                    @endif
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
                            <td colspan="9" style="text-align: center; padding: 40px; color: #999;">No orders found for this category.</td>
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

        (function () {
            var selectAll = document.getElementById('select-all-orders');
            var selectors = Array.prototype.slice.call(document.querySelectorAll('.order-selector'));
            var printButton = document.getElementById('print-selected-orders');
            if (!selectAll) return;

            function updatePrintButton() {
                var selectedCount = selectors.filter(function (checkbox) { return checkbox.checked; }).length;
                printButton.disabled = selectedCount === 0;
                printButton.innerHTML = '<i class="fa-solid fa-print"></i> Print Selected (' + selectedCount + ')';
            }

            selectAll.addEventListener('change', function () {
                selectors.forEach(function (checkbox) { checkbox.checked = selectAll.checked; });
                updatePrintButton();
            });

            selectors.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    selectAll.checked = selectors.length > 0 && selectors.every(function (item) { return item.checked; });
                    updatePrintButton();
                });
            });

            printButton.addEventListener('click', function () {
                var selectedIds = selectors.filter(function (checkbox) { return checkbox.checked; })
                    .map(function (checkbox) { return checkbox.value; });
                if (!selectedIds.length) return;
                window.open('{{ route('admin.orders.print') }}?ids=' + encodeURIComponent(selectedIds.join(',')), '_blank');
            });
        })();
    </script>

    <style>
        .status-select {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            border: 1px solid transparent;
            outline: none;
            cursor: pointer;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .status-pending { background: #fff3e0; color: #ff9800; border-color: #ffe0b2; }
        .status-processing { background: #e3f2fd; color: #2196f3; border-color: #bbdefb; }
        .status-shipped { background: #ede7f6; color: #673ab7; border-color: #d1c4e9; }
        .status-delivered { background: #e8f5e9; color: #4caf50; border-color: #c8e6c9; }
        .status-hold { background: #fff7d6; color: #a16207; border-color: #fde68a; }
        .status-cancelled { background: #ffebee; color: #f44336; border-color: #ffcdd2; }
        .order-category-badge { display: inline-block; padding: 6px 10px; background: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; border-radius: 999px; font-size: 12px; font-weight: 700; white-space: nowrap; }
        .order-duplicate-contact { display: inline-block; margin-top: 6px; padding: 3px 7px; color: #a16207; background: #fff7d6; border: 1px solid #fde68a; border-radius: 999px; font-size: 10px; font-weight: 700; white-space: nowrap; }
        .postex-action { background: #2563eb; color: #fff; }
        .postex-tracking { display: inline-block; max-width: 105px; overflow: hidden; text-overflow: ellipsis; vertical-align: middle; padding: 7px 8px; border-radius: 5px; color: #1d4ed8; background: #eff6ff; font-size: 10px; font-weight: 700; white-space: nowrap; }
        .new-orders-notice { display: flex; align-items: center; gap: 8px; margin: 0 0 18px; padding: 12px 14px; background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; color: #047857; }
        .new-orders-notice i { color: #f59e0b; }
        .new-orders-notice span { color: #4b5563; font-size: 13px; }
        .new-order-row { background: #fffbeb; }
        .new-order-row td:first-child { border-left: 4px solid #f59e0b; }
        .new-order-flag { display: inline-block; margin: 7px 0 0; padding: 3px 7px; background: #f59e0b; color: #fff; border-radius: 999px; font-size: 10px; font-weight: 800; letter-spacing: 0.5px; }
        #select-all-orders, .order-selector { width: 17px; height: 17px; accent-color: #f06292; cursor: pointer; vertical-align: middle; }
        #print-selected-orders:disabled { opacity: 0.55; cursor: not-allowed; }
        
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
