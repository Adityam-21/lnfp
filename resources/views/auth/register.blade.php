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
            min-height: calc(100vh - 56px);
            /* Account for navbar height */
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
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery & jQuery Validate -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <style>
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>
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
                        <a class="nav-link" href="{{ route('admin.adminlogin') }}">Admin Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header text-center">
                <h2>Register</h2>
                <p>Create your account for L&F Bootcamp</p>
            </div>
            <div class="card-body">
                <!-- Success Message -->
                <div id="success-message" class="alert alert-success d-none"></div>

                <!-- Registration Form -->
                <form id="registerForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name">
                        <small class="error" id="name-error"></small>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                        <small class="error" id="email-error"></small>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Create a password">
                        <small class="error" id="password-error"></small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password">
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms">
                        <label class="form-check-label" for="terms">
                            I agree to the Terms of Service and Privacy Policy
                        </label>
                        <small class="error" id="terms-error"></small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Create Account</button>
                </form>

                <p class="mt-3 text-center">Already have an account? <a href="{{ route('login') }}">Login</a></p>
            </div>
        </div>
    </div>

    <!-- jQuery Validation & AJAX Script -->
    <script>
        $(document).ready(function() {
            $("#registerForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                    terms: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Full name is required",
                        minlength: "Name must be at least 3 characters"
                    },
                    email: {
                        required: "Email is required",
                        email: "Enter a valid email address"
                    },
                    password: {
                        required: "Password is required",
                        minlength: "Password must be at least 6 characters"
                    },
                    password_confirmation: {
                        required: "Confirm your password",
                        equalTo: "Passwords do not match"
                    },
                    terms: {
                        required: "You must agree to the terms"
                    }
                },
                errorPlacement: function(error, element) {
                    $("#" + element.attr("id") + "-error").html(error);
                },
                submitHandler: function(form) {
                    let formData = $("#registerForm").serialize();

                    $.ajax({
                        url: "{{ route('register.post') }}",
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        beforeSend: function() {
                            $("small.error").text('');
                            $("#success-message").addClass('d-none').text('');
                        },
                        success: function(response) {
                            $("#success-message").removeClass('d-none').text(response.message);
                            $("#registerForm")[0].reset();
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
                            if (errors) {
                                $.each(errors, function(key, value) {
                                    $("#" + key + "-error").text(value[0]);
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>