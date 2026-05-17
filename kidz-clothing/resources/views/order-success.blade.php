@include('partials.header')

<div style="min-height: calc(100vh - 120px); display: flex; align-items: center; justify-content: center; background: #fdfdfd; padding: 40px 20px;">
    <div style="max-width: 500px; width: 100%; text-align: center; background: #fff; padding: 60px 40px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.05);">
        
        <div style="width: 80px; height: 80px; background: #e8f5e9; color: #4caf50; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
            <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        </div>

        <h1 style="font-size: 28px; font-weight: 800; color: #111; margin-bottom: 15px;">Order Placed Successfully!</h1>
        <p style="color: #666; line-height: 1.6; margin-bottom: 30px;">
            Thank you for shopping with Kidz Wear. Your order <strong>{{ $orderId }}</strong> has been received and is being processed. 
            We will contact you soon for confirmation.
        </p>

        <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 40px; text-align: left;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                <span style="color: #888;">Payment Method:</span>
                <span style="font-weight: 700; color: #000;">Cash on Delivery</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 14px;">
                <span style="color: #888;">Delivery Time:</span>
                <span style="font-weight: 700; color: #000;">3-5 Working Days</span>
            </div>
        </div>

        <a href="{{ route('home') }}" style="display: block; width: 100%; background: #4fc3f7; color: #fff; padding: 16px; border-radius: 6px; font-weight: 700; text-decoration: none; transition: background 0.2s;">Back to Home</a>
        
    </div>
</div>

@include('partials.footer')
