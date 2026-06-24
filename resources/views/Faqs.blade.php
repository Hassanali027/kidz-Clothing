<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - Kidz Clothing</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fafafa;
            color: #333;
        }

        /* FAQ Hero Section */
        .faq-hero {
            background: linear-gradient(135deg, #f06292 0%, #ec407a 100%);
            padding: 60px 20px;
            text-align: center;
            color: #fff;
        }

        .faq-hero h1 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .faq-hero p {
            font-size: 18px;
            opacity: 0.95;
        }

        /* FAQ Container */
        .faq-container {
            max-width: 900px;
            margin: -40px auto 60px;
            padding: 0 20px;
        }

        /* Category Tabs */
        .faq-tabs {
            display: flex;
            gap: 12px;
            margin-bottom: 30px;
           
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .faq-tab {
            padding: 12px 24px;
            border: none;
            background: #f5f5f5;
            color: #333;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .faq-tab:hover {
            background: #e0e0e0;
        }

        .faq-tab.active {
            background: #f06292;
            color: #fff;
        }

        /* FAQ Category Section */
        .faq-category {
            display: none;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .faq-category.active {
            display: block;
        }

        .faq-category-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 24px;
            color: #000;
        }

        /* FAQ Item */
        .faq-item {
            border-bottom: 1px solid #e0e0e0;
            padding: 20px 0;
        }

        .faq-item:last-child {
            border-bottom: none;
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-size: 17px;
            font-weight: 600;
            color: #000;
            padding-right: 20px;
            transition: color 0.3s;
        }

        .faq-question:hover {
            color: #f06292;
        }

        .faq-icon {
            font-size: 24px;
            font-weight: 300;
            color: #f06292;
            transition: transform 0.3s;
            flex-shrink: 0;
        }

        .faq-item.active .faq-icon {
            transform: rotate(45deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            color: #333;
            font-size: 15px;
            line-height: 1.7;
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
            padding-top: 16px;
        }

        /* Contact Section */
        .faq-contact {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            margin-top: 40px;
        }

        .faq-contact h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #000;
        }

        .faq-contact p {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }

        .faq-contact-btn {
            display: inline-block;
            padding: 14px 32px;
            background: #f06292;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s;
        }

        .faq-contact-btn:hover {
            background: #ec407a;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .faq-hero h1 {
                font-size: 32px;
            }

            .faq-hero p {
                font-size: 16px;
            }

            .faq-tabs {
                padding: 15px;
            }

            .faq-tab {
                padding: 10px 18px;
                font-size: 14px;
            }

            .faq-category {
                padding: 20px;
            }

            .faq-category-title {
                font-size: 22px;
            }

            .faq-question {
                font-size: 15px;
            }

            .faq-contact {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    @include('partials.header')

    <!-- Hero Section -->
    <div class="faq-hero">
        <h1>Frequently Asked Questions</h1>
        <p>Find answers to common questions about our kids clothing store</p>
    </div>

    <!-- FAQ Container -->
    <div class="faq-container">
        
        <!-- Category Tabs -->
        <div class="faq-tabs">
            <button class="faq-tab active" data-category="orders">Orders & Delivery</button>
            <button class="faq-tab" data-category="products">Products & Sizing</button>
            <button class="faq-tab" data-category="returns">Returns & Exchanges</button>
            <button class="faq-tab" data-category="payment">Payment & Pricing</button>
            <button class="faq-tab" data-category="account">Account & Support</button>
        </div>

        <!-- Orders & Delivery Category -->
        <div class="faq-category active" id="orders">
            <h2 class="faq-category-title">Orders & Delivery</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>How long does delivery take?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Standard delivery takes 3-5 business days. Express delivery is available and takes 1-2 business days. Delivery times may vary based on your location.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you offer free shipping?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Yes! We offer free standard shipping on all orders above Rs. 2,500. For orders below this amount, a flat shipping fee of Rs. 150 applies.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Can I track my order?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Absolutely! Once your order is shipped, you'll receive a tracking number via email and SMS. You can track your order status in real-time through our website or the courier's tracking portal.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>What areas do you deliver to?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    We deliver across Pakistan to all major cities and most rural areas. Enter your postal code at checkout to confirm delivery availability in your area.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Can I change my delivery address after placing an order?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Yes, you can change your delivery address before the order is shipped. Please contact our customer support team immediately with your order number and new address.
                </div>
            </div>
        </div>

        <!-- Products & Sizing Category -->
        <div class="faq-category" id="products">
            <h2 class="faq-category-title">Products & Sizing</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>How do I choose the right size for my child?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Each product page includes a detailed size chart with measurements. We recommend measuring your child's height, chest, and waist, then comparing with our size guide. If you're between sizes, we suggest sizing up for growing room.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Are your clothes made from safe materials for kids?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Yes! All our clothing is made from child-safe, non-toxic materials. We use soft, breathable fabrics like cotton and cotton blends that are gentle on sensitive skin and meet international safety standards.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you have clothes for newborns?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Yes! Our 0-2 Years collection includes clothing suitable for newborns and infants. These items are specially designed with soft fabrics and easy-to-use closures for quick diaper changes.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>How should I care for the clothes?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Care instructions are provided on each garment's label. Generally, we recommend machine washing in cold water with similar colors and tumble drying on low heat. Avoid bleach to maintain fabric quality and colors.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Do colors look the same as in pictures?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    We strive to display accurate colors, but slight variations may occur due to screen settings and lighting. If you're not satisfied with the color, our easy return policy has you covered.
                </div>
            </div>
        </div>

        <!-- Returns & Exchanges Category -->
        <div class="faq-category" id="returns">
            <h2 class="faq-category-title">Returns & Exchanges</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What is your return policy?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    We offer a 14-day return policy from the date of delivery. Items must be unworn, unwashed, and in original condition with tags attached. Simply contact us to initiate a return.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>How do I exchange an item for a different size?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Contact our customer support with your order number and the size you need. We'll arrange a free exchange if the item is available. The exchange process typically takes 5-7 business days.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Who pays for return shipping?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    If the return is due to our error (wrong item, defective product), we cover return shipping. For size exchanges or change of mind, return shipping is the customer's responsibility.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>When will I receive my refund?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Refunds are processed within 5-7 business days after we receive and inspect the returned item. The refund will be credited to your original payment method.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Can I return sale items?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Yes, sale items can be returned within 14 days following the same return policy. However, some clearance items marked as "Final Sale" are non-returnable.
                </div>
            </div>
        </div>

        <!-- Payment & Pricing Category -->
        <div class="faq-category" id="payment">
            <h2 class="faq-category-title">Payment & Pricing</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>What payment methods do you accept?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    We accept all major credit/debit cards (Visa, Mastercard), bank transfers, JazzCash, Easypaisa, and Cash on Delivery (COD) for eligible orders.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Is Cash on Delivery available?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Yes! COD is available for orders up to Rs. 10,000. A small COD handling fee of Rs. 100 may apply depending on your location.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Are prices inclusive of taxes?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Yes, all prices displayed on our website are inclusive of applicable taxes. There are no hidden charges - what you see is what you pay (plus shipping if applicable).
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you offer discounts or promotions?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Yes! We regularly run seasonal sales, festive promotions, and offer discount codes. Subscribe to our newsletter and follow us on social media to stay updated on the latest deals.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Is my payment information secure?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Absolutely! We use industry-standard SSL encryption to protect your payment information. We never store your complete card details on our servers.
                </div>
            </div>
        </div>

        <!-- Account & Support Category -->
        <div class="faq-category" id="account">
            <h2 class="faq-category-title">Account & Support</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do I need an account to place an order?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    No, you can checkout as a guest. However, creating an account allows you to track orders, save addresses, view order history, and get faster checkout on future purchases.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>How do I reset my password?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Click on "Forgot Password" on the login page, enter your registered email address, and we'll send you a password reset link. Follow the instructions in the email to create a new password.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>How can I contact customer support?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    You can reach us via email at support@kidzclothing.com, call us at +92-XXX-XXXXXXX (Mon-Sat, 9 AM - 6 PM), or use the contact form on our website. We typically respond within 24 hours.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Can I cancel my order?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Yes, you can cancel your order before it's shipped. Contact our customer support immediately with your order number. Once shipped, you'll need to follow our return process.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you have a physical store?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    Currently, we operate exclusively online to offer you the best prices and widest selection. This allows us to keep costs low and pass the savings on to you!
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="faq-contact">
            <h3>Still Have Questions?</h3>
            <p>Can't find the answer you're looking for? Our customer support team is here to help!</p>
            <a href="/contact" class="faq-contact-btn">Contact Us</a>
        </div>

    </div>

    <script>
        // Tab switching
        const tabs = document.querySelectorAll('.faq-tab');
        const categories = document.querySelectorAll('.faq-category');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and categories
                tabs.forEach(t => t.classList.remove('active'));
                categories.forEach(c => c.classList.remove('active'));

                // Add active class to clicked tab
                tab.classList.add('active');

                // Show corresponding category
                const categoryId = tab.getAttribute('data-category');
                document.getElementById(categoryId).classList.add('active');
            });
        });

        // FAQ accordion
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            
            question.addEventListener('click', () => {
                // Toggle active class
                item.classList.toggle('active');
            });
        });
    </script>
@include('partials.footer')

</body>
</html>
