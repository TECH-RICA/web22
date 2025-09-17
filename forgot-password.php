<?php
session_start();
$message = "";

// Track how many reset codes have been sent in this session
if (!isset($_SESSION['reset_code_count'])) {
    $_SESSION['reset_code_count'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='error'>Invalid email address.</div>";
    } else {
        $conn = new mysqli("localhost", "root", "27580072@willy", "members");
        $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            // --- Cooldown logic ---
            $now = time();
            if (
                isset($_SESSION['reset_code_time']) &&
                $_SESSION['reset_code_count'] >= 2 &&
                $now - $_SESSION['reset_code_time'] < 43200 // 12 hours = 43200 seconds
            ) {
                $wait = ceil((43200 - ($now - $_SESSION['reset_code_time'])) / 3600);
                $message = "<div class='error'>You have reached the maximum number of reset code requests.
                 Please wait {$wait} more hour(s) before requesting again.</div>";
            } elseif (

                isset($_SESSION['reset_code_time']) &&
                $now - $_SESSION['reset_code_time'] < 600 && // 10 minutes
                $_SESSION['reset_code_count'] < 2
            ) {
                $wait = 10 - floor(($now - $_SESSION['reset_code_time']) / 60);
                $message = "<div class='error'>A reset code was already sent. Please wait {$wait} more minute(s) before requesting a new code.</div>";
            } else {
                // Allow sending code
                $reset_code = rand(100000, 999999); // 6-digit code
                $_SESSION['reset_email'] = $email;
                $_SESSION['reset_code'] = $reset_code;
                $_SESSION['reset_code_time'] = $now;
                $_SESSION['reset_code_count'] = ($_SESSION['reset_code_count'] >= 2) ? 1 : $_SESSION['reset_code_count'] + 1;

                // Send email
                $to = $email;
                $subject = "Password Reset Code - TechRica";
                $body = "Your password reset code is: $reset_code\nThis code will expire in 10 minutes.";
                $headers = "From: techrica101@gmail.com\r\n";
                require_once '../phpfiles/send_email.php';
                sendSMTPMail($to, $subject, $body, $headers);

                // Redirect after sending code
                $_SESSION['reset_notify'] = "A reset code has been sent to your email. Please check your inbox.";
                header("Location: ../phpfiles/reset-password.php");
                exit;
            }
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