@extends('admin.layout')

@section('header_title', 'Edit Order')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.orders.view', $order->id) }}" style="text-decoration: none; color: #666; font-weight: 600;"><i class="fa-solid fa-arrow-left"></i> Back to Order Details</a>
    </div>

    <div class="content-card" style="max-width: 850px;">
        <div class="card-header"><h2>Edit {{ $order->order_number }}</h2></div>
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" style="padding: 24px;">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                <div class="form-group">
                    <label>First Name</label>
                    <input name="first_name" class="form-control" value="{{ old('first_name', $order->first_name) }}" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input name="last_name" class="form-control" value="{{ old('last_name', $order->last_name) }}" required>
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Delivery Address</label>
                    <textarea name="address" class="form-control" rows="3" required>{{ old('address', $order->address) }}</textarea>
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input name="city" class="form-control" value="{{ old('city', $order->city) }}" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input name="phone" class="form-control" value="{{ old('phone', $order->phone) }}" required>
                </div>
                <div class="form-group">
                    <label>Payment Method</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="cod" {{ old('payment_method', $order->payment_method) === 'cod' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                        <option value="online" {{ old('payment_method', $order->payment_method) === 'online' ? 'selected' : '' }}>Online Payment</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Order Status</label>
                    <select name="status" class="form-control" required>
                        @foreach(['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'] as $value => $label)
                            <option value="{{ $value }}" {{ old('status', strtolower($order->status)) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-top: 24px; display: flex; gap: 12px; align-items: center;">
                <button class="btn-primary" type="submit">Save Changes</button>
                <a href="{{ route('admin.orders.view', $order->id) }}" style="color: #666; text-decoration: none; font-weight: 600;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
