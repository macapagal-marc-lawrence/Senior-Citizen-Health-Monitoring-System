<?= $this->extend('layouts/frontend.php') ?>

<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
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
            height: auto;
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

        h2 {
            text-align: center;
            color: #00695c;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-group label {
            font-weight: 600;
            color: #00695c;
        }

        .form-control {
            border-radius: 25px;
            border: 1px solid #b2dfdb;
            font-size: 16px;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #26a69a;
            box-shadow: 0 0 10px rgba(38, 166, 154, 0.3);
        }

        .btn-primary {
            background: #26a69a;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 16px;
            transition: background 0.3s ease, transform 0.3s ease;
            margin-top: 1px;
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
            <h2>Register</h2>
            
            <?php if ($errors = session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?php if (is_array($errors)): ?>
                        <?php foreach ($errors as $error): ?>
                            <p><?= esc($error) ?></p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p><?= esc($errors) ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <form action="/doRegister" method="post">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?= old('name') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?= old('email') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                
                <div class="form-group">
                    <label for="emergency_contact">Emergency Contact:</label>
                    <input type="number" class="form-control" name="emergency_contact" id="emergency_contact" value="<?= old('emergency_contact') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" class="form-control" name="dob" id="dob" value="<?= old('dob') ?>" required>
                </div>

                <!-- Role Selection Dropdown -->
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="senior_citizen" <?= old('role') == 'senior_citizen' ? 'selected' : '' ?>>Senior Citizen</option>
                        <option value="caregiver" <?= old('role') == 'caregiver' ? 'selected' : '' ?>>Caregiver</option>
                        <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
            
            <p class="text-center mt-3">
                Already have an account? <a href="/login">Login</a>
            </p>
        </div>
    </div>
</body>
</html>

<?= $this->endSection() ?>
