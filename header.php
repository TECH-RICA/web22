<?php
define('BASE_URL', 'http://localhost/web22/');
?>
<!-- Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<header>
    <h1>TechRica</h1>
    <nav class="navbar">
        <div class="menu-toggle" id="menu-toggle">
            <span class="hamburger">&#9776;</span>
            <span class="close">&times;</span>
        </div>
        <ul class="nav-links">
            <li><a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a></li>           
            <li><a class="nav-link" href="about-us.php"><i class="fa fa-users"></i> About Us</a></li>           
            <li><a class="nav-link" href = "faqs.html"><i class="fa fa-question-circle"></i> FAQs</a></li>
            <li><a class="nav-link" href="contact-us.php"><i class="fa fa-envelope"></i> Contacts</a></li>
            <li><a class="nav-link" href="login-sign-up.php"><i class="fa fa-sign-in-alt"></i> Login</a></li>
            <li><a class="nav-link" href="profile.php"><i class="fa fa-user-circle"></i> Profile</a></li>
            <li>
                <button onclick="toggleDarkMode()" id="darkModeBtn" style="background:none;border:none;cursor:pointer;">
                    <i class="fa fa-moon"></i> Dark Mode
                </button>
            </li>
        </ul>
    </nav>
</header>