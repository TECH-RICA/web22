<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "27580072@willy", "members");
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
    header("Location: ../phpfiles/contact-us.php?success=1");
    exit;
}
$success = isset($_GET['success']) ? "Your message has been sent!" : null;
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="contact-us.css">
     <link rel="stylesheet" href="footer.css">
      <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="dark-mode.css">
</head>
<body>

<?php if (isset($success)): ?>
    <?php if ($success): ?>
    <div class="success-message" id="successMsg"><?php echo $success; ?></div>
    <?php endif; ?>
<?php endif; ?>

     <?php include 'header.php'; ?>
<!--=====================================contact-us section=============-->
    <div class="contact-hero">
        <h2>Let’s Connect!</h2>
        <p>Have a question, project, or feedback? Fill out the form or reach us directly—we’ll get back to you soon!</p>
    </div>
    <section class="form-section">
        <div class="message-us">
            <h3>send us a message</h3>
         <form action="contact-us.php" method="POST">
            <label for="name"><i class="fa fa-user"></i> Full name</label>
            <input type="text" id="name" required placeholder="Enter your name" name ="name">
            <label for="email"><i class="fa fa-envelope"></i> email</label>
            <input type="email" id="email" required placeholder="Enter your email" name="email">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="message"> <i class="fa fa-comment-dots"></i> message</label>
            <textarea name="message" id="message" placeholder="Message" cols="19" rows="4"></textarea>
            <button type="submit" id="submit-btn">
    <i class="fa fa-paper-plane"></i> Submit
</button>
         </form>
        </div>
        <div class="contacts">
            <h3>Get in touch with us</h3>
            <p><i class="fa fa-map-marker-alt"></i> Address :Kutus, Kirinyaga, Kenya</p>
            <p>Email: <a href="mailto:techrica101@gmail.com"><i class="fa fa-envelope"></i>techrica101@gmail.com</a></p>
                <p><i class="fa fa-phone"></i> +254 712 345678</p>
            <p><i class="fa fa-clock"></i> Mon-Fri: 8am - 6pm</p>
            <h6>Follow us</h6>
            <ul>
                <li>  <a href="#"><i class="fab fa-facebook"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
            </ul>
        </div>
    </section>
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
</

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let msg = document.getElementById('successMsg');
        if(msg) {
            setTimeout(function() {
                msg.style.transition = 'opacity 0.5s';
                msg.style.opacity = 0;
                setTimeout(function() { msg.style.display = 'none'; }, 500);
            }, 2000);
            // Remove ?success=1 from URL after showing the message
            if (window.location.search.includes('success=1')) {
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        }
        // Client-side validation for empty fields
        var form = document.querySelector('.message-us form');
        if(form) {
            form.addEventListener('submit', function(e) {
                let name = form.name.value.trim();
                let email = form.email.value.trim();
                let message = form.message.value.trim();
                if(!name || !email || !message) {
                    alert('Please fill in all fields.');
                    e.preventDefault();
                }
            });
        }
    });
    </script>
    <script src="new.js" defer></script>
    <script src = "index.js"></script>      
      
</body>
</html>