<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Create your account</h1>
        <p class="auth-subtitle">Join us and start shopping!</p>

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name"
                    autofocus class="form-input @error('name') is-invalid @enderror">
                @error('name')
                <div class="input-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                    class="form-input @error('email') is-invalid @enderror">
                @error('email')
                <div class="input-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="form-input @error('password') is-invalid @enderror">
                @error('password')
                <div class="input-error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" class="form-input">
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary auth-submit-button">Register</button>
            </div>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="{{ route('login') }}" class="auth-link">Log in here</a></p>
        </div>
    </div>
</div>
@endsection
