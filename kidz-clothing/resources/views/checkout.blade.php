@include('partials.header')

<style>
/* ── Checkout Page ── */
.checkout-page {
    background: #fdfdfd;
    min-height: calc(100vh - 120px);
    padding: 40px 60px 80px;
}
.checkout-container {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 60px;
}

.checkout-section {
    margin-bottom: 40px;
}
.checkout-section-title {
    font-size: 20px;
    font-weight: 700;
    color: #000;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Form Styling */
.checkout-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}
.checkout-form-group {
    margin-bottom: 15px;
}
.checkout-form-group.full {
    grid-column: 1 / -1;
}
.checkout-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #555;
    margin-bottom: 6px;
}
.checkout-input {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    color: #000;
    transition: border-color 0.2s;
}
.checkout-input:focus {
    border-color: #4fc3f7;
    outline: none;
}

/* Payment option */
.checkout-payment-box {
    border: 1px solid #4fc3f7;
    background: #f1faff;
    padding: 20px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.checkout-payment-radio {
    width: 18px;
    height: 18px;
    accent-color: #4fc3f7;
}
.checkout-payment-label {
    font-weight: 700;
    font-size: 15px;
    color: #000;
}

/* Sidebar Order Summary */
.checkout-order-summary {
    background: #fff;
    border: 1px solid #eee;
    padding: 30px;
    border-radius: 8px;
    position: sticky;
    top: 100px;
}
.order-item {
    display: flex;
    gap: 15px;
    align-items: center;
    margin-bottom: 15px;
}
.order-item-img {
    width: 60px;
    height: 70px;
    object-fit: cover;
    border-radius: 4px;
}
.order-item-details {
    flex: 1;
}
.order-item-name {
    font-size: 14px;
    font-weight: 700;
    color: #000;
}
.order-item-price {
    font-size: 13px;
    color: #666;
}
.order-total-row {
    display: flex;
    justify-content: space-between;
    padding-top: 15px;
    margin-top: 15px;
    border-top: 1px solid #eee;
}
.order-total-label {
    font-size: 18px;
    font-weight: 700;
    color: #000;
}
.order-total-value {
    font-size: 18px;
    font-weight: 800;
    color: #000;
}

.place-order-btn {
    width: 100%;
    background: #000;
    color: #fff;
    padding: 18px;
    border: none;
    border-radius: 4px;
    font-size: 15px;
    font-weight: 700;
    margin-top: 30px;
    cursor: pointer;
    transition: background 0.2s;
}
.place-order-btn:hover { background: #333; }

/* Responsive */
@media (max-width: 900px) {
    .checkout-container { grid-template-columns: 1fr; gap: 40px; }
}
</style>

<div class="checkout-page">
    <form action="{{ route('checkout.placeOrder') }}" method="POST">
        @csrf
        <div class="checkout-container">
            
            <!-- Left Side: Shipping Info -->
            <div class="checkout-main">
                
                <div class="checkout-section">
                    <h2 class="checkout-section-title">Shipping Information</h2>
                    <div class="checkout-form-grid">
                        <div class="checkout-form-group">
                            <label class="checkout-label">First Name</label>
                            <input type="text" name="first_name" class="checkout-input" placeholder="Enter your first name" required>
                        </div>
                        <div class="checkout-form-group">
                            <label class="checkout-label">Last Name</label>
                            <input type="text" name="last_name" class="checkout-input" placeholder="Enter your last name" required>
                        </div>
                        <div class="checkout-form-group full">
                            <label class="checkout-label">Address</label>
                            <input type="text" name="address" class="checkout-input" placeholder="House #, Street, Area" required>
                        </div>
                        <div class="checkout-form-group">
                            <label class="checkout-label">City</label>
                            <input type="text" name="city" class="checkout-input" placeholder="Enter your city" required>
                        </div>
                        <div class="checkout-form-group">
                            <label class="checkout-label">Phone Number</label>
                            <input type="text" name="phone" class="checkout-input" placeholder="e.g. 0300 1234567" required>
                        </div>
                    </div>
                </div>

                <div class="checkout-section">
                    <h2 class="checkout-section-title">Payment Method</h2>
                    <div class="checkout-payment-box">
                        <input type="radio" name="payment_method" value="cod" class="checkout-payment-radio" checked>
                        <span class="checkout-payment-label">Cash on Delivery (COD)</span>
                    </div>
                    <p style="font-size: 13px; color: #666; margin-top: 10px;">Pay with cash upon delivery. No hidden charges.</p>
                </div>

            </div>

            <!-- Right Side: Order Summary -->
            <aside class="checkout-summary-col">
                <div class="checkout-order-summary">
                    <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 20px;">Order Summary</h3>
                    
                    @foreach($cart as $item)
                    <div class="order-item">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="order-item-img">
                        <div class="order-item-details">
                            <div class="order-item-name">{{ $item['name'] }}</div>
                            <div class="order-item-price">Qty: {{ $item['quantity'] }} × Rs {{ number_format($item['price']) }}</div>
                        </div>
                    </div>
                    @endforeach

                    <div class="order-total-row">
                        <span class="order-total-label">Total Amount:</span>
                        <span class="order-total-value">Rs {{ number_format($total) }}</span>
                    </div>

                    <button type="submit" class="place-order-btn">Complete Purchase</button>
                </div>
            </aside>

        </div>
    </form>
</div>

@include('partials.footer')
