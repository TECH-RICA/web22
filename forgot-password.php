<?php
session_start();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='error'>Invalid email address.</div>";
    } else {
        $conn = new mysqli("localhost", "root", "", "members");
        $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $reset_code = rand(100000, 999999); // 6-digit code
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_code'] = $reset_code;
            $_SESSION['reset_code_time'] = time();

            // Send email
            $to = $email;
            $subject = "Password Reset Code - TechRica";
            $body = "Your password reset code is: $reset_code\nThis code will expire in 10 minutes.";
            $headers = "From: techrica101@gmail.com\r\n";
            <?php
require_once 'send_email.php';
sendSMTPMail($to, $subject, $body, $headers);

            $message = "<div class='success'>A reset code has been sent to your email.</div>";
        } else {
            $message = "<div class='error'>No account found with that email.</div>";
        }
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
<h2>Forgot Password</h2>
<?php echo $message; ?>
<form method="POST">
    <label for="email">Enter your email:</label>
    <input type="email" name="email" required>
    <input type="submit" value="Send Reset Code">
</form>
</body>
</html>