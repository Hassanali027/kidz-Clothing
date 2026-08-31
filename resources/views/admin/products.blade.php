@extends('admin.layout')

@section('header_title', 'Product Management')

@section('content')
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            ✗ {{ session('error') }}
        </div>
    @endif

    <div class="content-card">
        <div class="card-header">
            <h2>Product List ({{ $products->count() }} Products)</h2>
            <a href="{{ route('admin.products.add') }}" class="btn-primary">+ Add New Product</a>
        </div>

        <div class="admin-table-wrap">
            @if($products->count() > 0)
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Age Group</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    @if($product->images && count($product->images) > 0)
                                        <img src="{{ asset($product->images[0]) }}" width="50" height="50" style="border-radius: 6px; object-fit: cover; border: 1px solid #e2e8f0;">
                                    @else
                                        <div style="width: 50px; height: 50px; background: #e2e8f0; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa-solid fa-image" style="color: #94a3b8;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $product->name }}</strong></td>
                                <td>{{ ucfirst($product->category) }} Wear</td>
                                <td>{{ $product->age_group }}</td>
                                <td>
                                    @if($product->sale_price)
                                        <span style="text-decoration: line-through; color: #94a3b8; font-size: 13px;">Rs. {{ number_format($product->price, 0) }}</span><br>
                                        <strong style="color: #f06292;">Rs. {{ number_format($product->sale_price, 0) }}</strong>
                                    @else
                                        <strong>Rs. {{ number_format($product->price, 0) }}</strong>
                                    @endif
                                </td>
                                <td>{{ $product->stock_quantity }}</td>
                                <td>
                                    @if($product->status == 'active')
                                        <span class="status-badge status-success">Active</span>
                                    @elseif($product->status == 'inactive')
                                        <span class="status-badge status-pending">Inactive</span>
                                    @else
                                        <span class="status-badge status-danger">Out of Stock</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" style="color: var(--secondary-color); margin-right: 10px;" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" style="display: inline;" class="delete-form">
                                        @csrf
                                        <button type="button" class="delete-btn" style="background: none; border: none; color: #f87171; cursor: pointer; padding: 0;" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 60px 20px; color: #64748b;">
                    <i class="fa-solid fa-box-open" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                    <h3 style="margin-bottom: 8px; color: #334155;">No Products Found</h3>
                    <p style="margin-bottom: 20px;">Start by adding your first product</p>
                    <a href="{{ route('admin.products.add') }}" class="btn-primary">+ Add New Product</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Undo Delete Notification -->
    <div id="undo-notification" style="display: none; position: fixed; bottom: 30px; right: 30px; background: #1e293b; color: white; padding: 16px 24px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); z-index: 9999; min-width: 300px;">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px;">
            <span id="undo-message">Product will be deleted in <strong id="countdown">5</strong>s</span>
            <button id="undo-btn" style="background: #f06292; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600;">Undo</button>
        </div>
    </div>

    <script>
        let deleteTimeout;
        let countdownInterval;
        let currentForm;

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentForm = this.closest('.delete-form');
                showUndoNotification();
            });
        });

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
@endsection
