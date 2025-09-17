<?php
ob_start();
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    // 900 seconds = 15 minutes
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit;
}
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);
// Use error_log("Error details here"); to log custom errors
$_SESSION['LAST_ACTIVITY'] = time();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// Greeting logic
$hour = date('H');
if ($hour < 12) {
    $greeting = "Good morning";
} elseif ($hour < 18) {
    $greeting = "Good afternoon";
} else {
    $greeting = "Good evening";
}

// Track visitor
$conn = new mysqli("localhost", "root", "27580072@willy", "members"); // Use your DB name
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$conn->query("INSERT INTO visitors (visit_time) VALUES (NOW())");
$result = $conn->query("SELECT COUNT(*) as total FROM visitors");
$visitorCount = 0;
if ($row = $result->fetch_assoc()) {
    $visitorCount = $row['total'];
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta name="description" content="TechRica - Your tech community">
    <meta name="keywords" content="tech, community, blog">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="indexDarkMode.css">
     <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <script>
document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function() {
        let msg = document.querySelector('.success, .error');
        if(msg) msg.style.display = 'none';
    }, 4000);
});
</script>
</head>
<body>
   
 <?php include 'header.php'; ?>

<div class="welcome-container">
    <?php if ($username): ?>
        <div class="welcome-banner">
            <?php echo $greeting; ?>, <?php echo htmlspecialchars($username); ?>!
            <a href="profile.php" class="dashboard-btn">Go to Dashboard</a>
        </div>
    <?php else: ?>
        <div class="welcome-banner">
            Hello user!
        </div>
    <?php endif; ?>
</div>
    <section class="intro" id = "intro">
           <div>
             <img src="images/IMG-20250413-WA0003.jpg" alt="our company logo">
           <h2> TechRica - Smart Tech Company</h2>
           </div>
        <p>Your go-to solution for premium digital services.
           Empowering You with Smart Digital Solutions.</p>
           <button><a href="#services">Explore Our Services</a></button>
    </section>
    
   
    
<section class="services-grid">
        <h2 class = "darkTitles">What We Offer</h2>
        <div class="services-list">
            <div class="service-item">
                  <i class="fa fa-code fa-2x"></i>
                <!--<img src="images/IMG-20250413-WA0003.jpg" alt="Web Development" style="width:60px;height:60px;border-radius:30px;">-->
                <h4 class = "darkTitles">Web Development</h4>
                <p class = "darkTitles">Custom websites and web apps tailored to your needs.</p>
            </div>
            <div class="service-item">
                <i class="fa fa-cogs"></i>
               <!--  <img src="comp_Photos/nubelson-fernandes-SPaPUtVmp2w-unsplash.jpg" alt="Software Solutions" style="width:60px;height:60px;border-radius:30px;">-->
                <h4 class = "darkTitles">Software Solutions</h4>
                <p class = "darkTitles">Modern, scalable software for business growth.</p>
            </div>
            <div class="service-item">
                <i class="fa fa-comments"></i>
                <!--<img src="comp_Photos/rafael-pol-6b5uqlWabB0-unsplash.jpg" alt="Tech Consultation" style="width:60px;height:60px;border-radius:30px;">-->
                <h4 class = "darkTitles">Tech Consultation</h4>
                <p class = "darkTitles">Expert advice to help you make the right tech decisions.</p>
            </div>
        </div>
    </section>

    <section class="how-it-works">
        <h2>How It Works</h2>
        <div class="steps">
            <div class="step">
                <!--<span class="step-number">1</span>-->
                <i class="fa fa-envelope-open-text fa-2x"></i>
                <h5>Contact Us</h5>
                <p>Reach out via our <a href="contact-us.php">contact page</a> or phone/email.</p>
            </div>
            <div class="step">
                <i class="fa fa-handshake"></i>
                <!--<span class="step-number">2</span>-->
                <h5>Consultation</h5>
                <p>We discuss your needs and propose the best solutions.</p>
            </div>
            <div class="step">
                <!--<span class="step-number">3</span>-->
                 <i class="fa fa-rocket"></i>
                <h5>Project Delivery</h5>
                <p>We deliver your project on time and provide ongoing support.</p>
            </div>
        </div>
    </section>

     <section id="start-receiving-services">
        <section class="start-receiving">
        <h5>Start Receiving TechRica Services</h5>
        <p>Contact Us and provide your service kind you would like us to work for you.</p>
        <button><a href="contact-us.php">Contact Us</a></button>
    </section>
     </section>
