<?php
$conn = new mysqli("localhost", "root", "27580072@willy", "members");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT image_path, hover_image_path, caption FROM about_images");
$video = $conn->query("SELECT video_path, title FROM about_videos LIMIT 1")->fetch_assoc();
$result2 = $conn->query("SELECT image_path, caption FROM gallery ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - TechRica</title>
    <link rel="stylesheet" href="about-us2.css">
    <link rel="stylesheet" href="dark-mode.css">
    <link rel="stylesheet" href="footer2.css">
     <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <script src="new.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="about-intro">
        <h1>Welcome to TechRica</h1>
        <p>
            We are a student-led technology startup based in Kutus, Kirinyaga, specializing in web development, software solutions, and tech consultation. Our mission is to empower clients with cutting-edge digital tools that drive innovation, growth, and efficiency.
        </p>
    </section>

    <section class="about">
        <img src="images/IMG-20250413-WA0003.jpg" alt="">
        <h1>About TechRica</h1>
    </section>

    <section class="who-we-are">
        <div>
            <h2><i class="fa fa-users"></i> Who we are and where are we located</h2>
            <p>
                TechRica is a student-led technology startup specializing in web development, software solutions, and tech consultation services. We help businesses and individuals bring their digital ideas to life through modern, effective, and affordable solutions. You can find us in Kutus, Kirinyaga.
            </p>
        </div>
        <div>
            <img src="comp_Photos/inbox-dicas-AdQJTXjBE_k-unsplash.jpg" alt="">
        </div>
    </section>

    <section>
        <h2 class="black"><i class="fa fa-user-friends"></i> Meet Our Team & Office</h2>
        <div class="about-gallery">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="about-item">
                    <img src="<?php echo htmlspecialchars($row['image_path']); ?>"
                         data-original="<?php echo htmlspecialchars($row['image_path']); ?>"
                         data-hover="<?php echo htmlspecialchars($row['hover_image_path']); ?>"
                         alt="About image"
                         class="about-gallery-img">
                    <?php if ($row['caption']): ?>
                        <div class="about-caption"><?php echo htmlspecialchars($row['caption']); ?></div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <section class="mission">
        <div>
            <h2 class="black"><i class="fa fa-bullseye"></i> Our Mission</h2>
            <p>To empower clients with creative digital tools that drive innovation, growth, and efficiency.</p>
        </div>
        <div>
            <img src="comp_Photos/adrian-raudaschl-ia7q0rlqRfA-unsplash.jpg" alt="">
        </div>
    </section>

    <section class="vision">
        <div>
            <h2 class="black"><i class="fa fa-eye"></i> Our Vision</h2>
            <p>To become a top-tier tech consultancy recognized for excellence in innovation, customer, and client satisfaction.</p>
        </div>
        <div>
            <img src="comp_Photos/alex-nguyen-fz6YHzpmSCo-unsplash.jpg" alt="">
        </div>
    </section>

    <section class="core-values">
        <h2 class="black"><i class="fa fa-gem"></i> Our Core Values</h2>
        <ul>
            <li><i class="fa fa-lightbulb"></i> Innovation</li>
            <li><i class="fa fa-balance-scale"></i> Integrity</li>
            <li><i class="fa fa-users"></i> Teamwork</li>
            <li><i class="fa fa-user-check"></i> Customer-Focus</li>
            <li><i class="fa fa-graduation-cap"></i> Continuous Learning</li>
        </ul>
    </section>

    <section id="why-choose-us">
        <section class="why-choose-us">
        <h2 class="black"><i class="fa fa-question-circle"></i> Why Choose Us</h2>
        <ul>
            <li><i class="fa fa-tags"></i> Affordable and transparent pricing</li>
            <li><i class="fa fa-heart"></i> Passionate and talented team</li>
            <li><i class="fa fa-bolt"></i> Fast project turnaround</li>
            <li><i class="fa fa-arrows-alt"></i> Flexible and scalable solutions</li>
        </ul>
    </section>
    </section>
    
   
<section class="about-gallery">
    <h2><i class="fa fa-images"></i> Our Gallery</h2>
    <?php
    $conn = new mysqli("localhost", "root", "27580072@willy", "members");
    $result = $conn->query("SELECT image_path, caption FROM gallery ORDER BY id DESC");
    while($row = $result->fetch_assoc()):
    ?>
        <div class="about-item">
            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Gallery image">
            <?php if ($row['caption']): ?>
                <div class="about-caption"><?php echo htmlspecialchars($row['caption']); ?></div>
            <?php endif; ?>
        </div>
    <?php endwhile; $conn->close(); ?>
</section>

    <?php
    $video_path = isset($video['video_path']) ? $video['video_path'] : '';
    $video_title = isset($video['title']) ? $video['title'] : 'Our Video';
    $video_file = __DIR__ . '/' . $video_path;
    $video_exists = $video_path && file_exists($video_file);
    ?>
    <section class="about-video-section">
        <h2><i class="fa fa-video"></i> <?php echo htmlspecialchars($video_title); ?></h2>
        <?php if ($video_exists): ?>
            <div class="video-thumbnail-container">
                <img src="images/video-thumb.jpg" alt="Video thumbnail" class="video-thumbnail" style="border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,0.1);width:320px;">
                <button id="openVideoModal" class="watch-video-btn">▶ Watch Video</button>
            </div>
            <!-- Modal -->
            <div id="videoModal" class="video-modal" style="display:none;">
                <div class="video-modal-content">
                    <span id="closeVideoModal" class="video-modal-close">&times;</span>
                    <video id="aboutVideo" width="480" controls>
                        <source src="<?php echo htmlspecialchars($video_path); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning mt-3">
                <i class="fa fa-exclamation-triangle"></i> Video not available.
            </div>
        <?php endif; ?>
    </section>

    <section class="ready">
        <div class="cta">
            <p>
                Ready to take your business online?
                <a href="contact-us.php">Contact us</a> today and let’s build something great together!
                <i class="fa fa-rocket"></i>
            </p>
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
</footer>
    <script src = "about-us.js"></script>
    <script src="new2.js" defer></script>
    <script src="index.js"></script>
</body>
</html>
<?php