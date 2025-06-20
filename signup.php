<?php
session_start();
$message = "";
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);
// Use error_log("Error details here"); to log custom errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $username = trim($_POST['username'] ?? '');

    // Validate input (add your own validation here)

    // Hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Generate confirmation code
    $confirm_code = rand(100000, 999999);

    // Save user to database as unverified
    $conn = new mysqli("localhost", "root", "", "members");
    $stmt = $conn->prepare("INSERT INTO users (email, password, username, is_verified, confirm_code) VALUES (?, ?, ?, 0, ?)");
    $stmt->bind_param("sssi", $email, $hash, $username, $confirm_code);
    if ($stmt->execute()) {
        // Send confirmation code to email
        $to = $email;
        $subject = "Confirm your email - TechRica";
        $body = "Your confirmation code is: $confirm_code";
        $headers = "From: techrica101@gmail.com\r\n";
       <?php
require_once 'send_email.php';
sendSMTPMail($to, $subject, $body);

        $_SESSION['pending_email'] = $email;
        header("Location: confirm-email.php");
        exit;
    } else {
        $message = "<div class='error'>Registration failed. Email may already be used.</div>";
    }
    $stmt->close();
    $conn->close();
}
?>
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email address.";
}
$username = htmlspecialchars(trim($_POST['username']));
<!-- Your signup form here -->
<form method="POST">
    <input type="email" name="email" required placeholder="Email">
    <input type="text" name="username" required placeholder="Username">
    <input type="password" name="password" required placeholder="Password">
    <input type="submit" value="Sign Up">
</form>
<?php echo $message; ?>