<section id = "why">
     <h3 id = "why-h3" >Why Choose Us</h3>
    <section class="why">
       <div>
            <!--<img src="comp_Photos/rafael-pol-6b5uqlWabB0-unsplash.jpg" alt="" id="image4" >-->
            <i class="fa fa-bolt"></i>
        <h4>Fast Delivery Of Services</h4>
        <p>We serve our customer need within a short period of time as necessary.</p>
       </div>
       <div>
       <!-- <img src="comp_Photos/nubelson-fernandes-SPaPUtVmp2w-unsplash.jpg" alt="" id="image1">-->
        <i class="fa fa-star"></i>
        <h4>High Quality Of Services</h4>
        <p id="paragraph_transform">We provide high quality services to all of our customer ensuring customer are well satisfied.
            You can confirm in the <a href="#testimonials">testimonials section</a>
        </p>
       </div>
       <div>
        <i class="fa fa-tags"></i>
        <!--<img src="comp_Photos/nat-hwcMLF374mY-unsplash.jpg" alt="" id="image2">-->
        <h4>Affordable Price</h4>
        <p>Our service are provided at an affordable price making them to be on high demand</p>
       </div>
       <div>
        : <i class="fa fa-th-large"></i>
        <!--<img src="comp_Photos/komarov-egor-sUiUI7FuT34-unsplash.jpg" alt="" id="image3">-->
        <h4>Wide Range Of Services</h4>
        <p>We provide wide range of tech service as you would find them in the service section.</p>
       </div>
    </section>
    </section>
           <!-- Testimonials Section -->
<section class="testimonials-section" id = "testimonials">
    <h6>Testimonials From Our clients</h6>
    <i class="fa fa-quote-left"></i>
    <div class="testimonial active">
       
        <p>"TechRica exceeded my expectations with their fast and reliable service. Highly recommended!"</p>
        <h4>- Sarah Nyaboke</h4>
    </div>
    <div class="testimonial">
        <p>"The support team was always available and solved my issues quickly. Great experience!"</p>
        <h4>- Michael Maina</h4>
    </div>
    <div class="testimonial">
        <p>"Affordable pricing and top-notch quality. I will definitely use TechRica again."</p>
        <h4>- Priya Wanjiku</h4>
    </div>
    <div class="testimonial">
        <p>"Their digital solutions helped my business grow. Professional and efficient!"</p>
        <h4>- David Oluoch</h4>
    </div>
    <div class="testimonial">
        <p>"Contact us for you also to enjoy  our great services </p>
        <h4>Techrica Team</h4>
    </div>
       <div class = "arrows">
         <span class="arrow left"><i class="fa fa-chevron-left"></i></span>
<span class="arrow right"><i class="fa fa-chevron-right"></i></span>
       </div>
    
</section>
   <section class="services-again">
     <section id="services">
<h2>Our Services Again</h2>
<ul>
<li>Custom Website Design & Development</li>
<li>Technical Support & IT Consultation</li>
<li>Domain & Hosting Setup Assistance</li>
</ul>
</section>
   </section>

    <!-- About TechRica Teaser -->
    <section class="about-teaser">
        <h2>About TechRica</h2>
        <p>TechRica is a student-led technology startup specializing in web development,
             software solutions, and tech consultation. We help businesses and individuals bring their digital ideas to life through modern, effective, and affordable solutions.</p>
        <a href="about-us.php" class="learn-more-btn">Learn more about us &rarr;</a>
    </section>

  
    

    
    

    <!-- Quick Contact CTA -->
    <section class="quick-contact-cta">
        <h2>Ready to start your project?</h2>
        <a href="contact-us.php" class="cta-btn">Request a Quote</a>
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
</footer>
  <script src="new.js" defer></script>
<script src = "index.js"></script>
</body>
</html>
<?php ob_end_flush();