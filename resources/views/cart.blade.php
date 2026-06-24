@include('partials.header')

<style>
/* ── Cart Page ── */
.cart-page {
    background: #fdfdfd;
    min-height: calc(100vh - 120px);
    padding: 40px 60px 80px;
}
.cart-container {
    max-width: 1100px;
    margin: 0 auto;
}

/* Breadcrumb */
.cart-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #000;
    margin-bottom: 25px;
}
.cart-breadcrumb a { color: #555; text-decoration: none; }
.cart-breadcrumb span { color: #999; }

/* Header */
.cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
}
.cart-title {
    font-size: 32px;
    font-weight: 800;
    color: #000;
}
.cart-continue {
    font-size: 14.5px;
    color: #000;
    text-decoration: underline;
    font-weight: 500;
}

/* Main Content Layout */
.cart-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 60px;
    align-items: flex-start;
}

/* Table styling */
.cart-table-head {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
    margin-bottom: 30px;
}
.cart-th {
    font-size: 11px;
    font-weight: 700;
    color: #000;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.cart-th.text-right { text-align: right; }

/* Cart Item */
.cart-item {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    align-items: center;
    margin-bottom: 35px;
}
.cart-item-info {
    display: flex;
    gap: 20px;
    align-items: center;
}
.cart-item-img {
    width: 100px;
    height: 110px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #f0f0f0;
}
.cart-item-details h3 {
    font-size: 16px;
    font-weight: 700;
    color: #000;
    margin-bottom: 6px;
}
.cart-item-price {
    font-size: 15px;
    color: #000;
    margin-bottom: 4px;
}

/* Quantity controls */
.cart-item-qty-wrap {
    display: flex;
    align-items: center;
    gap: 15px;
}
.cart-qty-box {
    display: flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 2px;
}
.cart-qty-btn {
    width: 32px;
    height: 36px;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    color: #000;
    display: flex;
    align-items: center;
    justify-content: center;
}
.cart-qty-input {
    width: 40px;
    height: 36px;
    border: none;
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    text-align: center;
    font-size: 14px;
    font-weight: 600;
    color: #000;
}
.cart-item-remove-btn {
    background: none;
    border: none;
    color: #000;
    cursor: pointer;
    transition: color 0.2s;
}
.cart-item-remove-btn:hover { color: #f44336; }

.cart-item-total {
    font-size: 18px;
    font-weight: 600;
    color: #000;
    text-align: right;
}

/* Sidebar Summary */
.cart-summary {
    position: sticky;
    top: 100px;
}
.cart-summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.cart-summary-label {
    font-size: 17px;
    font-weight: 700;
    color: #000;
}
.cart-summary-value {
    font-size: 22px;
    font-weight: 800;
    color: #000;
}
.cart-summary-note {
    font-size: 13px;
    color: #000;
    margin-bottom: 25px;
    line-height: 1.5;
    border-top: 1px solid #eee;
    padding-top: 20px;
}
.cart-checkout-btn {
    display: block;
    width: 100%;
    background: #4fc3f7;
    color: #fff;
    text-align: center;
    padding: 15px 0;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.2s;
}
.cart-checkout-btn:hover { background: #29b6f6; }

/* Responsive */
@media (max-width: 900px) {
    .cart-layout { grid-template-columns: 1fr; gap: 40px; }
    .cart-page { padding: 30px 20px 60px; }
}
@media (max-width: 600px) {
    .cart-table-head { display: none; }
    .cart-item {
        grid-template-columns: 1fr;
        gap: 20px;
        border-bottom: 1px solid #f5f5f5;
        padding-bottom: 25px;
    }
    .cart-item-total { text-align: left; }
}
</style>

<div class="cart-page">
    <div class="cart-container">

        <!-- Breadcrumb -->
        <nav class="cart-breadcrumb">
            <a href="{{ route('home') }}">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Home
            </a>
            <span>›</span>
            <span>Your Shopping Cart</span>
        </nav>

        <!-- Header -->
        <div class="cart-header">
            <h1 class="cart-title">Your Cart</h1>
            <a href="{{ route('products.index') }}" class="cart-continue">Continue Shopping</a>
        </div>

        @if(count($cart) > 0)
            <div class="cart-layout">
                
                <!-- Left Side: Items List -->
                <div class="cart-items-col">
                    
                    <!-- Table Head -->
                    <div class="cart-table-head">
                        <div class="cart-th">Product</div>
                        <div class="cart-th">Quantity</div>
                        <div class="cart-th text-right">Total</div>
                    </div>

                    @php $grandTotal = 0; @endphp
                    @foreach($cart as $id => $details)
                        @php 
                            $itemTotal = $details['price'] * $details['quantity'];
                            $grandTotal += $itemTotal;
                        @endphp
                        <!-- Item -->
                        <div class="cart-item">
                            <div class="cart-item-info">
                                <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="cart-item-img">
                                <div class="cart-item-details">
                                    <h3>{{ $details['name'] }}</h3>
                                    <p class="cart-item-price">Rs {{ number_format($details['price']) }}</p>
                                </div>
                            </div>
                            <div class="cart-item-qty-wrap">
                                <div class="cart-qty-box">
                                    <button class="cart-qty-btn" type="button">−</button>
                                    <input type="text" class="cart-qty-input" value="{{ $details['quantity'] }}" readonly>
                                    <button class="cart-qty-btn" type="button">+</button>
                                </div>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="cart-item-remove-btn" title="Remove Item">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </form>
                            </div>
                            <div class="cart-item-total">Rs {{ number_format($itemTotal) }}</div>
                        </div>
                    @endforeach

                    <div style="border-top:1px solid #eee; margin-top:20px;"></div>

                </div>

                <!-- Right Side: Summary -->
                <aside class="cart-summary">
                    <div class="cart-summary-row">
                        <span class="cart-summary-label">Estimated Total:</span>
                        <span class="cart-summary-value">Rs {{ number_format($grandTotal) }}</span>
                    </div>
                    <div class="cart-summary-note">
                        Taxes and shipping calculated at checkout.
                    </div>
                    <a href="{{ route('checkout') }}" class="cart-checkout-btn">Check out</a>
                </aside>

            </div>
        @else
            <!-- Empty Cart State -->
            <div style="text-align: center; padding: 100px 20px;">
                <div style="margin-bottom: 24px; color: #ddd;">
                    <svg width="80" height="80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                </div>
                <h2 style="font-size: 24px; font-weight: 700; color: #111; margin-bottom: 12px;">Your cart is currently empty</h2>
                <p style="color: #666; margin-bottom: 32px; font-size: 15px;">Before proceed to checkout you must add some products to your shopping cart.<br>You will find a lot of interesting products on our "Shop" page.</p>
                <a href="{{ route('products.index') }}" style="display: inline-block; padding: 14px 40px; background: #4fc3f7; color: #fff; border-radius: 4px; font-weight: 700; text-decoration: none; transition: background 0.2s;">Start Shopping</a>
            </div>
        @endif
    </div>
</div>

@include('partials.footer')
