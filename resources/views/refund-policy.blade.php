@include('partials.header')

<style>
/* ── Policy Pages (pol-) — shared with exchange-policy ── */
.pol-hero {
    background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
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
.pol-hero h1 { font-size: 40px; font-weight: 800; margin-bottom: 12px; line-height: 1.2; }
.pol-hero p { font-size: 16px; opacity: 0.9; max-width: 520px; margin: 0 auto; line-height: 1.6; }
.pol-body { max-width: 860px; margin: -36px auto 70px; padding: 0 24px; position: relative; z-index: 2; }
.pol-card { background: #fff; border-radius: 18px; box-shadow: 0 8px 40px rgba(0,0,0,0.09); overflow: hidden; }
.pol-updated {
    background: #ede9fe;
    color: #6d28d9;
    font-size: 13px;
    font-weight: 600;
    padding: 12px 28px;
    border-bottom: 1px solid #ddd6fe;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pol-content { padding: 36px 40px 44px; }
.pol-intro { font-size: 15px; color: #444; line-height: 1.8; margin-bottom: 36px; padding-bottom: 28px; border-bottom: 2px dashed #f0f0f0; }
.pol-section { margin-bottom: 36px; }
.pol-section-header { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
.pol-section-icon {
    width: 42px; height: 42px; border-radius: 12px;
    background: linear-gradient(135deg, #ede9fe, #ddd6fe);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.pol-section h2 { font-size: 19px; font-weight: 700; color: #111; margin: 0; }
.pol-section p, .pol-section li { font-size: 14.5px; color: #444; line-height: 1.8; }
.pol-section ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px; }
.pol-section ul li { padding-left: 22px; position: relative; }
.pol-section ul li::before { content: '✓'; position: absolute; left: 0; color: #7c3aed; font-weight: 700; font-size: 13px; }
.pol-highlight {
    background: linear-gradient(135deg, #ede9fe 0%, #f3f0ff 100%);
    border-left: 4px solid #7c3aed;
    border-radius: 0 10px 10px 0;
    padding: 16px 20px; margin: 16px 0;
    font-size: 14.5px; color: #333; line-height: 1.7;
}
.pol-timeline { display: flex; flex-direction: column; gap: 0; margin-top: 14px; position: relative; }
.pol-tl-item { display: flex; gap: 18px; padding-bottom: 24px; position: relative; }
.pol-tl-item:last-child { padding-bottom: 0; }
.pol-tl-left { display: flex; flex-direction: column; align-items: center; }
.pol-tl-dot {
    width: 36px; height: 36px; border-radius: 50%;
    background: #7c3aed; color: #fff;
    font-size: 13px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.pol-tl-line { width: 2px; flex: 1; background: #e9d5ff; margin-top: 4px; min-height: 20px; }
.pol-tl-item:last-child .pol-tl-line { display: none; }
.pol-tl-body { padding-top: 6px; }
.pol-tl-body strong { display: block; font-size: 15px; color: #111; margin-bottom: 4px; }
.pol-tl-body span { font-size: 14px; color: #555; line-height: 1.6; }
.pol-table { width: 100%; border-collapse: collapse; margin-top: 14px; font-size: 14px; }
.pol-table th { background: #7c3aed; color: #fff; padding: 12px 16px; text-align: left; font-weight: 600; }
.pol-table td { padding: 12px 16px; border-bottom: 1px solid #f0f0f0; color: #444; vertical-align: top; }
.pol-table tr:last-child td { border-bottom: none; }
.pol-table tr:nth-child(even) td { background: #faf9ff; }
.pol-divider { border: none; border-top: 1px solid #f0f0f0; margin: 28px 0; }
.pol-cta-box {
    background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
    border-radius: 14px; padding: 28px 30px;
    display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; margin-top: 36px;
}
.pol-cta-box h3 { font-size: 17px; font-weight: 700; color: #fff; margin: 0 0 4px; }
.pol-cta-box p { font-size: 14px; color: rgba(255,255,255,0.85); margin: 0; }
.pol-cta-btn {
    display: inline-block; padding: 11px 28px;
    background: #fff; color: #7c3aed;
    font-size: 14px; font-weight: 700; border-radius: 30px; text-decoration: none;
    white-space: nowrap; transition: transform 0.2s, box-shadow 0.2s;
}
.pol-cta-btn:hover { transform: scale(1.04); box-shadow: 0 4px 16px rgba(0,0,0,0.15); }
.pol-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 14px; color: rgba(255,255,255,0.85); margin-bottom: 18px; justify-content: center; }
.pol-breadcrumb a { color: rgba(255,255,255,0.85); text-decoration: none; }
.pol-breadcrumb a:hover { color: #fff; }
@media (max-width: 640px) {
    .pol-hero h1 { font-size: 28px; }
    .pol-content { padding: 24px 20px 32px; }
    .pol-cta-box { flex-direction: column; text-align: center; }
    .pol-table th, .pol-table td { padding: 10px 12px; font-size: 13px; }
}
</style>

<!-- Hero -->
<div class="pol-hero">
    <nav class="pol-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        <span>Refund Policy</span>
    </nav>
    <div class="pol-hero-badge">💰 Refund Policy</div>
    <h1>Refund Policy</h1>
    <p>Your satisfaction is our priority. Learn about our straightforward refund process and what to expect.</p>
</div>

<!-- Content -->
<div class="pol-body">
    <div class="pol-card">

        <div class="pol-updated">
            📅 &nbsp;Last Updated: May 2026
        </div>

        <div class="pol-content">

            <p class="pol-intro">
                At <strong>Kidz Wear</strong>, we stand behind the quality of everything we sell. If you're not completely satisfied with your purchase, our refund policy ensures a smooth and transparent resolution. Please read the information below carefully.
            </p>

            <!-- Eligibility -->
            <div class="pol-section">
                <div class="pol-section-header">
                    <div class="pol-section-icon">✅</div>
                    <h2>Refund Eligibility</h2>
                </div>
                <p>You may be eligible for a refund if:</p>
                <ul style="margin-top:12px;">
                    <li>You received a <strong>defective or damaged</strong> item</li>
                    <li>You received the <strong>wrong item</strong> (wrong size, color, or product)</li>
                    <li>Your order was <strong>lost in transit</strong> and not delivered</li>
                    <li>The item significantly <strong>differs from its description</strong> on the website</li>
                    <li>Refund request is raised within <strong>7 days</strong> of delivery</li>
                </ul>
            </div>

            <hr class="pol-divider">

            <!-- Refund Timeline Table -->
            <div class="pol-section">
                <div class="pol-section-header">
                    <div class="pol-section-icon">⏱️</div>
                    <h2>Refund Timeframes</h2>
                </div>
                <table class="pol-table">
                    <thead>
                        <tr>
                            <th>Refund Method</th>
                            <th>Processing Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Bank Transfer / EasyPaisa / JazzCash</td>
                            <td>3–5 business days after approval</td>
                        </tr>
                        <tr>
                            <td>Store Credit / Voucher</td>
                            <td>Within 24 hours of approval</td>
                        </tr>
                        <tr>
                            <td>Cash on Delivery Orders</td>
                            <td>5–7 business days via bank transfer</td>
                        </tr>
                        <tr>
                            <td>Debit / Credit Card</td>
                            <td>5–10 business days (bank dependent)</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr class="pol-divider">

            <!-- How to Request -->
            <div class="pol-section">
                <div class="pol-section-header">
                    <div class="pol-section-icon">📋</div>
                    <h2>How to Request a Refund</h2>
                </div>
                <div class="pol-timeline">
                    <div class="pol-tl-item">
                        <div class="pol-tl-left">
                            <div class="pol-tl-dot">1</div>
                            <div class="pol-tl-line"></div>
                        </div>
                        <div class="pol-tl-body">
                            <strong>Contact Our Support</strong>
                            <span>Email <strong>support@kidzwear.pk</strong> with your order number, issue description, and photos if applicable.</span>
                        </div>
                    </div>
                    <div class="pol-tl-item">
                        <div class="pol-tl-left">
                            <div class="pol-tl-dot">2</div>
                            <div class="pol-tl-line"></div>
                        </div>
                        <div class="pol-tl-body">
                            <strong>Await Review</strong>
                            <span>Our team will review your request within <strong>1–2 business days</strong> and confirm eligibility.</span>
                        </div>
                    </div>
                    <div class="pol-tl-item">
                        <div class="pol-tl-left">
                            <div class="pol-tl-dot">3</div>
                            <div class="pol-tl-line"></div>
                        </div>
                        <div class="pol-tl-body">
                            <strong>Return the Item (if required)</strong>
                            <span>For some cases, you may need to ship the item back. We'll guide you through the process and cover shipping for our errors.</span>
                        </div>
                    </div>
                    <div class="pol-tl-item">
                        <div class="pol-tl-left">
                            <div class="pol-tl-dot">4</div>
                            <div class="pol-tl-line"></div>
                        </div>
                        <div class="pol-tl-body">
                            <strong>Refund Processed</strong>
                            <span>Once approved, your refund will be processed to your original payment method within the stated timeframe.</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="pol-divider">

            <!-- Non-Refundable -->
            <div class="pol-section">
                <div class="pol-section-header">
                    <div class="pol-section-icon">🚫</div>
                    <h2>Non-Refundable Items & Situations</h2>
                </div>
                <ul>
                    <li>Items returned after the <strong>7-day window</strong></li>
                    <li>Items that have been worn, washed, or tampered with</li>
                    <li><strong>Final Sale</strong> or clearance items</li>
                    <li>Shipping charges (unless item is defective or wrong)</li>
                    <li>Change of mind or wrong size ordered by customer</li>
                </ul>
                <div class="pol-highlight">
                    <strong>Note:</strong> For size-related issues, we recommend using our free <strong>Exchange Policy</strong> instead of a refund, as exchanges are typically faster and easier to process.
                </div>
            </div>

            <!-- CTA -->
            <div class="pol-cta-box">
                <div>
                    <h3>Have a refund query?</h3>
                    <p>We're here to help make it right.</p>
                </div>
                <a href="{{ route('contact') }}" class="pol-cta-btn">Get in Touch</a>
            </div>

        </div>
    </div>
</div>

@include('partials.footer')
