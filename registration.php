<?php
include 'settings.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password_confirmation = trim($_POST['password_confirmation']);

    // Server-side validation
    if (empty($username) || empty($email) || empty($password) || empty($password_confirmation)) {
        $message = 'Please fill all fields!';
    } elseif ($password !== $password_confirmation) {
        $message = 'Passwords do not match!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email!';
    } else {
        $user_data = [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'=>''
        ];
        $previous_users=file_exists($file_path) ? file_get_contents($file_path) :'';
        if(!empty($previous_users)) {
           $allUser = json_decode($previous_users);
        } else {
            $allUser = [];
            $user_data['role'] = 'admin';
        }

        $allUser[] = $user_data;

        file_put_contents($file_path, json_encode($allUser));
        $message = 'Registration successful!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Register</h2>
            <?php if ($message): ?>
            <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>
            <form action="" method="POST" id="registrationForm">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                        required>
                    <div id="passwordHelp" class="form-text"></div>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS and custom script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const password_confirmation = document.getElementById('password_confirmation').value;
        const passwordHelp = document.getElementById('passwordHelp');

        if (password !== password_confirmation) {
            e.preventDefault(); 
            passwordHelp.textContent = 'Passwords do not match!';
            passwordHelp.style.color = 'red';
        } else {
            passwordHelp.textContent = '';
        }
    });
    </script>
</body>

</html>