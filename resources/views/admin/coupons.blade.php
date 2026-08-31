@extends('admin.layout')

@section('header_title', 'Coupon Codes')

@section('content')
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">✓ {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">{{ $errors->first() }}</div>
    @endif

    <div class="content-card" style="margin-bottom: 24px;">
        <div class="card-header"><h2>Create Coupon</h2></div>
        <form action="{{ route('admin.coupons.store') }}" method="POST" style="display: flex; gap: 14px; align-items: end; flex-wrap: wrap; padding: 20px;">
            @csrf
            <div class="form-group" style="margin: 0; min-width: 250px;">
                <label>Coupon Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code') }}" placeholder="e.g. SAVE5" required style="text-transform: uppercase;">
            </div>
            <div class="form-group" style="margin: 0; min-width: 200px;">
                <label>Discount</label>
                <select name="discount_percent" class="form-control" required>
                    <option value="5">5% — reusable</option>
                    <option value="10">10% — one use per email</option>
                </select>
            </div>
            <button class="btn-primary" type="submit">Create Coupon</button>
        </form>
    </div>

    <div class="content-card">
        <div class="card-header"><h2>All Coupon Codes</h2></div>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead><tr><th>Code</th><th>Discount</th><th>Usage Rule</th><th>Used</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td><strong>{{ $coupon->code }}</strong></td>
                            <td>{{ $coupon->discount_percent }}%</td>
                            <td>{{ $coupon->single_use_per_user ? 'Once per email' : 'Reusable' }}</td>
                            <td>{{ $coupon->usages_count }}</td>
                            <td><span class="status-badge {{ $coupon->is_active ? 'status-success' : 'status-danger' }}">{{ $coupon->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td>
                                <form action="{{ route('admin.coupons.toggle', $coupon->id) }}" method="POST" style="display: inline;">@csrf<button class="btn-secondary" type="submit">{{ $coupon->is_active ? 'Disable' : 'Enable' }}</button></form>
                                <form action="{{ route('admin.coupons.delete', $coupon->id) }}" method="POST" style="display: inline; margin-left: 8px;" onsubmit="return confirm('Delete this coupon?');">@csrf<button class="btn-danger" type="submit">Delete</button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align: center; padding: 35px;">No coupon codes created yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
