@extends('admin.layout')

@section('header_title', 'Edit Order')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.orders.view', $order->id) }}" style="text-decoration: none; color: #666; font-weight: 600;"><i class="fa-solid fa-arrow-left"></i> Back to Order Details</a>
    </div>

    <div class="content-card" style="max-width: 850px;">
        <div class="card-header"><h2>Edit {{ $order->order_number }}</h2></div>
        @if($errors->any())
            <div style="margin: 20px 24px 0; background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 6px;">{{ $errors->first() }}</div>
        @endif
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
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Customer Delivery Note</label>
                    <textarea name="delivery_note" class="form-control" rows="3" maxlength="1000" placeholder="No delivery note provided">{{ old('delivery_note', $order->delivery_note) }}</textarea>
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
                    <small style="display: block; color: #666; margin-top: 6px;">This saved method is shown to the customer on their order details.</small>
                </div>
                <div class="form-group">
                    <label>Final Order Amount (Rs)</label>
                    <input name="total_amount" type="number" min="0" step="0.01" class="form-control" value="{{ old('total_amount', $order->total_amount) }}" required>
                    <small style="display: block; color: #666; margin-top: 6px;">{{ $isMergedOrder ? 'This updates automatically when a product, quantity, or price is changed. Without product changes, you can set a final amount manually.' : 'Amount charged for this order. It updates everywhere the customer sees the order.' }}</small>
                </div>
                <div class="form-group">
                    <label>Order Status</label>
                    <select name="status" class="form-control" required>
                        @foreach(['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'hold' => 'Hold', 'cancelled' => 'Cancelled'] as $value => $label)
                            <option value="{{ $value }}" {{ old('status', strtolower($order->status)) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Order Category</label>
                    <select name="workflow_category" class="form-control" required>
                        @foreach(\App\Models\Order::workflowCategories() as $value => $label)
                            <option value="{{ $value }}" {{ old('workflow_category', $order->workflow_category ?: 'new_order') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <small style="display: block; color: #666; margin-top: 6px;">Use this category to organize and filter orders in Order Management.</small>
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>{{ $isMergedOrder ? 'Products in Merged Order' : 'Ordered Product Sizes' }}</label>
                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                        @foreach($order->items as $item)
                            <div style="padding: 12px; border-bottom: 1px solid #e2e8f0;">
                                <div style="font-weight: 700; margin-bottom: 10px;">{{ $item->product_name }} <small style="color: #64748b;">Current: Qty {{ $item->quantity }} · Rs {{ number_format($item->price) }} each · Total Rs {{ number_format($item->price * $item->quantity) }}</small></div>
                                @if($isMergedOrder)
                                    <div style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)) auto; gap: 10px; align-items: end;">
                                        <div><label style="font-size: 12px;">Quantity</label><input name="item_quantities[{{ $item->id }}]" type="number" min="0" class="form-control" value="{{ old('item_quantities.' . $item->id, $item->quantity) }}"></div>
                                        <div><label style="font-size: 12px;">Price (Rs)</label><input name="item_prices[{{ $item->id }}]" type="number" min="0" step="0.01" class="form-control" value="{{ old('item_prices.' . $item->id, $item->price) }}"></div>
                                        <div><label style="font-size: 12px;">Color</label><input name="item_colors[{{ $item->id }}]" class="form-control" value="{{ old('item_colors.' . $item->id, $item->color) }}"></div>
                                        <div><label style="font-size: 12px;">Size</label><input name="item_sizes[{{ $item->id }}]" class="form-control" value="{{ old('item_sizes.' . $item->id, $item->size) }}" placeholder="e.g. 2-4Y"></div>
                                        <label style="display: flex; align-items: center; gap: 6px; padding-bottom: 10px; color: #dc2626; font-size: 13px; font-weight: 700; white-space: nowrap;"><input type="checkbox" name="remove_item_ids[]" value="{{ $item->id }}"> Remove</label>
                                    </div>
                                @else
                                    <input name="item_sizes[{{ $item->id }}]" class="form-control" value="{{ old('item_sizes.' . $item->id, $item->size) }}" placeholder="e.g. 2-4 or Medium" style="width: 190px;">
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <small style="display: block; color: #666; margin-top: 6px;">{{ $isMergedOrder ? 'Change quantity, price, color, size, or tick Remove. Save Changes applies all updates.' : 'Write the required size for any product, then save changes.' }}</small>
                </div>
                @if($isMergedOrder)
                    <div class="form-group" style="grid-column: 1 / -1; padding: 18px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <label style="font-size: 16px;">Add Product to Merged Order</label>
                        <div style="display: grid; grid-template-columns: 2fr repeat(4, minmax(0, 1fr)); gap: 10px; margin-top: 10px;">
                            <div><label style="font-size: 12px;">Product</label><select name="new_product_id" class="form-control"><option value="">Select product</option>@foreach($availableProducts as $product)<option value="{{ $product->id }}" {{ old('new_product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>@endforeach</select></div>
                            <div><label style="font-size: 12px;">Quantity</label><input name="new_product_quantity" type="number" min="1" class="form-control" value="{{ old('new_product_quantity', 1) }}"></div>
                            <div><label style="font-size: 12px;">Price (Rs)</label><input name="new_product_price" type="number" min="0" step="0.01" class="form-control" value="{{ old('new_product_price') }}" placeholder="Product price"></div>
                            <div><label style="font-size: 12px;">Color</label><input name="new_product_color" class="form-control" value="{{ old('new_product_color') }}"></div>
                            <div><label style="font-size: 12px;">Size</label><input name="new_product_size" class="form-control" value="{{ old('new_product_size') }}" placeholder="e.g. 2-4Y"></div>
                        </div>
                        <small style="display: block; color: #666; margin-top: 8px;">For size-wise stock products, enter the exact available size. Adding a product reserves its stock.</small>
                    </div>
                @endif
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Coupon Code (Optional)</label>
                    <input name="coupon_code" class="form-control" value="{{ old('coupon_code', $order->coupon_code) }}" placeholder="Enter an active coupon code, or clear to remove it" style="text-transform: uppercase;">
                    <small style="display: block; color: #666; margin-top: 6px;">Coupon discount is saved with the order. The Final Order Amount above remains the amount charged to the customer.</small>
                    @if($order->coupon_code)
                        <label style="display: inline-flex; align-items: center; gap: 8px; margin-top: 12px; color: #dc2626; font-weight: 700; cursor: pointer;">
                            <input type="checkbox" name="remove_coupon" value="1" onchange="document.querySelector('[name=coupon_code]').disabled = this.checked;">
                            Remove coupon from this order
                        </label>
                    @endif
                </div>
            </div>

            <div style="margin-top: 24px; display: flex; gap: 12px; align-items: center;">
                <button class="btn-primary" type="submit">Save Changes</button>
                <a href="{{ route('admin.orders.view', $order->id) }}" style="color: #666; text-decoration: none; font-weight: 600;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
