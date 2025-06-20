<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "<div class='error'>Invalid CSRF token.</div>";
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "<div class='error'>Invalid email format.</div>";
        } elseif ($password !== $confirm) {
            $message = "<div class='error'>Passwords do not match.</div>";
        } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/', $password)) {
            $message = "<div class='error'>Password must be at least 8 characters and include letters, numbers, and symbols.</div>";
        } else {
            $conn = new mysqli("localhost", "root", "", "members");
            $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $message = "<div class='error'>Email already registered.</div>";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $hash);
                $stmt->execute();
                $message = "<div class='success'>Registration successful! <a href='login.php'>Login here</a>.</div>";
            }
            $stmt->close();
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - TechRica</title>
    <link rel="stylesheet" href="register.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var np = document.getElementById('password');
        if(np) {
            np.addEventListener('input', function() {
                var val = this.value;
                var score = 0;
                if(val.length >= 8) score++;
                if(/[A-Z]/.test(val)) score++;
                if(/[0-9]/.test(val)) score++;
                if(/[^A-Za-z0-9]/.test(val)) score++;
                document.getElementById('strengthBar').value = score;
            });
        }
    });
    </script>
</head>
<body>
<main>
    <div class="profile-container">
        <h2>Register</h2>
        <?php if ($message) echo $message; ?>
        <form method="POST" class="profile-actions">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <progress id="strengthBar" value="0" max="4" style="width:100%;"></progress>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="submit" value="Register">
        </form>
        <p><a href="login.php">Already have an account? Login</a></p>
    </div>
</main>
</body>
</html>