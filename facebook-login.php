<?php
session_start();
require_once __DIR__ . '/facebook-php-sdk/src/Facebook/autoload.php';

$fb = new \Facebook\Facebook([
    'app_id' => '4058744931059984',
    'app_secret' => 'bda096d55d1798dc9d5b7367d38e1ec4',
    'default_graph_version' => 'v19.0',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email'];

if (!isset($_GET['code'])) {
    $loginUrl = $helper->getLoginUrl('http://localhost/web22/phpfiles/facebook-login.php', $permissions);
    header('Location: ' . $loginUrl);
    exit;
} else {
    $accessToken = $helper->getAccessToken();
    $response = $fb->get('/me?fields=id,name,email', $accessToken);
    $user = $response->getGraphUser();
    $email = $user->getEmail();
    $name = $user->getName();

    // Check or create user in your DB, then log in
    $conn = new mysqli("localhost", "root", "27580072@willy", "members");
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $email;
        $_SESSION['role'] = 'user';
        header("Location: ../phpfiles/profile.php");
        exit;
    } else {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, is_verified) VALUES (?, ?, '', 1)");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['username'] = $email;
        $_SESSION['role'] = 'user';
        header("Location: ../phpfiles/profile.php");
        exit;
    }
    $stmt->close();
    $conn->close();
}
?>