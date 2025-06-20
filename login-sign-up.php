<?php session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Sign Up / Forgot Password - TechRica</title>
    <link rel="stylesheet" href="login-signup.css">
    <link rel="stylesheet" href="dark-mode.css">

    <style>
        .auth-container { display: none; }
        .auth-container.active { display: block; }
        .auth-link { margin-top: 18px; text-align: center; }
        .success, .error { text-align: center; margin: 10px 0; }
    </style>
</head>
<body>
<header>
    <div class="menu-toggle">
        <span class="hamburger">&#9776;</span>
        <span class="close">&times;</span>
    </div>
    <h1>TechRica</h1>
    <nav class="navbar">
        <ul class="nav-links">
            <li><a class="nav-link" data-page="index.php">Home</a></li>
            <li><a class="nav-link" data-page="about-us.php">About us</a></li>
            <li><a class="nav-link" data-page="faqs.html">FAQs</a></li>
            <li><a class="nav-link" data-page="contact-us.php">Contacts</a></li>
            <li><a class="nav-link" data-page="login-sign-up.php">Login</a></li>
            <li><a class="nav-link" data-page="profile.php">Profile</a></li>
             <li><button onclick="toggleDarkMode()" id="darkModeBtn">🌙 Dark Mode</button></li>
        </ul>
    </nav>
</header>

<main>
    <!-- Login Form -->
    <div class="auth-container active" id="login-form">
        <h2>Login</h2>
        <h3>Welcome Back,</h3>
        <form class="auth-form" action="login.php" method="POST">
            <label for="login-email">Email</label>
            <input type="email" id="login-email" name="email" required>
            <label for="pass">Password</label>
            <input type="password" id="pass" name="password" required>
             <input type="checkbox" id="showPass" onclick="togglePass()"> Show Password
               <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
               <input type="submit" value="Login" id = "btn">
        </form>
        <div class="auth-link">
            Don't have an account? <a href="#" id="show-register">Register</a><br>
            <a href="#" id="show-forgot">Forgot Password?</a>
        </div>
    </div>

    <!-- Register Form -->
    <div class="auth-container" id="register-form">
        <h2>Register</h2>
        <h3>Join Us Now</h3>
        <form class="auth-form" action="signup.php" method="POST">
            <label for="signup-name">Full Name</label>
            <input type="text" id="signup-name" name="name" required>
            <label for="signup-email">Email</label>
            <input type="email" id="signup-email" name="email" required>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            <progress id="strengthBar" value="0" max="4" style="width:100%;"></progress>
            <input type="checkbox" id="showPass" onclick="togglePassword()"> Show Password
            <input type="submit" value="Sign Up" id = "btn">
        </form>
        <div class="auth-link">
            Already have an account? <a href="#" id="show-login-from-register">Login</a>
        </div>
    </div>

    <!-- Forgot Password Form -->
    <div class="auth-container" id="forgot-form">
        <h2>Forgot Password</h2>
        <h3>Reset password</h3>
        <form class="auth-form" action="forgot-password.php" method="POST">
            <label for="forgot-email">Enter your email</label>
            <input type="email" id="forgot-email" name="email" required>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="submit" value="Send Reset Link" id = "btn">
        </form>
        <div class="auth-link">
            Remembered? <a href="#" id="show-login-from-forgot">Login</a>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2025 TechRica. All Rights Reserved.</p>
</footer>
<script src="login-sign-up.js"></script>
<script src="new.js" defer></script>
<script src = "index.js"></script>
</body>
</html>