<?php
require_once __DIR__ . '/google-api-php-client/vendor/autoload.php';
session_start();

$client = new Google_Client();
$client->setClientId('543666479889-8m22sti5gmjn57dv37thvt65bfd2komm.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/web22/google-login.php');
$client->addScope('email');
$client->addScope('profile');

if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit;
} else {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);
    $oauth2 = new Google_Service_Oauth2($client);
    $userinfo = $oauth2->userinfo->get();

    $email = $userinfo->email;
    $name = $userinfo->name;

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
        header("Location: profile.php");
        exit;
    } else {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, is_verified) VALUES (?, ?, '', 1)");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['username'] = $email;
        $_SESSION['role'] = 'user';
        header("Location: profile.php");
        exit;
    }
    $stmt->close();
    $conn->close();
}

?>