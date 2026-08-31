@extends('admin.layout')
@section('header_title', 'Product Reviews')
@section('content')
@if(session('success'))<div style="background:#d4edda;color:#155724;padding:12px 20px;border-radius:8px;margin-bottom:20px;">{{ session('success') }}</div>@endif
<div class="content-card"><div class="card-header"><h2>Submitted Reviews</h2></div><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Product</th><th>Customer</th><th>Stars</th><th>Review</th><th>Status</th><th>Action</th></tr></thead><tbody>
@forelse($reviews as $review)<tr><td>{{ $review->product->name ?? 'Deleted product' }}</td><td>{{ $review->user->name ?? 'User' }}</td><td style="color:#fbbf24;">{{ str_repeat('★', $review->rating) }}</td><td>{{ $review->review_text }}</td><td>{{ ucfirst($review->status) }}</td><td>@if($review->status !== 'approved')<form action="{{ route('admin.productReviews.approve', $review->id) }}" method="POST" style="display:inline">@csrf<button class="btn-primary">Approve</button></form>@endif <form action="{{ route('admin.productReviews.delete', $review->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this review?')">@csrf<button class="btn-danger">Delete</button></form></td></tr>@empty<tr><td colspan="6" style="text-align:center;padding:35px;">No submitted reviews yet.</td></tr>@endforelse
</tbody></table></div></div>
@endsection
