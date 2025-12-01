@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

    <div class="auth-container">
        <div class="info-box">
            <p>
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </p>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <h2>Reset Password</h2>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       autocomplete="email"
                       placeholder="Enter your email address">
                @error('email')
                <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    Email Password Reset Link
                </button>

                <a href="{{ route('login') }}" class="btn btn-secondary">
                    Back to Login
                </a>
            </div>
        </form>
    </div>
@endsection
