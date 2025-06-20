<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "members");
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    $success = "Your message has been sent!";
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="contact-us.css">
    <link rel="stylesheet" href="dark-mode.css">
</head>
<body>
 <?php if (isset($success)): ?>
<script>
    alert("<?php echo $success; ?>");
</script>
<?php endif; ?>

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
    <li><a class="nav-link" data-page="faqs.html">faqs</a></li>
    <li><a class="nav-link" data-page="contact-us.php">contacts</a></li>
    <li><a class="nav-link" data-page="login-sign-up.php">login</a></li>
    <li><a class="nav-link" data-page="profile.php">Profile</a></li>
     <li><button onclick="toggleDarkMode()" id="darkModeBtn">🌙 Dark Mode</button></li>

</ul>
</nav>
</header>
<!--=====================================contact-us section=============-->
    <div class="contact-us">
            <div>
                <img src="images/phone.png" alt="phone-icon">
        <h2 >contact Us</h2>
            </div>
            <p>We'd love to hear from you! 
            Reach out with any questions or feedback.</p>
    </div>
    <section class="form-section">
        <div class="message-us">
            <h3>send us a message</h3>
         <form action="contact-us.php" method="POST">
            <label for="name">Full name</label>
            <input type="text" id="name" required placeholder="Enter your name" name ="name">
            <label for="email">email address</label>
            <input type="text" id="email" required placeholder="Enter your email" name="email">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="message">message</label>
            <textarea name="message" id="message" placeholder="Message" cols="19" rows="4"></textarea>
            <input type="submit" value="submit" id="submit-btn">
         </form>
        </div>
        <div class="contacts">
            <h3>Get in touch with us</h3>
            <p>Address: Kutus,Kirinyaga.</p>
            <p>Email: <a href="techrica101@gmail.com">techrica101@gmail.com</a></p>
            <p>Phone: +254113798611</p>
            <h6>follow us</h6>
            <ul>
                <li><a href="#"><img src="images/icons8-facebook-logo-48 (1).png" alt="facebook icon"></a></li>
                <li><a href="#"><img src="images/icons8-instagram-48.png" alt="instagram icon"></a></li>
                <li><a href="#"><img src="images/whatsapp.png" alt="whatsapp icon"></a></li>
            </ul>
        </div>
    </section>
    <footer>
        <p>&copy; 2025 TechRica.All Rights Reserved.</p>
    </footer>

    <script src="new.js" defer> </script>
    <script src = "index.js"></script>
      
      
</body>
</html>