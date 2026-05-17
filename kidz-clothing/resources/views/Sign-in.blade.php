@include('partials.header')

<style>
/* ── Sign In / Auth Pages ── */
.auth-page {
    background: #fdfdfd;
    min-height: calc(100vh - 120px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
}
.auth-card {
    width: 100%;
    max-width: 440px;
    background: transparent;
}
.auth-title {
    font-size: 28px;
    font-weight: 800;
    color: #111;
    text-align: center;
    margin-bottom: 50px;
}

/* Form Styling */
.auth-form-group {
    margin-bottom: 35px;
    position: relative;
}
.auth-label {
    display: block;
    font-size: 13px;
    color: #aaa;
    margin-bottom: 8px;
}
.auth-input {
    width: 100%;
    border: none;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
    font-size: 14px;
    color: #111;
    background: transparent;
    outline: none;
    transition: border-color 0.2s;
}
.auth-input:focus {
    border-color: #4fc3f7;
}

/* Forget Password Link */
.auth-forget {
    display: block;
    text-align: right;
    font-size: 12px;
    color: #29b6f6;
    text-decoration: none;
    margin-top: -25px;
    margin-bottom: 40px;
}
.auth-forget:hover { text-decoration: underline; }

/* Main Button */
.auth-submit-btn {
    width: 100%;
    background: #4fc3f7;
    color: #fff;
    border: none;
    padding: 16px;
    border-radius: 6px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
    margin-bottom: 25px;
}
.auth-submit-btn:hover { background: #29b6f6; }

/* Switch Auth Link */
.auth-switch {
    text-align: center;
    font-size: 13.5px;
    color: #444;
}
.auth-switch a {
    color: #29b6f6;
    text-decoration: none;
    font-weight: 500;
}
.auth-switch a:hover { text-decoration: underline; }

</style>

<div class="auth-page">
    <div class="auth-card">
        <h1 class="auth-title">Sign-in</h1>

        <form action="#" method="POST">
            @csrf
            
            <div class="auth-form-group">
                <label class="auth-label">Email</label>
                <input type="email" name="email" class="auth-input" required>
            </div>

            <div class="auth-form-group">
                <label class="auth-label">Password</label>
                <input type="password" name="password" class="auth-input" required>
            </div>

            <a href="#" class="auth-forget">Forget Password?</a>

            <button type="submit" class="auth-submit-btn">Login</button>

            <p class="auth-switch">
                Don't have an account? <a href="{{ route('signup') }}">Signup Here</a>
            </p>

        </form>
    </div>
</div>

@include('partials.footer')
