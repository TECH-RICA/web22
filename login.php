<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token');
    }
    // ...process login...
}
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email address.";
}
$username = htmlspecialchars(trim($_POST['username']));
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();



$conn = new mysqli("localhost", "root", "", "members");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$message = "";
$mess;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "<div class='error'>Invalid CSRF token.</div>";

    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hashedPassword);
            $stmt->fetch();
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $email;
                header("Location: profile.php");
                exit;
            } else {
                $message = "<div class='error'>Invalid email or password.</div>";
               
            }
        } else {
            $message = "<div class='error'>Invalid email or password.</div>";
    
            
           
        }
        $stmt->close();
    }
}
session_regenerate_id(true);
$_SESSION['user_id'] = $user_id;
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <p style = " text decoration:none;"><a href="login-sign-up.php">Try to Login again!</a></p>
</body>
</html>
<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - TechRica</title>
    <link rel="stylesheet" href="login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<main>
    <div class="profile-container">
        <h2>Login</h2>
        <?php if ($message) echo $message; ?>
        <form method="POST" class="profile-actions">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="submit" value="Login" id="submit-btn">
</form>
        <p><a href="register.php">Don't have an account? Register</a></p>
    </div>
</main>
</body>
</html>
-->