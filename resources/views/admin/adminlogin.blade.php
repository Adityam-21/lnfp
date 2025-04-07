<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery & jQuery Validate -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <style>
        body {
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card login-container">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Admin Login</h4>
                    </div>
                    <div class="card-body">
                        <div id="alert-box"></div>

                        <!-- Login Form -->
                        <form id="admin-login-form">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                                <small class="error" id="email-error"></small>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                                <small class="error" id="password-error"></small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                            <p>User account <a href="{{ route('login') }}">Login</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery Validation & AJAX -->
    <script>
        $(document).ready(function () {
            $("#admin-login-form").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    email: {
                        required: "Email is required",
                        email: "Enter a valid email address"
                    },
                    password: {
                        required: "Password is required",
                        minlength: "Password must be at least 6 characters"
                    }
                },
                errorPlacement: function (error, element) {
                    $("#" + element.attr("id") + "-error").html(error);
                },
                submitHandler: function (form) {
                    let formData = $("#admin-login-form").serialize();
                    
                    $.ajax({
                        url: "{{ route('admin.adminlogin.post') }}",
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        beforeSend: function () {
                            $(".error").text('');
                            $("#alert-box").html('');
                        },
                        success: function (response) {
                            $("#alert-box").html('<div class="alert alert-success">' + response.message + '</div>');
                            setTimeout(function () {
                                window.location.href = response.redirect;
                            }, 1500);
                        },
                        error: function (xhr) {
                            let errors = xhr.responseJSON;
                            if (errors.message) {
                                $("#alert-box").html('<div class="alert alert-danger">' + errors.message + '</div>');
                            }
                            if (errors.errors) {
                                if (errors.errors.email) {
                                    $("#email-error").text(errors.errors.email[0]);
                                }
                                if (errors.errors.password) {
                                    $("#password-error").text(errors.errors.password[0]);
                                }
                            }
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>
