
<?php
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    // 900 seconds = 15 minutes
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../phpfiles/login.php");
    exit;
}
$email = $_SESSION['email'] ?? '';
$username = $_SESSION['username'] ?? '';
$conn = new mysqli("localhost", "root", "27580072@willy", "members");
$user_id = $_SESSION['user_id'];
$message = "";

// Handle Profile Image Upload
if (isset($_POST['upload_image']) && isset($_FILES['profile_image'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('<div class="error">Invalid CSRF token.</div>');
    }
    $img = $_FILES['profile_image'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
    if ($img['error'] === 0 && in_array($ext, $allowed) && $img['size'] < 2*1024*1024) {
        if (!is_dir('uploads')) mkdir('uploads');
        $new_name = 'uploads/user_' . $user_id . '_' . time() . '.' . $ext;
        if (move_uploaded_file($img['tmp_name'], $new_name)) {
            chmod($new_name, 0644);
            $stmt = $conn->prepare("UPDATE users SET profile_image=? WHERE id=?");
            $stmt->bind_param("si", $new_name, $user_id);
            $stmt->execute();
            $stmt->close();
            $message = "<div class='success'>Profile image updated!</div>";
            $profile_image = $new_name;
        } else {
            $message = "<div class='error'>Failed to upload image.</div>";
        }
    } else {
        $message = "<div class='error'>Invalid image file. Only JPG, PNG, GIF under 2MB allowed.</div>";
    }
}

// Handle Create/Change Username
if (isset($_POST['set_username'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('<div class="error">Invalid CSRF token.</div>');
    }
    $new_username = trim($_POST['username']);
    if (strlen($new_username) < 3) {
        $message = "<div class='error'>Username must be at least 3 characters.</div>";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username=? AND id!=?");
        $stmt->bind_param("si", $new_username, $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $message = "<div class='error'>Username already taken.</div>";
        } else {
            $stmt = $conn->prepare("UPDATE users SET username=? WHERE id=?");
            $stmt->bind_param("si", $new_username, $user_id);
            $stmt->execute();
            $message = "<div class='success'>Username updated!</div>";
            $_SESSION['username'] = $new_username;
        }
        $stmt->close();
    }
}

// Handle Change Email
if (isset($_POST['change_email'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('<div class="error">Invalid CSRF token.</div>');
    }
    $new_email = trim($_POST['email']);
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='error'>Invalid email format.</div>";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email=? AND id!=?");
        $stmt->bind_param("si", $new_email, $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $message = "<div class='error'>Email already in use.</div>";
        } else {
            $stmt = $conn->prepare("UPDATE users SET email=? WHERE id=?");
            $stmt->bind_param("si", $new_email, $user_id);
            $stmt->execute();
            $message = "<div class='success'>Email updated!</div>";
        }
        $stmt->close();
    }
}

// Handle Change Password
if (isset($_POST['change_password'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('<div class="error">Invalid CSRF token.</div>');
    }
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];
    $stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hash);
    $stmt->fetch();
    $stmt->close();
    if (!password_verify($current, $hash)) {
        $message = "<div class='error'>Current password is incorrect.</div>";
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/', $new)) {
        $message = "<div class='error'>New password must be at least 8 characters and include letters, numbers, and symbols.</div>";
    } elseif ($new !== $confirm) {
        $message = "<div class='error'>New passwords do not match.</div>";
    } else {
        $new_hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $new_hash, $user_id);
        $stmt->execute();
        $stmt->close();
        $message = "<div class='success'>Password changed!</div>";
    }
}

// Fetch user info (now includes profile_image)
$stmt = $conn->prepare("SELECT username, email, profile_image FROM users WHERE id=?");
if (!$stmt) {
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    exit;
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result( $username, $email,  $profile_image);
$stmt->fetch();
$stmt->close();
$conn->close();

// Set default image if none
if (empty($profile_image) || !file_exists($profile_image)) {
    $profile_image = 'uploads/rename.jpg';
}

// Profile completion progress
$fields = [ $username,$email, ($profile_image !== 'uploads/default.png')];
$filled = count(array_filter($fields));
$progress = intval(($filled / count($fields)) * 100);

// Handle account deletion
if (isset($_POST['delete_account']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    $conn = new mysqli("localhost", "root", "27580072@willy", "members");
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile - TechRica</title>
    <link rel="stylesheet" href="profile.css">
     <link rel="stylesheet" href="fontawesome/css/all.min.css">
     <link rel="stylesheet" href="footer.css">
    <link rel="icon" type="image/png" href="favicon.png">
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <div class="profile-container">
        <!-- Profile Completion Progress Bar -->
        <div style="margin-bottom:15px;">
            <label>Profile Completion: <?php echo $progress; ?>%</label>
            <progress value="<?php echo $progress; ?>" max="100" style="width:100%;"></progress>
        </div>
        <div class="profile-header">
            <form method="POST" enctype="multipart/form-data" class="upload-form" id="imgForm">
                <label for="profileInput" style="cursor:pointer;">
                    <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image" class="profile-img" id="profileImg">
                </label>
                <input type="file" name="profile_image" id="profileInput" accept="image/*" style="display:none;" onchange="document.getElementById('imgForm').submit();">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="upload_image" value="1">
            </form>
            <h2>Welcome, <?php echo htmlspecialchars($username); ?></h2>
        </div>
        <?php if ($message) echo $message; ?>
        <div class="profile-info">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username ?: "Not set"); ?></p>
        </div>
        <!-- Username Form -->
        <form method="POST" class="profile-actions">
            <label for="username">Set/Change Username:</label>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
            <input type="submit" name="set_username" value="Save Username">
        </form>
        <!-- Change Email Form -->
        <form method="POST" class="profile-actions">
            <label for="email">Change Email:</label>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <input type="submit" name="change_email" value="Change Email">
        </form>
        <!-- Change Password Form -->
        <form method="POST" class="profile-actions">
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" id="current_password" required>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" required>
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <progress id="strengthBar" value="0" max="4" style="width:100%;"></progress>
            <input type="checkbox" id="showPass" onclick="togglePassword()"> Show Password
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="submit" name="change_password" value="Change Password">
        </form>
        <!-- Delete Account Form -->
        <form method="POST" class="profile-actions" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="submit" name="delete_account" value="Delete Account" style="background:#b00020;">
        </form>
        <!-- Logout Form -->
        <form action="phpfiles/logout.php" method="POST" class="profile-actions">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="submit" value="Logout" onclick="return confirm('Are you sure you want to logout?');">
        </form>
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
<script src = "profile.js"></script>
</body>
</html>