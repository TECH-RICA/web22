
<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-sign-up.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><i class="fa fa-cogs"></i> Admin Dashboard</h1>
        <div class="row g-4">
            <div class="col-md-4">
                <a href="Admin-messages.php" class="btn btn-primary w-100 py-3">
                    <i class="fa fa-envelope"></i> Manage Messages
                </a>
            </div>
            <div class="col-md-4">
                <a href="admin-users.php" class="btn btn-success w-100 py-3">
                    <i class="fa fa-users"></i> Manage Users
                </a>
            </div>
            <div class="col-md-4">
                <a href="admin-content.php" class="btn btn-info w-100 py-3">
                    <i class="fa fa-edit"></i> Manage Content
                </a>
            </div>
            <div class="col-md-4">
                <a href="admin-gallery.php" class="btn btn-warning w-100 py-3">
                    <i class="fa fa-images"></i> Manage Gallery
                </a>
            </div>
            <div class="col-md-4">
                <a href="admin-settings.php" class="btn btn-dark w-100 py-3">
                    <i class="fa fa-sliders-h"></i> Site Settings
                </a>
            </div>
            <div class="col-md-4">
                <a href="index.php" class="btn btn-secondary w-100 py-3">
                    <i class="fa fa-home"></i> Back to Site
                </a>
            </div>
        </div>
        <div class="mt-5 text-end">
            <a href="logout.php" class="btn btn-outline-danger"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</body>
</html>