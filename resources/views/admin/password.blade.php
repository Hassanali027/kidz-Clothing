@extends('admin.layout')

@section('header_title', 'Change Password')

@section('content')
    <div class="content-card">
        <div class="card-header">
            <h2>Secure Your Account</h2>
        </div>

        <form class="admin-form">
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" class="form-control" placeholder="Enter current password">
            </div>
            
            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" placeholder="Enter new password">
            </div>
            
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" class="form-control" placeholder="Repeat new password">
            </div>

            <button type="submit" class="btn-primary">Update Password</button>
        </form>
    </div>
@endsection
