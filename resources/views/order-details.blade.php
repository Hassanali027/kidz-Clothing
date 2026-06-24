@include('partials.header')

<style>
.details-page { background: #fdfdfd; min-height: calc(100vh - 120px); padding: 40px 20px; max-width: 900px; margin: 0 auto; font-family: 'Outfit', sans-serif; }
.card-outline { background: #fff; border: 1px solid #eee; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
.details-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 25px; border-bottom: 1px solid #eee; }
.details-header h2 { margin: 0; font-size: 18px; color: #111; font-weight: 700; }
.details-header span { color: #888; font-weight: 400; font-size: 14px; margin-left: 10px; }
.back-link { color: #111; text-decoration: none; font-weight: 600; font-size: 14px; }
.back-link:hover { text-decoration: underline; }

.items-table { width: 100%; border-collapse: collapse; text-align: left; }
.items-table th { background: #f4f5f7; padding: 12px 25px; font-size: 11px; color: #666; font-weight: 700; text-transform: uppercase; }
.items-table td { padding: 20px 25px; border-bottom: 1px solid #eee; color: #444; font-size: 14px; vertical-align: middle; }
.product-cell { display: flex; align-items: center; gap: 15px; }
.product-img { width: 60px; height: 60px; border-radius: 4px; object-fit: cover; }
.product-name { font-weight: 500; color: #111; }

.bottom-section { display: grid; grid-template-columns: 1fr 1fr 1.2fr; gap: 20px; padding: 25px; }
.address-block h4 { font-size: 11px; color: #888; text-transform: uppercase; margin: 0 0 15px 0; letter-spacing: 0.5px; }
.address-info { font-size: 14px; color: #555; line-height: 1.6; }
.address-info strong { color: #111; display: block; margin-bottom: 5px; }
.contact-row { margin-top: 15px; }
.contact-label { font-size: 10px; color: #888; text-transform: uppercase; margin-bottom: 2px; }

.summary-card { background: #fdfdfd; border: 1px solid #eee; border-radius: 6px; padding: 20px; }
.summary-header { display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px; }
.summary-header-item { flex: 1; }
.summary-label { font-size: 10px; color: #888; text-transform: uppercase; margin-bottom: 5px; }
.summary-val { font-size: 13px; font-weight: 600; color: #111; }
.summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #555; }
.summary-total { display: flex; justify-content: space-between; margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee; font-size: 16px; font-weight: 700; color: #111; }

.btn-cancel { display: block; width: 100%; text-align: center; margin-top: 20px; background: #fff; border: 1px solid #f44336; color: #f44336; padding: 12px; border-radius: 4px; font-size: 14px; cursor: pointer; text-decoration: none; }
.btn-cancel:hover { background: #fef0f0; }

/* Custom Modal Styles */
.modal-overlay {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.5); z-index: 9999;
    display: none; align-items: center; justify-content: center;
    opacity: 0; transition: opacity 0.3s ease;
}
.modal-overlay.active { display: flex; opacity: 1; }
.custom-modal {
    background: #fff; border-radius: 8px; width: 90%; max-width: 400px;
    padding: 30px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    transform: translateY(20px); transition: transform 0.3s ease;
}
.modal-overlay.active .custom-modal { transform: translateY(0); }
.custom-modal i { font-size: 40px; color: #f44336; margin-bottom: 15px; display: block; }
.custom-modal h3 { margin: 0 0 10px 0; font-size: 20px; color: #111; }
.custom-modal p { margin: 0 0 25px 0; font-size: 15px; color: #555; }
.modal-actions { display: flex; justify-content: center; gap: 15px; }
.modal-btn { padding: 10px 20px; border-radius: 4px; font-weight: 600; cursor: pointer; border: none; font-size: 14px; transition: all 0.2s; }
.btn-no { background: #eee; color: #333; }
.btn-no:hover { background: #e0e0e0; }
.btn-yes { background: #f44336; color: #fff; }
.btn-yes:hover { background: #d32f2f; }
</style>

<div class="details-page">
    @if(session('success'))
        <div style="background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; padding: 12px 16px; border-radius: 6px; margin-bottom: 25px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; padding: 12px 16px; border-radius: 6px; margin-bottom: 25px; font-size: 14px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="card-outline">
        <div class="details-header">
            <h2>Order Details <span>• {{ $order->created_at->format('M d, Y') }} • {{ $order->items->sum('quantity') }} Products</span></h2>
            <a href="{{ route('accounts') }}" class="back-link">Back to List</a>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <div class="product-cell">
                            @if($item->product_image)
                                <img src="{{ str_starts_with($item->product_image, 'http') ? $item->product_image : asset('storage/' . $item->product_image) }}" alt="{{ $item->product_name }}" class="product-img">
                            @else
                                <div class="product-img" style="background: #f4f4f4; display: flex; align-items: center; justify-content: center; color: #aaa;">No Img</div>
                            @endif
                            <span class="product-name">{{ $item->product_name }}</span>
                        </div>
                    </td>
                    <td>Rs {{ number_format($item->price) }}</td>
                    <td>x{{ $item->quantity }}</td>
                    <td style="font-weight: 600; color: #111;">Rs {{ number_format($item->price * $item->quantity) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="bottom-section">
            <div class="address-block">
                <h4>Billing Address</h4>
                <div class="address-info">
                    <strong>{{ $order->first_name }} {{ $order->last_name }}</strong>
                    {{ $order->address }}<br>
                    {{ $order->city }}
                    
                    <div class="contact-row">
                        <div class="contact-label">Email</div>
                        <div>{{ auth()->user()->email }}</div>
                    </div>
                    <div class="contact-row">
                        <div class="contact-label">Phone</div>
                        <div>{{ $order->phone }}</div>
                    </div>
                </div>
            </div>

            <div class="address-block" style="border-left: 1px solid #eee; padding-left: 20px;">
                <h4>Shipping Address</h4>
                <div class="address-info">
                    <strong>{{ $order->first_name }} {{ $order->last_name }}</strong>
                    {{ $order->address }}<br>
                    {{ $order->city }}
                    
                    <div class="contact-row">
                        <div class="contact-label">Email</div>
                        <div>{{ auth()->user()->email }}</div>
                    </div>
                    <div class="contact-row">
                        <div class="contact-label">Phone</div>
                        <div>{{ $order->phone }}</div>
                    </div>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-header">
                    <div class="summary-header-item">
                        <div class="summary-label">Order ID:</div>
                        <div class="summary-val">{{ $order->order_number }}</div>
                    </div>
                    <div class="summary-header-item" style="text-align: right;">
                        <div class="summary-label">Payment Method:</div>
                        <div class="summary-val" style="text-transform: uppercase;">{{ $order->payment_method }}</div>
                    </div>
                </div>

                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span style="color: #111; font-weight: 500;">Rs {{ number_format($order->total_amount) }}</span>
                </div>
                <div class="summary-row">
                    <span>Discount:</span>
                    <span style="color: #111; font-weight: 500;">0%</span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span style="color: #111; font-weight: 500;">Rs 0</span>
                </div>
                
                <div class="summary-total">
                    <span>Total:</span>
                    <span>Rs {{ number_format($order->total_amount) }}</span>
                </div>
            </div>

            <div style="text-align: right; margin-top: 20px;">
                @if(strtolower(trim($order->status)) === 'pending')
                    <form id="cancelForm" action="{{ route('accounts.orders.cancel', $order->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="button" onclick="showCancelModal()" style="background: transparent; border: 1px solid #ff4d4d; color: #ff4d4d; padding: 10px 25px; border-radius: 4px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;">Cancel Order</button>
                    </form>
                @endif
                @if(strtolower(trim($order->status)) === 'cancelled')
                    <div style="color: #ff4d4d; font-weight: 600; font-size: 15px; display: inline-block; padding: 10px 20px;">Order Cancelled</div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Custom Confirmation Modal -->
<div class="modal-overlay" id="cancelModal">
    <div class="custom-modal">
        <i class="fa-solid fa-circle-exclamation"></i>
        <h3>Cancel Order?</h3>
        <p>Are you sure you want to cancel this order? This action cannot be undone.</p>
        <div class="modal-actions">
            <button class="modal-btn btn-no" onclick="hideCancelModal()">No, Keep it</button>
            <button class="modal-btn btn-yes" onclick="submitCancel()">Yes, Cancel</button>
        </div>
    </div>
</div>

<script>
    function showCancelModal() {
        document.getElementById('cancelModal').classList.add('active');
    }
    
    function hideCancelModal() {
        document.getElementById('cancelModal').classList.remove('active');
    }
    
    function submitCancel() {
        document.getElementById('cancelForm').submit();
    }
</script>

@include('partials.footer')
