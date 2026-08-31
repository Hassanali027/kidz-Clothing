@extends('admin.layout')

@section('header_title', 'User Order History')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.users') }}" style="text-decoration: none; color: #666; font-weight: 600;"><i class="fa-solid fa-arrow-left"></i> Back to Users</a>
    </div>

    <div class="content-card" style="margin-bottom: 24px;">
        <div style="padding: 22px 24px;">
            <h2 style="margin: 0 0 8px;">{{ $user->name }}</h2>
            <p style="margin: 0; color: #64748b;">{{ $user->email }} · {{ $user->orders->count() }} order(s)</p>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header"><h2>Order History</h2></div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr><th>Order #</th><th>Date</th><th>Payment</th><th>Coupon</th><th>Discount</th><th>Total</th><th>Status</th><th>Action</th></tr>
                </thead>
                <tbody>
                    @forelse($user->orders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                            <td>{{ strtoupper($order->payment_method) }}</td>
                            <td>{{ $order->coupon_code ?: '—' }}</td>
                            <td style="color: #16a34a;">{{ ($order->discount_amount ?? 0) > 0 ? 'Rs ' . number_format($order->discount_amount) : '—' }}</td>
                            <td><strong>Rs {{ number_format($order->total_amount) }}</strong></td>
                            <td><span class="status-badge status-{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span></td>
                            <td><a href="{{ route('admin.orders.view', $order->id) }}" class="btn-action btn-edit" title="View Order"><i class="fa-solid fa-eye"></i></a></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" style="text-align: center; padding: 40px; color: #64748b;">This user has not placed any orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
