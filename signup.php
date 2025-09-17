<?php
// filepath: /opt/lampp/htdocs/web22/signup.php
session_start();
require_once 'send_email.php';
$message = "";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $username = htmlspecialchars(trim($_POST['username'] ?? ''));

    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='error'>Invalid email address.</div>";
    } elseif (strlen($username) < 3) {
        $message = "<div class='error'>Username must be at least 3 characters.</div>";
    } elseif (strlen($password) < 8) {
        $message = "<div class='error'>Password must be at least 8 characters.</div>";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $confirm_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $conn = new mysqli("localhost", "root", "27580072@willy", "members");
        if ($conn->connect_error) {
            $message = "<div class='error'>Database connection failed.</div>";
        } else {
            $check = $conn->prepare("SELECT id FROM users WHERE email=?");
            $check->bind_param("s", $email);
            $check->execute();
            $check->store_result();
            if ($check->num_rows > 0) {
                $message = "<div class='error'>Email is already registered.</div>";
            } else {
                $stmt = $conn->prepare("INSERT INTO users (username, email, password, is_verified, confirm_code) VALUES (?, ?, ?, 0, ?)");
                $stmt->bind_param("ssss", $username, $email, $hash, $confirm_code);
                if ($stmt->execute()) {
                    $to = $email;
                    $subject = "Confirm your email - TechRica";
                    $body = "Welcome to TechRica!\n\nYour confirmation code is: $confirm_code\n\nEnter this code on the confirmation page to activate your account.";
                    sendSMTPMail($to, $subject, $body);

                    $_SESSION['pending_email'] = $email;
                    header("Location: confirm-email.php");
                    exit;
                } else {
                    $message = "<div class='error'>Registration failed. Please try again.</div>";
                }
                $stmt->close();
            }
            $check->close();
            $conn->close();
        }
    }
}
if ($message) echo $message;
?>