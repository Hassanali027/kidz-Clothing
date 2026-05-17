@include('partials.header')

<style>
/* ── Auth Page (Shared with Sign-in) ── */
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
    margin-bottom: 30px;
}
.auth-switch a {
    color: #29b6f6;
    text-decoration: none;
    font-weight: 500;
}
.auth-switch a:hover { text-decoration: underline; }

/* Separator */
.auth-separator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-bottom: 30px;
    color: #888;
    font-size: 14px;
}
.auth-sep-line {
    height: 1px;
    background: #ddd;
    flex: 1;
}

/* Social Buttons */
.auth-social-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}
.auth-social-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 0;
    border: 1px solid #ffc1e3; /* Pinkish border like in image */
    border-radius: 6px;
    background: #fff;
    color: #333;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
}
.auth-social-btn:hover { background: #fff5f8; }
.auth-social-btn img {
    width: 16px;
    height: 16px;
}

</style>

<div class="auth-page">
    <div class="auth-card">
        <h1 class="auth-title">Create Account</h1>

        <form action="#" method="POST">
            @csrf
            
            <div class="auth-form-group">
                <label class="auth-label">Full Name</label>
                <input type="text" name="name" class="auth-input" required>
            </div>

            <div class="auth-form-group">
                <label class="auth-label">Email</label>
                <input type="email" name="email" class="auth-input" required>
            </div>

            <div class="auth-form-group">
                <label class="auth-label">Password</label>
                <input type="password" name="password" class="auth-input" required>
            </div>

            <div class="auth-form-group">
                <label class="auth-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="auth-input" required>
            </div>

            <button type="submit" class="auth-submit-btn">Create Account</button>

            <p class="auth-switch">
                Already have an account? <a href="{{ route('login') }}">Login</a>
            </p>

            <div class="auth-separator">
                <div class="auth-sep-line"></div>
                OR
                <div class="auth-sep-line"></div>
            </div>

            <div class="auth-social-row">
                <a href="#" class="auth-social-btn">
                    <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google">
                    Sign up with Google
                </a>
                <a href="#" class="auth-social-btn">
                    <img src="https://www.svgrepo.com/show/330401/facebook.svg" alt="Facebook">
                    Sign up with Facebook
                </a>
            </div>

        </form>
    </div>
</div>

@include('partials.footer')
