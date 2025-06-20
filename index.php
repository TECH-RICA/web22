<?php
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
// ...existing code...
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// ...existing code...
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
$conn = new mysqli("localhost", "root", "", "members"); // Use your DB name
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
    <link rel="stylesheet" href="dark-mode.css">
    <script>
document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function() {
        var msg = document.querySelector('.success, .error');
        if(msg) msg.style.display = 'none';
    }, 4000);
});
</script>
</head>
<body>
   
    <header>
     
        <h1>TechRica</h1>
      
        <nav class="navbar">
    <div class="menu-toggle">
        <span class="hamburger">&#9776;</span>
        <span class="close">&times;</span>
    </div>
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
           <h2> TechRica - Smart Tech Company
        </h2>
           </div>
        <p>Your go-to solution for premium digital services.
           Empowering You with Smart Digital Solutions.</p>
           <button><a href="#services">Explore Our Services</a></button>
    </section>
    <section id="services">
<h2>Our Services</h2>
<ul>
<li>Custom Website Design & Development</li>
<li>Technical Support & IT Consultation</li>
<li>Domain & Hosting Setup Assistance</li>
</ul>
</section>
<section id = "why">
     <h3 id = "why-h3" >Why Choose Us</h3>
    <section class="why">
       <div>
            <img src="comp_Photos/rafael-pol-6b5uqlWabB0-unsplash.jpg" alt="" id="image4" >
        <h4>Fast Delivery Of Services</h4>
        <p>We serve our customer need within a short period of time as necessary.</p>
       </div>
       <div>
        <img src="comp_Photos/nubelson-fernandes-SPaPUtVmp2w-unsplash.jpg" alt="" id="image1">
        <h4>High Quality Of Services</h4>
        <p id="paragraph_transform">We provide high quality services to all of our customer ensuring customer are well satisfied.
            You can confirm in the <a href="#testimonials">testimonials section</a>
        </p>
       </div>
       <div>
        <img src="comp_Photos/nat-hwcMLF374mY-unsplash.jpg" alt="" id="image2">
        <h4>Affordable Price</h4>
        <p>Our service are provided at an affordable price making them to be on high demand</p>
       </div>
       <div>
        <img src="comp_Photos/komarov-egor-sUiUI7FuT34-unsplash.jpg" alt="" id="image3">
        <h4>Wide Range Of Services</h4>
        <p>We provide wide range of tech service as you would find them in the service section.</p>
       </div>
    </section>
    </section>
           <!-- Testimonials Section -->
<section class="testimonials-section" id = "testimonials">
    <h6>Testimonials From Our clients</h6>
    <div class="testimonial active">
        <p>"TechRica exceeded my expectations with their fast and reliable service. Highly recommended!"</p>
        <h4>- Sarah Williams</h4>
    </div>
    <div class="testimonial">
        <p>"The support team was always available and solved my issues quickly. Great experience!"</p>
        <h4>- Michael Brown</h4>
    </div>
    <div class="testimonial">
        <p>"Affordable pricing and top-notch quality. I will definitely use TechRica again."</p>
        <h4>- Priya Patel</h4>
    </div>
    <div class="testimonial">
        <p>"Their digital solutions helped my business grow. Professional and efficient!"</p>
        <h4>- David Kim</h4>
    </div>
       <div class = "arrows">
         <span class="arrow left">&#8592;</span>
         <span class="arrow right">&#8594;</span>
       </div>
    
</section>
    <section class="start-receiving">
        <h5>Start Receiving TechRica Services</h5>
        <p>Contact Us and provide your service kind you would like us to work for you.</p>
        <button><a href="contact-us.php">Contact Us</a></button>
    </section>
    <footer>
        <p>&copy; 2025 TechRica.All Rights Reserved.</p>
    </footer>
  <script src="new.js" defer></script>
  <script>document.addEventListener('DOMContentLoaded', function() {
    // ... your menu/nav code ...

    // ADD THESE LINES AT THE TOP OF THE BLOCK:
    const testimonials = document.querySelectorAll('.testimonials-section .testimonial');
    const leftArrow = document.querySelector('.testimonials-section .arrow.left');
    const rightArrow = document.querySelector('.testimonials-section .arrow.right');
    let currentIndex = 0;

    function showTestimonial(index) {
        testimonials.forEach((testimonial, i) => {
            testimonial.classList.toggle('active', i === index);
        });
    }

    showTestimonial(currentIndex);

    if (leftArrow && rightArrow) {
        leftArrow.addEventListener('click', function() {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : testimonials.length - 1;
            showTestimonial(currentIndex);
        });

        rightArrow.addEventListener('click', function() {
            currentIndex = (currentIndex < testimonials.length - 1) ? currentIndex + 1 : 0;
            showTestimonial(currentIndex);
        });
    }

    // Swipe support for mobile
    const testimonialSection = document.querySelector('.testimonials-section');
    if (testimonialSection) {
        let startX = 0;
        let endX = 0;

        testimonialSection.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
        }, false);

        testimonialSection.addEventListener('touchend', function(e) {
            endX = e.changedTouches[0].clientX;
            if (endX < startX - 30) { // Swipe left
                currentIndex = (currentIndex < testimonials.length - 1) ? currentIndex + 1 : 0;
                showTestimonial(currentIndex);
            } else if (endX > startX + 30) { // Swipe right
                currentIndex = (currentIndex > 0) ? currentIndex - 1 : testimonials.length - 1;
                showTestimonial(currentIndex);
            }
        }, false);
    }

    // ... your other code ...
});</script>
<script src = "index.js"></script>
</body>
</html>