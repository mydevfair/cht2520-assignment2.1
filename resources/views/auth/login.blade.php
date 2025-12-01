@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h2 style="color: #2c3e50; margin-bottom: 20px;">Login</h2>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                <div class="alert alert-error" style="margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
                @error('password')
                <div class="alert alert-error" style="margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; font-weight: normal;">
                    <input type="checkbox" name="remember" style="width: auto; margin-right: 8px;">
                    Remember me
                </label>
            </div>

            <div class="form-buttons" style="justify-content: space-between;">
                <button type="submit" class="btn btn-primary">
                    Log in
                </button>

                <a href="{{ route('register') }}" class="btn btn-success">
                    Register
                </a>
            </div>

            @if (Route::has('password.request'))
                <div style="margin-top: 15px; text-align: center;">
                    <a href="{{ route('password.request') }}" style="color: #3498db; text-decoration: none;">
                        Forgot Password?
                    </a>
                </div>
            @endif
        </form>
    </div>
@endsection
