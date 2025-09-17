<?php session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
} 
$message = '';
if (isset($_GET['error'])) {
    $message = "<div class='error'>" . htmlspecialchars($_GET['error']) . "</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Sign Up / Forgot Password - TechRica</title>
    <link rel="stylesheet" href="login-signup.css">
     <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="dark-mode.css">
     <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>
<body>
<?php include 'header.php'; ?>

<main>
    <!-- Login Form -->
    <div class="auth-container active" id="login-form">
        <h2>Login</h2>
        <h3>Welcome Back,</h3>
        <form class="auth-form" action="login.php" method="POST">
            <label for="login-email">Email</label>

                 <div class="input-icon">
         <input type="email" id="login-email" name="email" required placeholder="Email">
         <i class="fa fa-envelope"></i>
            </div>

            <label for="pass">Password</label>

            <div class="input-icon">
         <input type="password" id="login-password" name="password" required placeholder="Password">
         <span class="toggle-password" onclick="togglePassword(event, 'login-password', this)">
             <i class="fa fa-eye"></i>
         </span>
         <i class="fa fa-lock"></i>
            </div>
           
               <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
               <button type = "submit" id = "loginBtn"><i class="fa fa-sign-in-alt"></i> Login</button>
        </form>
        <div class="auth-link">
            Don't have an account? <a href="#" id="show-register">Register</a><br>
            <a href="#" id="show-forgot">Forgot Password?</a>
        </div>
    </div>

    <!-- Register Form -->
    <div class="auth-container" id="register-form" style = "display:none;">
        <h2>Register</h2>
        <h3>Join Us Now</h3>
         <?php echo $message; ?>
        <form class="auth-form" action="signup.php" method="POST" >
            <label for="signup-name">Full Name</label>
            <div class="input-icon">
    <input type="text" id="signup-name" name="username" required placeholder="Full Name">
    <i class="fa fa-user"></i>
</div>
            <label for="signup-email"><i class="fa fa-envelope"></i> Email</label>
             <div class="input-icon">
            <input type="email" id="signup-email" name="email" required placeholder="Email">
             <i class="fa fa-envelope"></i>
              </div>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="signup-password">Password</label>
           <div class="input-icon">
    <input type="password" id="signup-password" name="password" required placeholder="Password">
    <span class="toggle-password" onclick="togglePassword(event, 'signup-password', this)">
        <i class="fa fa-eye"></i>
    </span>
    <i class="fa fa-lock"></i>
        </div>
            <label for="signup-confirm-password">Confirm Password</label>
                   <div class="input-icon">
         <input type="password" id="signup-confirm-password" name="confirm_password" required placeholder="Confirm Password">
            <span class="toggle-password" onclick="togglePassword(event, 'signup-confirm-password', this)">
        <i class="fa fa-eye"></i>
              </span>
            <i class="fa fa-lock"></i>
            </div>
            <progress id="strengthBar" value="0" max="4" style="width:100%;"></progress>
           <button type = "submit" id = "registerBtn"><i class="fa fa-user-plus"></i> Register Now</button></button>
           <div class="auth-link">
    <a href="#" id="back-to-social">Back to social options</a>
</div>
        </form>
</div>
        <div class="social-register auth-container" id="social-register-options" style = "display = block;">
    <p style="text-align:center; color:var(--text-light); margin:18px 0;">Register using</p>
    <a href="google-login.php" class="social-btn google-btn">
        <i class="fab fa-google"></i> Sign in with Google
    </a>
    <a href="facebook-login.php" class="social-btn facebook-btn">
        <i class="fab fa-facebook"></i> Sign in with Facebook
    </a>
    <button type="button" class="social-btn email-btn" id="choose-email-btn">
        <i class="fa fa-envelope"></i> Email
    </button>
</div>
    <!-- Forgot Password Form -->
    <div class="auth-container" id="forgot-form">
        <h2>Forgot Password</h2>
        <h3>Reset password</h3>
        <form class="auth-form" action="forgot-password.php" method="POST">
            <label for="forgot-email">Enter your email</label>
                  <div class="input-icon">
             <input type="email" id="reset-email" name="email" required placeholder="Email">
             <i class="fa fa-envelope"></i>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            
            <button type = "submit" id = "resetBtn"><i class="fa fa-paper-plane"></i> Send Reset Link</button>
        </form>
        <div class="auth-link">
            Remembered? <a href="#" id="show-login-from-forgot">Login</a>
        </div>
    </div>
</main>
 <footer>
    
  <section class="footer">
     <div class="footer-desc">
    <div>
        <picture>
        <img src="images/IMG-20250413-WA0003.jpg" alt="our company logo">
    </picture>
    <h6>Tech.Rica</h6>
    </div>
      <p>Leading the future with cutting-edge AI solutions and digital innovations</p>   
   </div>
      
        <span class="footer-socials">
            <a href="https://facebook.com/" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://linkedin.com/" target="_blank"><i class="fab fa-linkedin"></i></a>
            <a href="https://instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
            <a href="https://wa.me/your-number" target="_blank"><i class="fab fa-whatsapp"></i></a>
            <a href="https://t.me/yourusername" target="_blank"><i class="fab fa-telegram"></i></a>
        </span>
        <div class="quick-links">
            <h1>Quick Links</h1>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
        <div class="footer-services">
            <h1>Services</h1>
            <ul>
                <li><a href="#">AI consulting</a></li>
                <li><a href="#">Automation Tools</a></li>
                <li><a href="#">Digital Solutions</a></li>
                <li><a href="#">Machine Learning</a></li>
            </ul>
        </div>
        <div class="footer-contact">
            <p><i class="fa fa-phone"></i> +254113798611 </p>
            <p><i class="fa fa-envelope"></i> info@techrica.com</p>
            <p><i class="fa fa-map-marker-alt"></i>  Nairobi,Kenya</p>
        </div>
  </section>
  <hr></hr>
   
 <p class = "footer-p">&copy; 2025 Tech.Rica.All Rights Reserved.Power the future with AI.</p>
</footer>

<script src="new.js" defer></script>
<script src = "index.js"></script>
  <script src="login-sign-up.js"></script>
</body>
</html>