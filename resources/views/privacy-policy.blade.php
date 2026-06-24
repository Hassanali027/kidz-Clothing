@include('partials.header')

<style>
/* ── Privacy Policy Page ── */
.pol-hero {
    background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
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
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);
    backdrop-filter: blur(6px); color: #fff;
    font-size: 13px; font-weight: 600;
    padding: 6px 16px; border-radius: 20px; margin-bottom: 18px; letter-spacing: 0.3px;
}
.pol-hero h1 { font-size: 40px; font-weight: 800; margin-bottom: 12px; line-height: 1.2; }
.pol-hero p { font-size: 16px; opacity: 0.9; max-width: 520px; margin: 0 auto; line-height: 1.6; }
.pol-body { max-width: 860px; margin: -36px auto 70px; padding: 0 24px; position: relative; z-index: 2; }
.pol-card { background: #fff; border-radius: 18px; box-shadow: 0 8px 40px rgba(0,0,0,0.09); overflow: hidden; }
.pol-updated {
    background: #ccfbf1; color: #0f766e;
    font-size: 13px; font-weight: 600;
    padding: 12px 28px; border-bottom: 1px solid #99f6e4;
    display: flex; align-items: center; gap: 8px;
}
.pol-toc {
    background: #f0fdfa;
    border: 1px solid #ccfbf1;
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 32px;
}
.pol-toc h3 { font-size: 14px; font-weight: 700; color: #0f766e; margin: 0 0 12px; text-transform: uppercase; letter-spacing: 0.5px; }
.pol-toc ol { margin: 0; padding-left: 20px; display: flex; flex-direction: column; gap: 6px; }
.pol-toc ol li a { font-size: 14px; color: #0d9488; text-decoration: none; }
.pol-toc ol li a:hover { text-decoration: underline; }
.pol-content { padding: 36px 40px 44px; }
.pol-intro { font-size: 15px; color: #444; line-height: 1.8; margin-bottom: 36px; padding-bottom: 28px; border-bottom: 2px dashed #f0f0f0; }
.pol-section { margin-bottom: 36px; scroll-margin-top: 80px; }
.pol-section-header { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
.pol-section-icon {
    width: 42px; height: 42px; border-radius: 12px;
    background: linear-gradient(135deg, #ccfbf1, #99f6e4);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.pol-section h2 { font-size: 19px; font-weight: 700; color: #111; margin: 0; }
.pol-section p, .pol-section li { font-size: 14.5px; color: #444; line-height: 1.8; }
.pol-section p + p { margin-top: 10px; }
.pol-section ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px; }
.pol-section ul li { padding-left: 22px; position: relative; }
.pol-section ul li::before { content: '✓'; position: absolute; left: 0; color: #0f766e; font-weight: 700; font-size: 13px; }
.pol-highlight {
    background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
    border-left: 4px solid #0f766e;
    border-radius: 0 10px 10px 0;
    padding: 16px 20px; margin: 16px 0;
    font-size: 14.5px; color: #333; line-height: 1.7;
}
.pol-divider { border: none; border-top: 1px solid #f0f0f0; margin: 28px 0; }
.pol-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 14px; }
.pol-info-card {
    background: #faf9f7;
    border: 1px solid #e8e8e8;
    border-radius: 12px;
    padding: 16px 18px;
}
.pol-info-card h4 { font-size: 14px; font-weight: 700; color: #111; margin: 0 0 6px; }
.pol-info-card p { font-size: 13.5px; color: #555; margin: 0; line-height: 1.6; }
.pol-rights-list { display: flex; flex-direction: column; gap: 12px; margin-top: 14px; }
.pol-right-item {
    display: flex; align-items: flex-start; gap: 14px;
    background: #faf9f7; border: 1px solid #f0f0f0;
    border-radius: 12px; padding: 14px 16px;
}
.pol-right-emoji { font-size: 22px; flex-shrink: 0; line-height: 1.3; }
.pol-right-text strong { display: block; font-size: 14.5px; color: #111; margin-bottom: 3px; }
.pol-right-text span { font-size: 13.5px; color: #555; line-height: 1.6; }
.pol-cta-box {
    background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
    border-radius: 14px; padding: 28px 30px;
    display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; margin-top: 36px;
}
.pol-cta-box h3 { font-size: 17px; font-weight: 700; color: #fff; margin: 0 0 4px; }
.pol-cta-box p { font-size: 14px; color: rgba(255,255,255,0.85); margin: 0; }
.pol-cta-btn {
    display: inline-block; padding: 11px 28px;
    background: #fff; color: #0f766e;
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
    .pol-info-grid { grid-template-columns: 1fr; }
}
</style>

<!-- Hero -->
<div class="pol-hero">
    <nav class="pol-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        <span>Privacy Policy</span>
    </nav>
    <div class="pol-hero-badge">🔒 Privacy Policy</div>
    <h1>Privacy Policy</h1>
    <p>We are committed to protecting your personal information and your right to privacy.</p>
</div>

<!-- Content -->
<div class="pol-body">
    <div class="pol-card">

        <div class="pol-updated">
            📅 &nbsp;Last Updated: May 2026 &nbsp;|&nbsp; Effective: May 2026
        </div>

        <div class="pol-content">

            <!-- ToC -->
            <div class="pol-toc">
                <h3>📌 Table of Contents</h3>
                <ol>
                    <li><a href="#pp-info-collect">Information We Collect</a></li>
                    <li><a href="#pp-how-use">How We Use Your Information</a></li>
                    <li><a href="#pp-sharing">Information Sharing</a></li>
                    <li><a href="#pp-cookies">Cookies & Tracking</a></li>
                    <li><a href="#pp-security">Data Security</a></li>
                    <li><a href="#pp-rights">Your Rights</a></li>
                    <li><a href="#pp-contact">Contact Us</a></li>
                </ol>
            </div>

            <p class="pol-intro">
                Welcome to <strong>Kidz Wear</strong>. We respect your privacy and are committed to protecting any personal data you share with us. This Privacy Policy explains how we collect, use, and safeguard your information when you visit our website or place an order with us.
            </p>

            <!-- Section 1: Info We Collect -->
            <div class="pol-section" id="pp-info-collect">
                <div class="pol-section-header">
                    <div class="pol-section-icon">📂</div>
                    <h2>1. Information We Collect</h2>
                </div>
                <p>We collect information to process your orders and provide a better shopping experience. This includes:</p>
                <div class="pol-info-grid">
                    <div class="pol-info-card">
                        <h4>👤 Personal Information</h4>
                        <p>Name, email address, phone number, and billing/shipping address when you place an order.</p>
                    </div>
                    <div class="pol-info-card">
                        <h4>🛒 Order Information</h4>
                        <p>Products purchased, order history, payment method (we do not store card details), and transaction IDs.</p>
                    </div>
                    <div class="pol-info-card">
                        <h4>📱 Device Information</h4>
                        <p>IP address, browser type, device type, and pages visited to improve our website performance.</p>
                    </div>
                    <div class="pol-info-card">
                        <h4>✉️ Communication Data</h4>
                        <p>Messages you send us via contact forms, email, or WhatsApp for customer support purposes.</p>
                    </div>
                </div>
            </div>

            <hr class="pol-divider">

            <!-- Section 2: How We Use It -->
            <div class="pol-section" id="pp-how-use">
                <div class="pol-section-header">
                    <div class="pol-section-icon">⚙️</div>
                    <h2>2. How We Use Your Information</h2>
                </div>
                <ul>
                    <li>To <strong>process and fulfill</strong> your orders and payments</li>
                    <li>To <strong>communicate</strong> order confirmations, shipping updates, and receipts</li>
                    <li>To <strong>respond</strong> to your customer support inquiries</li>
                    <li>To <strong>send promotional emails</strong> (only if you opt in; you can unsubscribe at any time)</li>
                    <li>To <strong>improve our website</strong> and product offerings based on usage patterns</li>
                    <li>To <strong>comply with legal obligations</strong> as required by Pakistani law</li>
                </ul>
                <div class="pol-highlight">
                    We will <strong>never sell, rent, or trade</strong> your personal information to third parties for marketing purposes.
                </div>
            </div>

            <hr class="pol-divider">

            <!-- Section 3: Sharing -->
            <div class="pol-section" id="pp-sharing">
                <div class="pol-section-header">
                    <div class="pol-section-icon">🤝</div>
                    <h2>3. Information Sharing</h2>
                </div>
                <p>We only share your data with trusted third parties who help us operate our business:</p>
                <ul style="margin-top:12px;">
                    <li><strong>Courier & Logistics Partners</strong> — to deliver your orders (name and address only)</li>
                    <li><strong>Payment Processors</strong> — JazzCash, EasyPaisa, and bank services to handle transactions securely</li>
                    <li><strong>Analytics Tools</strong> — anonymized data only, to understand website performance</li>
                    <li><strong>Legal Authorities</strong> — only when required by law or a valid court order</li>
                </ul>
            </div>

            <hr class="pol-divider">

            <!-- Section 4: Cookies -->
            <div class="pol-section" id="pp-cookies">
                <div class="pol-section-header">
                    <div class="pol-section-icon">🍪</div>
                    <h2>4. Cookies & Tracking</h2>
                </div>
                <p>We use cookies to enhance your browsing experience. Cookies are small files stored on your device. We use them to:</p>
                <ul style="margin-top:12px;">
                    <li>Remember your shopping cart contents</li>
                    <li>Keep you logged into your account</li>
                    <li>Analyze site traffic and user behavior (anonymously)</li>
                    <li>Show you relevant content and promotions</li>
                </ul>
                <p style="margin-top:14px;">You can disable cookies in your browser settings, however this may affect some features of our website.</p>
            </div>

            <hr class="pol-divider">

            <!-- Section 5: Security -->
            <div class="pol-section" id="pp-security">
                <div class="pol-section-header">
                    <div class="pol-section-icon">🛡️</div>
                    <h2>5. Data Security</h2>
                </div>
                <p>We take the security of your personal data seriously. We use industry-standard security measures including:</p>
                <ul style="margin-top:12px;">
                    <li>SSL/TLS encryption for all data transmitted on our website</li>
                    <li>Secure, limited access to customer databases</li>
                    <li>Regular security reviews of our systems</li>
                    <li>We <strong>do not store</strong> complete card numbers or CVV codes</li>
                </ul>
                <div class="pol-highlight">
                    While we take every precaution, no method of online transmission is 100% secure. We encourage you to use a strong, unique password for your account.
                </div>
            </div>

            <hr class="pol-divider">

            <!-- Section 6: Your Rights -->
            <div class="pol-section" id="pp-rights">
                <div class="pol-section-header">
                    <div class="pol-section-icon">⚖️</div>
                    <h2>6. Your Rights</h2>
                </div>
                <p>You have the following rights regarding your personal data:</p>
                <div class="pol-rights-list">
                    <div class="pol-right-item">
                        <div class="pol-right-emoji">👁️</div>
                        <div class="pol-right-text">
                            <strong>Right to Access</strong>
                            <span>You can request a copy of all personal data we hold about you.</span>
                        </div>
                    </div>
                    <div class="pol-right-item">
                        <div class="pol-right-emoji">✏️</div>
                        <div class="pol-right-text">
                            <strong>Right to Correction</strong>
                            <span>You can ask us to update any inaccurate or incomplete information.</span>
                        </div>
                    </div>
                    <div class="pol-right-item">
                        <div class="pol-right-emoji">🗑️</div>
                        <div class="pol-right-text">
                            <strong>Right to Deletion</strong>
                            <span>You can request that we delete your personal data, subject to legal obligations.</span>
                        </div>
                    </div>
                    <div class="pol-right-item">
                        <div class="pol-right-emoji">🚫</div>
                        <div class="pol-right-text">
                            <strong>Right to Opt-Out</strong>
                            <span>You can unsubscribe from marketing emails at any time using the unsubscribe link in any email.</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="pol-divider">

            <!-- Section 7: Contact -->
            <div class="pol-section" id="pp-contact">
                <div class="pol-section-header">
                    <div class="pol-section-icon">📬</div>
                    <h2>7. Contact Us</h2>
                </div>
                <p>If you have any questions, concerns, or requests regarding this Privacy Policy or your personal data, please contact us:</p>
                <ul style="margin-top:12px;">
                    <li><strong>Email:</strong> privacy@kidzwear.pk</li>
                    <li><strong>WhatsApp:</strong> +92-XXX-XXXXXXX</li>
                    <li><strong>Business Hours:</strong> Monday – Saturday, 9 AM – 6 PM (PKT)</li>
                </ul>
            </div>

            <!-- CTA -->
            <div class="pol-cta-box">
                <div>
                    <h3>Privacy concerns or questions?</h3>
                    <p>We're here and happy to help.</p>
                </div>
                <a href="{{ route('contact') }}" class="pol-cta-btn">Contact Us</a>
            </div>

        </div>
    </div>
</div>

@include('partials.footer')
