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
    @if(session('error'))
        <div style="max-width: 1120px; margin: 0 auto 20px; background: #f8d7da; color: #721c24; padding: 13px 16px; border-radius: 6px;">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div style="max-width: 1120px; margin: 0 auto 20px; background: #f8d7da; color: #721c24; padding: 13px 16px; border-radius: 6px;">{{ $errors->first() }}</div>
    @endif
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
                            <input type="text" name="first_name" class="checkout-input" value="{{ old('first_name', auth()->user()->name ?? '') }}" placeholder="Enter your first name" required>
                        </div>
                        <div class="checkout-form-group">
                            <label class="checkout-label">Last Name</label>
                            <input type="text" name="last_name" class="checkout-input" value="{{ old('last_name') }}" placeholder="Enter your last name" required>
                        </div>
                        <div class="checkout-form-group full">
                            <label class="checkout-label">Address</label>
                            <input type="text" name="address" class="checkout-input" value="{{ old('address', auth()->user()->address ?? '') }}" placeholder="House #, Street, Area" required>
                        </div>
                        <div class="checkout-form-group">
                            <label class="checkout-label">City</label>
                            <input type="text" name="city" class="checkout-input" value="{{ old('city', auth()->user()->city ?? '') }}" placeholder="Enter your city" required>
                        </div>
                        <div class="checkout-form-group">
                            <label class="checkout-label">Phone Number</label>
                            <input type="text" name="phone" class="checkout-input" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="e.g. 0300 1234567" required>
                        </div>
                    </div>
                </div>

                <div class="checkout-section">
                    <h2 class="checkout-section-title">Payment Method</h2>
                    <div class="checkout-payment-box" id="cod-payment-box">
                        <input type="radio" name="payment_method" value="cod" class="checkout-payment-radio" checked onchange="updateTotal()">
                        <span class="checkout-payment-label">Cash on Delivery (COD)</span>
                    </div>
                    
                    <div class="checkout-payment-box" id="online-payment-box" style="margin-top: 15px; border-color: #ddd; background: #fff;">
                        <input type="radio" name="payment_method" value="online" class="checkout-payment-radio" onchange="updateTotal()">
                        <span class="checkout-payment-label">5% Discount - Online Payment</span>
                    </div>
                    <div id="online-payment-details" style="display: none; background: #f5f5f5; padding: 15px; border-radius: 4px; border: 1px solid #ddd; margin-top: -4px; border-top: none;">
                        <p style="font-size: 13px; color: #444; line-height: 1.6;">
                            <strong>JazzCash / EasyPaisa:</strong> 03034280347 (Muhammad Ahsan Mazhar)<br>
                            <strong>Bank Transfer:</strong> Soneri Bank, Account No: 20008214787<br>
                            Please send a screenshot of payment on WhatsApp: <strong>03034280347</strong>
                        </p>
                    </div>
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

                    <div style="margin: 20px 0;">
                        <label class="checkout-label" for="coupon_code">Coupon Code</label>
                        <input type="text" id="coupon_code" name="coupon_code" class="checkout-input" value="{{ old('coupon_code') }}" placeholder="Enter coupon code" style="text-transform: uppercase;">
                        @guest
                            <p style="font-size: 12px; color: #666; margin: 7px 0 0;">To use a coupon, please <a href="{{ route('login') }}" style="color: #0288d1; font-weight: 700;">log in</a> first.</p>
                        @endguest
                    </div>

                    <div id="discount-row" class="order-total-row" style="display: none; border-top: none; padding-top: 5px; margin-top: 5px;">
                        <span class="order-total-label" style="font-size: 15px; font-weight: 600; color: #4caf50;">Discount (5%):</span>
                        <span class="order-total-value" style="font-size: 15px; font-weight: 600; color: #4caf50;">-Rs <span id="discount-amount">0</span></span>
                    </div>
                    <div class="order-total-row">
                        <span class="order-total-label">Total Amount:</span>
                        <span class="order-total-value">Rs <span id="final-total">{{ number_format($total) }}</span></span>
                    </div>

                    <button type="submit" class="place-order-btn">Complete Purchase</button>
                </div>
            </aside>

        </div>
    </form>
</div>

<script>
    const totalAmount = {{ $total }};
    
    function updateTotal() {
        const method = document.querySelector('input[name="payment_method"]:checked').value;
        const discountRow = document.getElementById('discount-row');
        const discountAmountEl = document.getElementById('discount-amount');
        const finalTotalEl = document.getElementById('final-total');
        const onlineBox = document.getElementById('online-payment-box');
        const codBox = document.getElementById('cod-payment-box');
        const onlineDetails = document.getElementById('online-payment-details');

        if (method === 'online') {
            const discount = Math.round(totalAmount * 0.05);
            const final = totalAmount - discount;
            
            discountRow.style.display = 'flex';
            discountAmountEl.textContent = discount.toLocaleString();
            finalTotalEl.textContent = final.toLocaleString();
            
            onlineBox.style.borderColor = '#4fc3f7';
            onlineBox.style.background = '#f1faff';
            codBox.style.borderColor = '#ddd';
            codBox.style.background = '#fff';
            onlineDetails.style.display = 'block';
        } else {
            discountRow.style.display = 'none';
            finalTotalEl.textContent = totalAmount.toLocaleString();
            
            codBox.style.borderColor = '#4fc3f7';
            codBox.style.background = '#f1faff';
            onlineBox.style.borderColor = '#ddd';
            onlineBox.style.background = '#fff';
            onlineDetails.style.display = 'none';
        }
    }
</script>

@include('partials.footer')
