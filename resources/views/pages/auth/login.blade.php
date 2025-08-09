@extends('layouts.main')
@section('title', 'Admin Login - Cheap Laos Train')
@section('description', 'Secure login portal for Cheap Laos Train administrators')
@section('keywords', 'admin login, secure access, Cheap Laos Train admin')

@push('styles-main')
    <style>
        .login-container {
            min-height: 100vh;
            background-color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            background-color: #fff;
        }

        .logo-site {
            max-height: 70px;
            object-fit: contain;
            margin-bottom: 1.5rem;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-control {
            padding: 12px 16px;
            height: auto;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #f8fafc;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #336667;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(51, 102, 103, 0.15);
        }

        .form-label {
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 0.5rem;
        }

        .btn-login {
            background-color: #336667;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 500;
            width: 100%;
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            background-color: #275152;
            transform: translateY(-1px);
        }

        .password-input-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #718096;
            z-index: 10;
            background: none;
            border: none;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1rem 0 1.5rem;
        }

        .form-check-input:checked {
            background-color: #336667;
            border-color: #336667;
        }

        .forgot-link {
            color: #336667;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }
    </style>
@endpush

@section('content-main')
    <section class="login-container">
        <div class="login-card">
            <div class="text-center mb-4">
                <a href="{{ route('home') }}">
                    <img class="logo-site" src="{{ asset('assets/images/logo/logo-site.png') }}" alt="FOCI Loans">
                </a>
                <h1 class="login-title">Admin Login</h1>
            </div>

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="user_name" class="form-label">Username</label>
                    <input type="text" class="form-control @error('user_name') is-invalid @enderror"
                           name="user_name" id="user_name" value="{{ old('user_name') }}" required autofocus>
                    @error('user_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               name="password" id="password" required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-forgot">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">Login</button>
            </form>
        </div>
    </section>
@endsection

@push('scripts-main')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            e.preventDefault();
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
</script>
@endpush
