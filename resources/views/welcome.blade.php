@extends('layouts.default')
@section('title', 'Welcome')
@section('content')

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome</title>
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
                --warning-color: #f59e0b;
                --info-color: #3b82f6;
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
                max-width: 1200px;
                margin: 0 auto;
                padding: 40px 20px;
            }

            .welcome-header {
                text-align: center;
                margin-bottom: 40px;
                padding-bottom: 20px;
                border-bottom: 1px solid var(--border-color);
            }

            .welcome-header h1 {
                color: var(--dark-color);
                font-size: 32px;
                margin-bottom: 10px;
            }

            .welcome-header p {
                color: var(--body-color);
                font-size: 16px;
            }

            .user-card {
                background-color: white;
                border-radius: 16px;
                box-shadow: var(--shadow);
                overflow: hidden;
                margin-bottom: 30px;
            }

            .user-header {
                background: linear-gradient(120deg, #4361ee 0%, #3a0ca3 100%);
                color: white;
                padding: 25px 30px;
                position: relative;
                overflow: hidden;
            }

            .user-header::before {
                content: "";
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
                transform: rotate(30deg);
            }

            .user-header h2 {
                font-weight: 600;
                font-size: 24px;
                margin-bottom: 5px;
                display: flex;
                align-items: center;
            }

            .user-header h2 svg {
                margin-right: 10px;
            }

            .user-body {
                padding: 30px;
            }

            .user-info {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 25px;
            }

            @media (max-width: 768px) {
                .user-info {
                    grid-template-columns: 1fr;
                }
            }

            .info-item {
                margin-bottom: 20px;
            }

            .info-label {
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 10px;
                display: block;
                font-size: 15px;
            }

            .info-value {
                font-size: 16px;
                color: var(--body-color);
                background-color: var(--light-color);
                padding: 12px;
                border-radius: 8px;
                border: 1px solid var(--border-color);
            }

            .edit-profile-form {
                margin-top: 20px;
            }

            .form-row {
                margin-bottom: 20px;
            }

            .form-label {
                display: block;
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 8px;
                font-size: 15px;
            }

            .form-control {
                width: 100%;
                padding: 14px 16px;
                font-size: 15px;
                border: 2px solid var(--border-color);
                border-radius: 10px;
                transition: all 0.3s ease;
            }

            .form-control:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
            }

            .form-select {
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23636b83' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 16px;
            }

            .form-text {
                display: block;
                margin-top: 6px;
                font-size: 13px;
                color: #94a3b8;
            }

            .form-check {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
            }

            .form-check-input {
                margin-right: 10px;
                width: 18px;
                height: 18px;
                accent-color: var(--primary-color);
            }

            .form-check-label {
                font-size: 15px;
            }

            .btn {
                display: inline-block;
                font-weight: 600;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                user-select: none;
                border: none;
                padding: 12px 20px;
                font-size: 15px;
                line-height: 1.5;
                border-radius: 8px;
                transition: all 0.3s;
                cursor: pointer;
                letter-spacing: 0.3px;
            }

            .btn-primary {
                color: #fff;
                background: linear-gradient(120deg, #4361ee 0%, #3a0ca3 100%);
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
            }

            .btn-outline {
                color: var(--primary-color);
                background: transparent;
                border: 2px solid var(--primary-color);
            }

            .btn-outline:hover {
                background-color: var(--primary-light);
            }

            .form-buttons {
                display: flex;
                gap: 15px;
                margin-top: 20px;
            }

            .alert {
                padding: 15px 20px;
                margin-bottom: 20px;
                border-radius: 10px;
                font-size: 14px;
                display: flex;
                align-items: center;
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

            .tab-container {
                margin-bottom: 30px;
            }

            .tabs {
                display: flex;
                list-style: none;
                padding: 0;
                margin: 0;
                border-bottom: 1px solid var(--border-color);
            }

            .tab-item {
                margin-right: 10px;
            }

            .tab-link {
                display: inline-block;
                padding: 12px 20px;
                color: var(--body-color);
                font-weight: 500;
                text-decoration: none;
                border-bottom: 3px solid transparent;
                transition: all 0.2s;
            }

            .tab-link.active {
                color: var(--primary-color);
                border-bottom-color: var(--primary-color);
            }

            .tab-link:hover:not(.active) {
                color: var(--dark-color);
                border-bottom-color: var(--border-color);
            }

            .tab-content {
                padding-top: 25px;
            }

            .tab-pane {
                display: none;
            }

            .tab-pane.active {
                display: block;
                animation: fadeIn 0.3s ease-in;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .avatar-container {
                display: flex;
                justify-content: center;
                margin-bottom: 25px;
            }

            .avatar {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
                border: 5px solid white;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .logout-link {
                display: inline-flex;
                align-items: center;
                color: #64748b;
                text-decoration: none;
                font-size: 14px;
                margin-top: 15px;
                transition: color 0.2s;
            }

            .logout-link:hover {
                color: var(--danger-color);
            }

            .logout-link svg {
                margin-right: 6px;
            }
        </style>
    </head>

    <body>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">L&F Bootcamp</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            @auth
                                <p>Thank you for registering {{ Auth::user()->name }}!</p>
                            @else
                                <p><a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a>
                                </p>
                            @endauth
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="welcome-header">
                <h1>
                    @auth
                        Welcome, {{ auth()->user()->name }}!
                    @else
                        Welcome to our site!
                    @endauth
                </h1>
                @auth
                    <p>We're glad to have you here. Please complete your profile information below.</p>
                @else
                    <p>Please log in to access your account.</p>
                @endauth
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="tab-container">
                <ul class="tabs">
                    <li class="tab-item">
                        <a href="#profile" class="tab-link active">Profile Information</a>
                    </li>

                </ul>

                <div class="tab-content">
                    <div id="profile" class="tab-pane active">
                        <div class="user-card">
                            <div class="user-header">
                                <h2>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Profile Information
                                </h2>
                            </div>
                            <div class="user-body">
                                <div class="user-info">
                                    <div class="info-item">
                                        <span class="info-label">Name</span>
                                        <div class="info-value"> {{ auth()->check() ? auth()->user()->name : 'Guest' }}
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <span class="info-label">Email</span>
                                        <div class="info-value">{{ auth()->check() ? auth()->user()->email : 'Guest' }}
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <span class="info-label">Account Created</span>
                                        <div class="info-value">
                                            {{ auth()->check() ? auth()->user()->created_at->format('F d, Y') : 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <span class="info-label">Status</span>
                                        <div class="info-value">Active</div>
                                    </div>


                                    <a href="{{ route('logout') }}" class="logout-link"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        <input type="hidden" name="redirect" value="{{ route('login') }}">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="edit-profile" class="tab-pane">
                            <div class="user-card">
                                <div class="user-header">
                                    <h2>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                        Edit Profile
                                    </h2>
                                </div>
                                <div class="user-body">
                                    @csrf
                                    @method('PUT')

                                    <div class="user-info">
                                        <div class="form-row">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ auth()->check() ? auth()->user()->name : '' }}">
                                        </div>

                                        <div class="form-row">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                value="{{ auth()->check() ? auth()->user()->email : '' }}">
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <label for="bio" class="form-label">Bio</label>
                                        <textarea id="bio" name="bio" class="form-control" rows="4">{{ auth()->user()->bio ?? '' }}</textarea>
                                    </div>

                                    <div class="user-info">
                                        <div class="form-row">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" id="phone" name="phone" class="form-control"
                                                value="{{ auth()->user()->phone ?? '' }}">
                                        </div>

                                        <div class="form-row">
                                            <label for="location" class="form-label">Location</label>
                                            <input type="text" id="location" name="location" class="form-control"
                                                value="{{ auth()->user()->location ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="form-buttons">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                        <button type="reset" class="btn btn-outline">Cancel</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="settings" class="tab-pane">
                            <div class="user-card">
                                <div class="user-header">

                                    @csrf

                                    <div class="form-row">
                                        <label class="form-label">Email Notifications</label>
                                        <div class="form-check">
                                            <input type="checkbox" id="newsletter" name="newsletter"
                                                class="form-check-input" checked>
                                            <label for="newsletter" class="form-check-label">Receive newsletter
                                                updates</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" id="account_updates" name="account_updates"
                                                class="form-check-input" checked>
                                            <label for="account_updates" class="form-check-label">Receive account
                                                updates</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" id="marketing" name="marketing"
                                                class="form-check-input">
                                            <label for="marketing" class="form-check-label">Receive marketing
                                                emails</label>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" id="current_password" name="current_password"
                                            class="form-control">
                                    </div>

                                    <div class="user-info">
                                        <div class="form-row">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <input type="password" id="new_password" name="new_password"
                                                class="form-control">
                                        </div>

                                        <div class="form-row">
                                            <label for="new_password_confirmation" class="form-label">Confirm New
                                                Password</label>
                                            <input type="password" id="new_password_confirmation"
                                                name="new_password_confirmation" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-buttons">
                                        <button type="submit" class="btn btn-primary">Update Settings</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>

    </html>
