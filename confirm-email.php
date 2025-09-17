<?php
session_start();
$message = "";
$email = $_POST['email'] ?? ($_SESSION['pending_email'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $email) {
    $code = trim($_POST['confirm_code'] ?? '');
    $conn = new mysqli("localhost", "root", "27580072@willy", "members");
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=? AND confirm_code=? AND is_verified=0");
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();
        // Mark as verified
        $stmt2 = $conn->prepare("UPDATE users SET is_verified=1, confirm_code=NULL WHERE id=?");
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
        $stmt2->close();
        $message = "<div class='success'>Email confirmed! You can now log in.</div>";
        unset($_SESSION['pending_email']);
        $show_login = true;
    } else {
        $message = "<div class='error'>Invalid confirmation code or email.</div>";
        $show_login = false;
    }
    $conn->close();
} else {
    $show_login = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Confirm Email</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <h2>Confirm Your Email</h2>
    <?php if ($message) echo $message; ?>
    <?php if ($show_login ?? false): ?>
        <a href="login-sign-up.php" class="btn btn-primary">Go to Login</a>
    <?php elseif ($email): ?>
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required value="<?php echo htmlspecialchars($email); ?>">
            <label for="confirm_code">Enter Confirmation Code:</label>
            <input type="text" name="confirm_code" id="confirm_code" required>
            <button type="submit">Confirm Email</button>
        </form>
    <?php else: ?>
        <div class="error">No pending email to confirm.</div>
    <?php endif; ?>
</body>
</html>