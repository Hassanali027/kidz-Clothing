@include('partials.header')

<style>
.account-page { background: #fdfdfd; min-height: calc(100vh - 120px); padding: 40px 20px; max-width: 900px; margin: 0 auto; font-family: 'Outfit', sans-serif; }
.account-title { text-align: center; font-size: 32px; font-weight: 800; margin-bottom: 20px; color: #111; }
.tabs-nav { display: flex; justify-content: center; gap: 10px; margin-bottom: 40px; }
.tab-btn { background: #fff; border: 1px solid #e0e0e0; padding: 10px 24px; border-radius: 4px; font-size: 15px; cursor: pointer; color: #555; transition: 0.2s; }
.tab-btn.active { background: #d7ccc8; color: #111; border-color: #d7ccc8; font-weight: 600; }
.tab-content { display: none; }
.tab-content.active { display: block; }

.section-title { font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #111; }
.info-card { background: #fff; border: 1px solid #eee; border-radius: 8px; padding: 25px; margin-bottom: 25px; position: relative; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
.info-row { display: flex; margin-bottom: 15px; align-items: flex-start; }
.info-label { width: 120px; color: #777; font-size: 14px; }
.info-value { color: #111; font-size: 15px; font-weight: 500; }
.btn-edit { position: absolute; right: 25px; bottom: 25px; background: #f5f5f5; border: 1px solid #ddd; padding: 6px 16px; border-radius: 4px; font-size: 13px; cursor: pointer; color: #333; display: flex; align-items: center; gap: 6px; }
.btn-edit:hover { background: #ebebeb; }

/* Form styles */
.edit-form { display: none; }
.form-group { margin-bottom: 15px; }
.form-group label { display: block; font-size: 13px; color: #555; margin-bottom: 5px; }
.form-control { width: 100%; border: 1px solid #ddd; padding: 10px; border-radius: 4px; font-size: 14px; }
.form-actions { display: flex; gap: 10px; margin-top: 20px; }
.btn-save { background: #111; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 14px; }
.btn-cancel { background: #fff; color: #333; border: 1px solid #ddd; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 14px; }

/* Status Badges */
.status-badge {
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
}
.status-pending { background: #fff3e0; color: #ff9800; }
.status-processing { background: #e3f2fd; color: #2196f3; }
.status-shipped { background: #ede7f6; color: #673ab7; }
.status-delivered { background: #e8f5e9; color: #4caf50; }
.status-cancelled { background: #ffebee; color: #f44336; }

.logout-container { text-align: center; margin-top: 40px; }
.logout-btn { background: #f44336; color: #fff; border: none; padding: 12px 30px; border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; }
</style>

<div class="account-page">
    <h1 class="account-title">My Account</h1>
    
    <div class="tabs-nav">
        <button class="tab-btn active" onclick="switchTab(event, 'profile')">Profile</button>
        <button class="tab-btn" onclick="switchTab(event, 'orders')">Orders ({{ $orders->count() }})</button>
    </div>

    @if(session('success'))
        <div style="background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; padding: 12px 16px; border-radius: 6px; margin-bottom: 25px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div style="background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; padding: 12px 16px; border-radius: 6px; margin-bottom: 25px; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Tab -->
    <div id="tab-profile" class="tab-content active">
        <h2 class="section-title">Profile</h2>
        
        <!-- Name & Email Card -->
        <div class="info-card">
            <div id="profile-view">
                <div class="info-row">
                    <div class="info-label">Name</div>
                    <div class="info-value">{{ auth()->user()->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ auth()->user()->email }}</div>
                </div>
                <button class="btn-edit" onclick="toggleEdit('profile')">Add <i class="fa-solid fa-pen-to-square"></i></button>
            </div>
            
            <form id="profile-form" class="edit-form" action="{{ route('accounts.update-profile') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-save">Save Changes</button>
                    <button type="button" class="btn-cancel" onclick="toggleEdit('profile')">Cancel</button>
                </div>
            </form>
        </div>

        <h2 class="section-title">Address</h2>
        <!-- Address Card -->
        <div class="info-card">
            <div id="address-view">
                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value">{{ auth()->user()->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Address:</div>
                    <div class="info-value">{{ auth()->user()->address ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Province:</div>
                    <div class="info-value">{{ auth()->user()->province ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">City:</div>
                    <div class="info-value">{{ auth()->user()->city ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Postal Code:</div>
                    <div class="info-value">{{ auth()->user()->postal_code ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone No:</div>
                    <div class="info-value">{{ auth()->user()->phone ?? '-' }}</div>
                </div>
                <button class="btn-edit" onclick="toggleEdit('address')">Add <i class="fa-solid fa-pen-to-square"></i></button>
            </div>

            <form id="address-form" class="edit-form" action="{{ route('accounts.update-address') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="{{ auth()->user()->address }}">
                </div>
                <div style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Province</label>
                        <input type="text" name="province" class="form-control" value="{{ auth()->user()->province }}">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" value="{{ auth()->user()->city }}">
                    </div>
                </div>
                <div style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Postal Code</label>
                        <input type="text" name="postal_code" class="form-control" value="{{ auth()->user()->postal_code }}">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Phone No</label>
                        <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone }}">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-save">Save Changes</button>
                    <button type="button" class="btn-cancel" onclick="toggleEdit('address')">Cancel</button>
                </div>
            </form>
        </div>

        <div class="logout-container">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Log Out</button>
            </form>
        </div>
    </div>

    <!-- Orders Tab -->
    <div id="tab-orders" class="tab-content">
        @if($orders->isEmpty())
            <div class="info-card" style="text-align: center; padding: 60px 20px;">
                <i class="fa-solid fa-box-open" style="font-size: 40px; color: #ccc; margin-bottom: 15px;"></i>
                <h3 style="color: #555; font-weight: 500;">No orders found.</h3>
                <p style="color: #888; font-size: 14px; margin-top: 5px;">When you place orders, they will appear here.</p>
            </div>
        @else
            <h2 class="section-title">Order History</h2>
            <div style="background: #fff; border: 1px solid #eee; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: #f4f5f7; border-bottom: 1px solid #eee;">
                            <th style="padding: 16px 20px; font-size: 12px; color: #666; font-weight: 700; text-transform: uppercase;">Order ID</th>
                            <th style="padding: 16px 20px; font-size: 12px; color: #666; font-weight: 700; text-transform: uppercase;">Date</th>
                            <th style="padding: 16px 20px; font-size: 12px; color: #666; font-weight: 700; text-transform: uppercase;">Total</th>
                            <th style="padding: 16px 20px; font-size: 12px; color: #666; font-weight: 700; text-transform: uppercase;">Status</th>
                            <th style="padding: 16px 20px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 16px 20px; color: #555;">{{ $order->order_number }}</td>
                            <td style="padding: 16px 20px; color: #555;">{{ $order->created_at->format('d M, Y') }}</td>
                            <td style="padding: 16px 20px; color: #555;">Rs {{ number_format($order->total_amount) }} ({{ $order->items->sum('quantity') }} Products)</td>
                            <td style="padding: 16px 20px;">
                                <span class="status-badge status-{{ strtolower($order->status) }}">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </td>
                            <td style="padding: 16px 20px; text-align: right;">
                                <a href="{{ route('accounts.orders.view', $order->id) }}" style="color: #111; font-weight: 600; text-decoration: none; font-size: 14px;">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

<script>
function switchTab(event, tabId) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    
    event.currentTarget.classList.add('active');
    document.getElementById('tab-' + tabId).classList.add('active');
}

function toggleEdit(section) {
    const view = document.getElementById(section + '-view');
    const form = document.getElementById(section + '-form');
    
    if (form.style.display === 'block') {
        form.style.display = 'none';
        view.style.display = 'block';
    } else {
        form.style.display = 'block';
        view.style.display = 'none';
    }
}
</script>

@include('partials.footer')
