<?php
$conn = new mysqli("localhost", "root", "", "members");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT image_path, caption FROM about_images");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="about-us.css">
    <link rel="stylesheet" href="dark-mode.css">
</head>
<body>
     <header>
        <h1>TechRica</h1>
      
        <nav class="navbar">
            
            <div class="menu-toggle" id="menu-toggle">

               <span class="hamburger"> &#9776;</span>
               <span class="close">&times;</span>
            </div>
        
               <ul class="nav-links">
    <li><a class="nav-link" data-page="index.php">Home</a></li>
    <li><a class="nav-link" data-page="about-us.php">About us</a></li>
    <li><a class="nav-link" data-page="faqs.html">faqs</a></li>
    <li><a class="nav-link" data-page="contact-us.php">contacts</a></li>
    <li><a class="nav-link" data-page="login-sign-up.php">login</a></li>
    <li><button onclick="toggleDarkMode()" id="darkModeBtn">🌙 Dark Mode</button></li>
</ul>
            
        </nav>
    </header>
    <section class="about">
        <img src="images/IMG-20250413-WA0003.jpg" alt="">
         <h1>About TechRica</h1>
    </section>
    <section class="who-we-are">
        <div>
            <h2>Who we are and where are we located</h2>
       <p>Tech Richa is a student-led technology startup specializing in web development, software solutions, and tech consultation
services. We help businesses and individuals bring their digital ideas to life through modern, effective, and affordable solutions.
You can find us in Kutus,kirinyaga.
</p>

        </div>
        <div>
            <img src="comp_Photos/inbox-dicas-AdQJTXjBE_k-unsplash.jpg" alt="">
        </div>
    </section>


     <section>
        <h2>Meet Our Team & Office</h2>
        <div class="about-gallery">
             <?php while($row = $result->fetch_assoc()): ?>
                <div class="about-item">
                    <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="About image">
                    <?php if ($row['caption']): ?>
                        <div class="about-caption"><?php echo htmlspecialchars($row['caption']); ?></div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
           
        </div>
    </section>
                <!--
    <section>
        <?php
$conn = new mysqli("localhost", "root", "", "members");

// Get all members
$members = $conn->query("SELECT * FROM members");
while ($member = $members->fetch_assoc()) {
    echo '<div class="member-box">';
    echo '<h3>' . htmlspecialchars($member['name']) . '</h3>';
    echo '<p>' . htmlspecialchars($member['role']) . '</p>';

    // Get images for this member
    $member_id = $member['id'];
    $images = $conn->query("SELECT * FROM member_images WHERE member_id = $member_id");
    echo '<div class="member-gallery">';
    $first = true; $imgIndex = 0;
    while ($img = $images->fetch_assoc()) {
        echo '<div class="member-img-slide'.($first ? ' active' : '').'" data-member="'.$member_id.'" data-index="'.$imgIndex.'">';
        echo '<img src="'.htmlspecialchars($img['image_path']).'" alt="" class="member-thumb" style="cursor:pointer;" draggable="false">';
        if ($img['caption']) {
            echo '<div class="img-caption">'.htmlspecialchars($img['caption']).'</div>';
        }
        echo '</div>';
        $first = false; $imgIndex++;
    }
    // Arrows for this member's gallery
    echo '<span class="member-arrow left" data-member="'.$member_id.'">&#8592;</span>';
    echo '<span class="member-arrow right" data-member="'.$member_id.'">&#8594;</span>';
    echo '</div>'; // .member-gallery
    echo '</div>'; // .member-box
}
$conn->close();
?>

 Modal for full image 
<div id="imgModal" class="img-modal">
  <span class="img-modal-close">&times;</span>
  <img class="img-modal-content" id="imgModalFull" draggable="false">
</div>
    </section>
-->
    <section class="mission">
       <div>
         <h2>Our Mission</h2>
<p>To empower clients with cutting-edge digital
     tools that drive innovation, growth, and efficiency.</p>
       </div>
       <div>
        <img src="comp_Photos\adrian-raudaschl-ia7q0rlqRfA-unsplash.jpg" alt="">
       </div>
    </section>
    <section class="vision">
        <div>
            <h2>Our Vision</h2>
<p>To become a top-tier tech consultancy recognized for creativity,
     reliability, and client satisfaction.</p>
        </div>
        <div>
            <img src="comp_Photos/alex-nguyen-fz6YHzpmSCo-unsplash.jpg" alt="">
        </div>
    </section>
    <section class="core-values">
        <h2>Our Core Values</h2>
<ul>
<li>Innovation</li>
<li>Integrity</li>
<li>Teamwork</li>
<li>Customer-Focus</li>
<li>Continuous Learning</li>
</ul>
    </section>
   
    <section class="why">
        <h2>Why Choose Us</h2>
<ul>
<li>Affordable and transparent pricing</li>
<li>Passionate and talented team</li>
<li>Fast project turnaround</li>
<li>Flexible and scalable solutions</li>
</ul>
    </section>

        <?php
$conn = new mysqli("localhost", "root", "", "members");
$video = $conn->query("SELECT * FROM about_videos ORDER BY id DESC LIMIT 1")->fetch_assoc();
if ($video):
?>
<section class="about-video-section">
    <h2><?php echo htmlspecialchars($video['title']); ?></h2>
    <video 
        width="480" 
        controls 
        controlsList="nodownload" 
        style="border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,0.1);"
        poster="images/video-poster.jpg" <!-- optional poster image -->
    >
        <source src="<?php echo htmlspecialchars($video['video_path']); ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</section>
<?php endif; ?>
<?php $conn->close(); ?>

    <section class="ready">
        <div class="cta">
<p>Ready to take your business online?
     <a href="contact-us.php">Contact us</a> today and 
     let’s build something great together!
</p>
</div>
    </section>
    <footer>
        <p>&copy; 2025 TechRica.All Rights Reserved.</p>
    </footer>
    <script src="new.js"></script>
    <script src = "about-us.js"></script>
    <script src = "index.js"></script>
</body>
</html>
<!--<?php $conn->close(); ?>-->