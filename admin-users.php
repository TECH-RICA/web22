
<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-sign-up.php");
    exit;
}
$conn = new mysqli("localhost", "root", "27580072@willy", "members");
$result = $conn->query("SELECT id, username, email, created_at FROM users ORDER BY created_at ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1><i class="fa fa-users"></i> Manage Users</h1>
        <table class="table table-bordered table-hover mt-4">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th><i class="fa fa-user"></i> Username</th>
                    <th><i class="fa fa-envelope"></i> Email</th>
                    <th><i class="fa fa-clock"></i> Joined</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin-dashboard.php" class="btn btn-secondary mt-3"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
    </div>
</body>
</html>
<?php $conn->close(); ?>