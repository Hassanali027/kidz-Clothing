@extends('admin.layout')

@section('header_title', 'Customer Reviews')

@section('content')
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">✓ {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">{{ $errors->first() }}</div>
    @endif

    <div class="content-card" style="margin-bottom: 24px;">
        <div class="card-header"><h2>Add Review</h2></div>
        <form action="{{ route('admin.testimonials.store') }}" method="POST" style="padding: 20px;">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 180px 140px; gap: 15px;">
                <div class="form-group"><label>Customer Name</label><input name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Ayesha M." required></div>
                <div class="form-group"><label>Stars</label><select name="rating" class="form-control">@for($rating = 5; $rating >= 1; $rating--)<option value="{{ $rating }}">{{ $rating }} Star{{ $rating > 1 ? 's' : '' }}</option>@endfor</select></div>
                <div class="form-group"><label>Display Order</label><input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', 0) }}"></div>
            </div>
            <div class="form-group"><label>Review Text</label><textarea name="review_text" class="form-control" rows="3" required>{{ old('review_text') }}</textarea></div>
            <button class="btn-primary" type="submit">Add Review</button>
        </form>
    </div>

    <div class="content-card">
        <div class="card-header"><h2>All Reviews</h2></div>
        <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Name</th><th>Stars</th><th>Review</th><th>Status</th><th>Actions</th></tr></thead><tbody>
            @forelse($testimonials as $testimonial)
                <tr><td><strong>{{ $testimonial->name }}</strong></td><td style="color: #fbbf24;">{{ str_repeat('★', $testimonial->rating) }}</td><td>{{ $testimonial->review_text }}</td><td><span class="status-badge {{ $testimonial->is_active ? 'status-success' : 'status-danger' }}">{{ $testimonial->is_active ? 'Visible' : 'Hidden' }}</span></td><td>
                    <form action="{{ route('admin.testimonials.toggle', $testimonial->id) }}" method="POST" style="display:inline;">@csrf<button type="submit" class="btn-secondary">{{ $testimonial->is_active ? 'Hide' : 'Show' }}</button></form>
                    <form action="{{ route('admin.testimonials.delete', $testimonial->id) }}" method="POST" style="display:inline; margin-left: 8px;" onsubmit="return confirm('Delete this review?');">@csrf<button type="submit" class="btn-danger">Delete</button></form>
                </td></tr>
            @empty
                <tr><td colspan="5" style="text-align:center; padding:35px;">No reviews added yet.</td></tr>
            @endforelse
        </tbody></table></div>
    </div>
@endsection
