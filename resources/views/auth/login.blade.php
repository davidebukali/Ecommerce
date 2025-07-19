<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Log in to your account</h1>
        <p class="auth-subtitle">Welcome back! Please enter your details.</p>

        {{-- Session Status (e.g., after password reset) --}}
        @if (session('status'))
        <x-alert-message type="success" :message="session('status')" />
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                    autofocus class="form-input @error('email') is-invalid @enderror">
                @error('email')
                <div class="input-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="form-input @error('password') is-invalid @enderror">
                @error('password')
                <div class="input-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group form-group-checkbox">
                <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                <label for="remember_me" class="form-checkbox-label">Remember me</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary auth-submit-button">Log in</button>

                @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
                @endif
            </div>
        </form>

        <div class="auth-footer">
            <p>Don't have an account? <a href="{{ route('register') }}" class="auth-link">Sign up here</a></p>
        </div>
    </div>
</div>
@endsection
