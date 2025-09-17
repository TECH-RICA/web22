<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-sign-up.php");
    exit;
}
$conn = new mysqli("localhost", "root", "27580072@willy", "members");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = trim($_POST['site_name']);
    $contact_email = trim($_POST['contact_email']);
    $stmt = $conn->prepare("UPDATE settings SET value=? WHERE name='site_name'");
    $stmt->bind_param("s", $site_name);
    $stmt->execute();
    $stmt = $conn->prepare("UPDATE settings SET value=? WHERE name='contact_email'");
    $stmt->bind_param("s", $contact_email);
    $stmt->execute();
    $message = "<div class='alert alert-success'>Settings updated!</div>";
}

// Fetch current settings
$site_name = '';
$contact_email = '';
$res = $conn->query("SELECT name, value FROM settings WHERE name IN ('site_name','contact_email')");
while ($row = $res->fetch_assoc()) {
    if ($row['name'] === 'site_name') $site_name = $row['value'];
    if ($row['name'] === 'contact_email') $contact_email = $row['value'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Site Settings</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1><i class="fa fa-sliders-h"></i> Site Settings</h1>
        <?php if (!empty($message)) echo $message; ?>
        <form method="post" class="mt-4">
            <div class="mb-3">
                <label class="form-label">Site Name</label>
                <input type="text" name="site_name" class="form-control" value="<?= htmlspecialchars($site_name) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contact Email</label>
                <input type="email" name="contact_email" class="form-control" value="<?= htmlspecialchars($contact_email) ?>" required>
            </div>
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Settings</button>
            <a href="admin-dashboard.php" class="btn btn-secondary ms-2"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>