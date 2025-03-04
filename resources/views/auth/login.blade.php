@extends('layouts.default')
@section('title', 'Login')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a0ca3;
            --primary-light: #f0f4ff;
            --dark-color: #151a33;
            --body-color: #636b83;
            --light-color: #f5f8ff;
            --border-color: #e2e8f0;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --success-color: #10b981;
            --danger-color: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f6f9ff 0%, #e9effd 100%);
            color: var(--body-color);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 56px); /* Account for navbar height */
            padding: 40px 20px;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            background-color: white;
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(120deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }

        .card-header h2 {
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-header p {
            opacity: 0.9;
            font-size: 16px;
            font-weight: 300;
        }

        .card-body {
            padding: 35px;
        }

        .form-group {
            margin-bottom: 28px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 15px;
            letter-spacing: 0.3px;
        }

        .form-control {
            width: 100%;
            padding: 15px 18px;
            font-size: 15px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            transition: all 0.3s ease;
            background-color: #fafbff;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
            background-color: #fff;
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        .form-text {
            display: block;
            margin-top: 8px;
            font-size: 13px;
            color: #94a3b8;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .form-check-input {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            accent-color: var(--primary-color);
            cursor: pointer;
        }

        .form-check-label {
            font-size: 15px;
            cursor: pointer;
        }

        .btn {
            display: inline-block;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: none;
            padding: 16px 20px;
            font-size: 16px;
            line-height: 1.5;
            border-radius: 10px;
            transition: all 0.3s;
            cursor: pointer;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            color: #fff;
            background: linear-gradient(120deg, #4361ee 0%, #3a0ca3 100%);
            width: 100%;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-primary:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, #3a0ca3 0%, #4361ee 100%);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .btn-primary:hover:before {
            left: 0;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }

        .error-message {
            color: var(--danger-color);
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
        }

        .error-message:before {
            content: "⚠";
            margin-right: 6px;
        }

        .auth-links {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid var(--border-color);
            font-size: 15px;
        }

        .auth-links p:not(:last-child) {
            margin-bottom: 10px;
        }

        .auth-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .auth-links a:hover {
            color: var(--primary-hover);
        }
        
        .alert {
            padding: 15px 20px;
            margin: 20px;
            border-radius: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border-left: 4px solid var(--success-color);
        }
        
        .alert-success:before {
            content: "✓";
            margin-right: 10px;
            background-color: var(--success-color);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        
        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border-left: 4px solid var(--danger-color);
        }
        
        .alert-danger:before {
            content: "!";
            margin-right: 10px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .text-center {
            text-align: center;
        }
        
        .mt-3 {
            margin-top: 15px;
        }
        
        .logo-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        
        .logo-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .logo-image:hover {
            transform: scale(1.05);
        }

        /* Navbar styling */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 10px 20px;
        }

        .container-fluid {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 22px;
        }

        .navbar-toggler {
            border: none;
            background: none;
            cursor: pointer;
        }

        .navbar-toggler-icon {
            display: block;
            width: 24px;
            height: 2px;
            background-color: var(--dark-color);
            position: relative;
            transition: background-color 0.3s;
        }

        .navbar-toggler-icon:before,
        .navbar-toggler-icon:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background-color: var(--dark-color);
            left: 0;
            transition: transform 0.3s;
        }

        .navbar-toggler-icon:before {
            top: -6px;
        }

        .navbar-toggler-icon:after {
            bottom: -6px;
        }

        .navbar-nav {
            display: flex;
            list-style: none;
            gap: 20px;
        }

        .nav-link {
            color: var(--body-color);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        .nav-link.active {
            color: var(--primary-color);
            background-color: var(--primary-light);
        }

        .nav-link.disabled {
            color: #cbd5e1;
            cursor: not-allowed;
        }

        /* For mobile responsiveness */
        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
                gap: 10px;
            }
            
            .collapse:not(.show) {
                display: none;
            }
            
            .container {
                padding: 20px;
            }
            
            .card-header {
                padding: 25px 20px;
            }
            
            .card-body {
                padding: 25px;
            }
            
            .form-control {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">L&F Bootcamp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="login-card">
            <div class="card-header">
                <h2>Welcome Back</h2>
                <p>Sign in to your account to continue</p>
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="card-body">
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-check">
                        <input type="checkbox" id="remember" name="remember" class="form-check-input">
                        <label for="remember" class="form-check-label">Remember Me</label>
                    </div>
                
                    <button type="submit" class="btn btn-primary">Login</button>
                    
                    <div class="auth-links">
                        <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
@endsection