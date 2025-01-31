<?= $this->extend('layouts/frontend.php') ?>

<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #e0f7fa, #ffffff);
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .card-header i {
            font-size: 50px;
            color: #26a69a;
        }

        .form-group label {
            font-weight: 600;
            color: #00695c;
        }

        .form-control {
            border-radius: 25px;
            border: 1px solid #b2dfdb;
            font-size: 16px;
            padding-right: 40px; /* Space for the eye icon */
        }

        .form-control:focus {
            border-color: #26a69a;
            box-shadow: 0 0 10px rgba(38, 166, 154, 0.3);
        }

        .password-container {
            position: relative;
        }

        .password-container i {
            position: absolute;
            right: 10px;
            top: 65%; /* Slightly lowered the icon */
            transform: translateY(-40%);
            cursor: pointer;
            color: #00695c;
            font-size: 16px;
        }

        .btn-primary {
            background: #26a69a;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 16px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background: #004d40;
            transform: scale(1.05);
        }

        a {
            color: #26a69a;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 25px;
            font-weight: 500;
        }

        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
            <div class="card-header">
                <i class="fas fa-user-circle"></i>
            </div>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" id="flashMessage">
                    <?= session()->getFlashdata('error') ?>
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('flashMessage').style.display = 'none';
                    }, 3000);
                </script>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" id="flashMessage">
                    <?= session()->getFlashdata('success') ?>
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('flashMessage').style.display = 'none';
                    }, 3000);
                </script>
            <?php endif; ?>
            
            <form action="/doLogin" method="post">
                <?= csrf_field() ?>
                
                <div class="form-group mb-3">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group mb-3 password-container">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                    <i class="fas fa-eye" id="togglePassword" onclick="togglePasswordVisibility()"></i>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">
                    Login
                </button>
            </form>
            
            <p class="text-center mt-3">
                Don't have an account? <a href="/register">Register</a>
            </p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePasswordVisibility() {
            var passwordField = document.getElementById('password');
            var toggleIcon = document.getElementById('togglePassword');
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>

<?= $this->endSection() ?>
