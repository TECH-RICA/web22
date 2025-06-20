<?php
session_start();
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code'] ?? '');
    $email = $_SESSION['pending_email'] ?? '';

    $conn = new mysqli("localhost", "root", "", "members");
    $stmt = $conn->prepare("SELECT confirm_code FROM users WHERE email=? AND is_verified=0");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($db_code);
    if ($stmt->fetch() && $code == $db_code) {
        $stmt->close();
        $stmt = $conn->prepare("UPDATE users SET is_verified=1 WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $message = "<div class='success'>Email confirmed! You can now log in.</div>";
        unset($_SESSION['pending_email']);
    } else {
        $message = "<div class='error'>Invalid code.</div>";
    }
    $stmt->close();
    $conn->close();
}
?>
<form method="POST">
    <label>Enter the code sent to your email:</label>
    <input type="text" name="code" required>
    <input type="submit" value="Confirm Email">
</form>
<?php echo $message; ?>