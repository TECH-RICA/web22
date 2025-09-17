
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
    <title>Manage Content</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1><i class="fa fa-edit"></i> Manage Content</h1>
        <div class="alert alert-info mt-4">
            This is a placeholder for content management. Here you can add tools to edit About Us, FAQs, homepage, etc.
        </div>
        <a href="admin-dashboard.php" class="btn btn-secondary mt-3"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
    </div>
</body>
</html>