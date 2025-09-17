
<?php
session_start();
$message = "";

// Show notification if set (after redirect from forgot-password)
if (isset($_SESSION['reset_notify'])) {
    $message .= "<div class='success'>" . $_SESSION['reset_notify'] . "</div>";
    unset($_SESSION['reset_notify']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code'] ?? '');
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Check if code is valid and not expired (10 min)
    if (
        !isset($_SESSION['reset_code'], $_SESSION['reset_email'], $_SESSION['reset_code_time']) ||
        time() - $_SESSION['reset_code_time'] > 600
    ) {
        $message = "<div class='error'>Reset code expired. Please request a new one.</div>";
    } elseif ($code != $_SESSION['reset_code']) {
        $message = "<div class='error'>Invalid reset code.</div>";
    } elseif ($new_password !== $confirm_password) {
        $message = "<div class='error'>Passwords do not match.</div>";
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/', $new_password)) {
        $message = "<div class='error'>Password must be at least 8 characters and include letters, numbers, and symbols.</div>";
    } else {
        // Update password
        $conn = new mysqli("localhost", "root", "27580072@willy", "members");
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $stmt->bind_param("ss", $hash, $_SESSION['reset_email']);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        // Clear reset session
        unset($_SESSION['reset_code'], $_SESSION['reset_email'], $_SESSION['reset_code_time']);
        $message = "<div class='success'>Password reset successful. <a href='login.php'>Login</a></div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="reset-password.css">
</head>
<body>

<div class="auth-container">
    <h2>Reset Password</h2>
    <?php echo $message; ?>
    <form method="POST">
        <label for="code">Enter the code sent to your email:</label>
        <input type="text" name="code" required>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" required>
        <input type="submit" id="reset-btn" value="Reset Password">
    </form>
</div>
</body>
</html>