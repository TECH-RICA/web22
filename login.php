<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = "";
$user_id = null; // Initialize to avoid undefined variable warning

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "<div class='error'>Invalid CSRF token.</div>";
    } else {
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $conn = new mysqli("localhost", "root", "27580072@willy", "members");
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }
        // Fetch id, password, role, and verification status
        $stmt = $conn->prepare("SELECT id, password, role, is_verified FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hashedPassword, $role, $is_verified);
            $stmt->fetch();
            if (!$is_verified) {
                $message = "<div class='error'>Please confirm your email before logging in.</div>";
            } elseif (password_verify($password, $hashedPassword)) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $email;
                $_SESSION['role'] = $role; // Store the role in session
                $stmt->close();
                $conn->close();
                // Redirect based on role
                if ($role === 'admin') {
                    header("Location: admin-dashboard.php");
                } else {
                    header("Location: profile.php");
                }
                exit;
            } else {
                $message = "<div class='error'>Invalid email or password.</div>";
            }
        } else {
            $message = "<div class='error'>Invalid email or password.</div>";
        }
        $stmt->close();
        $conn->close();
    }
}

// Session timeout logic
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechRica</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <?php if ($message) echo $message; ?>
    <p><a href="login-sign-up.php">Try to Login again!</a></p>
</body>
</html>
