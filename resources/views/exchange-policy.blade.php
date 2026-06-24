@include('partials.header')

<style>
/* ── Policy Pages (pol-) ── */
.pol-hero {
    background: linear-gradient(135deg, #f06292 0%, #ec407a 100%);
    padding: 60px 24px 80px;
    text-align: center;
    color: #fff;
    position: relative;
    overflow: hidden;
}
.pol-hero::before {
    content: '';
    position: absolute;
    top: -40%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
    pointer-events: none;
}
.pol-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    backdrop-filter: blur(6px);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    padding: 6px 16px;
    border-radius: 20px;
    margin-bottom: 18px;
    letter-spacing: 0.3px;
}
.pol-hero h1 {
    font-size: 40px;
    font-weight: 800;
    margin-bottom: 12px;
    line-height: 1.2;
}
.pol-hero p {
    font-size: 16px;
    opacity: 0.9;
    max-width: 520px;
    margin: 0 auto;
    line-height: 1.6;
}
.pol-body {
    max-width: 860px;
    margin: -36px auto 70px;
    padding: 0 24px;
    position: relative;
    z-index: 2;
}
.pol-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.09);
    overflow: hidden;
}
.pol-updated {
    background: #fce4ec;
    color: #c2185b;
    font-size: 13px;
    font-weight: 600;
    padding: 12px 28px;
    border-bottom: 1px solid #f8bbd0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pol-content {
    padding: 36px 40px 44px;
}
.pol-intro {
    font-size: 15px;
    color: #444;
    line-height: 1.8;
    margin-bottom: 36px;
    padding-bottom: 28px;
    border-bottom: 2px dashed #f0f0f0;
}
.pol-section {
    margin-bottom: 36px;
}
.pol-section-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 16px;
}
.pol-section-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: linear-gradient(135deg, #fce4ec, #f8bbd0);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.pol-section h2 {
    font-size: 19px;
    font-weight: 700;
    color: #111;
    margin: 0;
}
.pol-section p,
.pol-section li {
    font-size: 14.5px;
    color: #444;
    line-height: 1.8;
}
.pol-section ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.pol-section ul li {
    padding-left: 22px;
    position: relative;
}
.pol-section ul li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #f06292;
    font-weight: 700;
    font-size: 13px;
}
.pol-highlight {
    background: linear-gradient(135deg, #fce4ec 0%, #fce8f0 100%);
    border-left: 4px solid #f06292;
    border-radius: 0 10px 10px 0;
    padding: 16px 20px;
    margin: 16px 0;
    font-size: 14.5px;
    color: #333;
    line-height: 1.7;
}
.pol-steps {
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-top: 14px;
}
.pol-step {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: #faf9f7;
    border-radius: 12px;
    padding: 16px 18px;
    border: 1px solid #f0f0f0;
}
.pol-step-num {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #f06292;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.pol-step-text {
    font-size: 14.5px;
    color: #333;
    line-height: 1.6;
}
.pol-step-text strong {
    color: #111;
    display: block;
    margin-bottom: 3px;
}
.pol-divider {
    border: none;
    border-top: 1px solid #f0f0f0;
    margin: 28px 0;
}
.pol-cta-box {
    background: linear-gradient(135deg, #f06292 0%, #ec407a 100%);
    border-radius: 14px;
    padding: 28px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 36px;
}
.pol-cta-box h3 {
    font-size: 17px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 4px;
}
.pol-cta-box p {
    font-size: 14px;
    color: rgba(255,255,255,0.85);
    margin: 0;
}
.pol-cta-btn {
    display: inline-block;
    padding: 11px 28px;
    background: #fff;
    color: #f06292;
    font-size: 14px;
    font-weight: 700;
    border-radius: 30px;
    text-decoration: none;
    white-space: nowrap;
    transition: transform 0.2s, box-shadow 0.2s;
}
.pol-cta-btn:hover { transform: scale(1.04); box-shadow: 0 4px 16px rgba(0,0,0,0.15); }
.pol-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: rgba(255,255,255,0.85);
    margin-bottom: 18px;
    justify-content: center;
}
.pol-breadcrumb a { color: rgba(255,255,255,0.85); text-decoration: none; }
.pol-breadcrumb a:hover { color: #fff; }
@media (max-width: 640px) {
    .pol-hero h1 { font-size: 28px; }
    .pol-content { padding: 24px 20px 32px; }
    .pol-cta-box { flex-direction: column; text-align: center; }
    .pol-section-header { gap: 10px; }
}
</style>

<!-- Hero -->
<div class="pol-hero">
    <nav class="pol-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        <span>Exchange Policy</span>
    </nav>
    <div class="pol-hero-badge">🔄 Exchange Policy</div>
    <h1>Exchange Policy</h1>
    <p>We want every little one to love what they wear. Here's how easy it is to exchange an item.</p>
</div>

<!-- Content -->
<div class="pol-body">
    <div class="pol-card">

        <div class="pol-updated">
            📅 &nbsp;Last Updated: May 2026
        </div>

        <div class="pol-content">

            <p class="pol-intro">
                At <strong>Kidz Wear</strong>, we understand that sizing can be tricky for growing kids. That's why we offer a hassle-free exchange policy to make sure your child gets the perfect fit. Please read the guidelines below before initiating an exchange.
            </p>

            <!-- Eligibility -->
            <div class="pol-section">
                <div class="pol-section-header">
                    <div class="pol-section-icon">✅</div>
                    <h2>Exchange Eligibility</h2>
                </div>
                <p>Items are eligible for exchange if they meet <strong>all</strong> of the following conditions:</p>
                <ul style="margin-top:12px;">
                    <li>Item is exchanged within <strong>7 days</strong> of delivery</li>
                    <li>Item is unworn, unwashed, and in original condition</li>
                    <li>All original tags and labels are still attached</li>
                    <li>Item is returned in its original packaging</li>
                    <li>Proof of purchase (order number or receipt) is provided</li>
                </ul>
            </div>

            <hr class="pol-divider">

            <!-- Non-eligible -->
            <div class="pol-section">
                <div class="pol-section-header">
                    <div class="pol-section-icon">🚫</div>
                    <h2>Non-Exchangeable Items</h2>
                </div>
                <ul>
                    <li>Items marked as <strong>Final Sale</strong> or <strong>Clearance</strong></li>
                    <li>Items that have been worn, washed, or altered</li>
                    <li>Items missing original tags or packaging</li>
                    <li>Undergarments and swimwear (for hygiene reasons)</li>
                    <li>Gift cards or promotional items</li>
                </ul>
            </div>

            <hr class="pol-divider">

            <!-- How to Exchange -->
            <div class="pol-section">
                <div class="pol-section-header">
                    <div class="pol-section-icon">📦</div>
                    <h2>How to Initiate an Exchange</h2>
                </div>
                <div class="pol-steps">
                    <div class="pol-step">
                        <div class="pol-step-num">1</div>
                        <div class="pol-step-text">
                            <strong>Contact Us</strong>
                            Email us at <strong>support@kidzwear.pk</strong> or WhatsApp us with your order number and the item you'd like to exchange.
                        </div>
                    </div>
                    <div class="pol-step">
                        <div class="pol-step-num">2</div>
                        <div class="pol-step-text">
                            <strong>Approval & Instructions</strong>
                            Our team will review your request and send you a return address along with packaging instructions within 24–48 hours.
                        </div>
                    </div>
                    <div class="pol-step">
                        <div class="pol-step-num">3</div>
                        <div class="pol-step-text">
                            <strong>Ship the Item</strong>
                            Pack the item securely and ship it back to us. Customer is responsible for return shipping charges unless the exchange is due to a defect or our error.
                        </div>
                    </div>
                    <div class="pol-step">
                        <div class="pol-step-num">4</div>
                        <div class="pol-step-text">
                            <strong>Receive Your Exchange</strong>
                            Once we receive and inspect the item, we'll dispatch your replacement within <strong>3–5 business days</strong>.
                        </div>
                    </div>
                </div>
            </div>

            <hr class="pol-divider">

            <!-- Defective Items -->
            <div class="pol-section">
                <div class="pol-section-header">
                    <div class="pol-section-icon">🛡️</div>
                    <h2>Defective or Wrong Items</h2>
                </div>
                <div class="pol-highlight">
                    If you received a defective product or the wrong item, please contact us within <strong>48 hours of delivery</strong> with photos of the item. We will arrange a free replacement or full refund at no additional cost to you.
                </div>
            </div>

            <!-- CTA -->
            <div class="pol-cta-box">
                <div>
                    <h3>Need help with an exchange?</h3>
                    <p>Our support team is ready to assist you.</p>
                </div>
                <a href="{{ route('contact') }}" class="pol-cta-btn">Contact Us</a>
            </div>

        </div>
    </div>
</div>

@include('partials.footer')
