@extends('admin.layout')

@section('header_title', 'Site Settings')

@section('content')
    <div class="content-card">
        <div class="card-header">
            <h2>General Settings</h2>
        </div>

        <form class="admin-form">
            <div class="form-group">
                <label>Website Name</label>
                <input type="text" class="form-control" value="Kidz Wear">
            </div>
            
            <div class="form-group">
                <label>Contact Email</label>
                <input type="email" class="form-control" value="info@kidzwear.com">
            </div>
            
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" class="form-control" value="+92 300 1234567">
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea class="form-control" rows="3">123 Fashion Street, Karachi, Pakistan</textarea>
            </div>

            <div class="form-group">
                <label>Footer Text</label>
                <input type="text" class="form-control" value="© 2026 Kidz Wear. All Rights Reserved.">
            </div>

            <button type="submit" class="btn-primary">Save Changes</button>
        </form>
    </div>
@endsection
