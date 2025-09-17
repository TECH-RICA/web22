<?php
session_start();
// Only allow admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-sign-up.php");
    exit;
}
$conn = new mysqli("localhost", "root", "27580072@willy", "members");
$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
if (!$result) {
    die("Database query failed: " . $conn->error);
}
if (isset($_POST['delete']) && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $conn->query("DELETE FROM messages WHERE id=$delete_id");
    header("Location: Admin-messages.php");
    exit;
}
if (isset($_POST['send_reply']) && isset($_POST['reply_email']) && isset($_POST['reply_message'])) {
   require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // or your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@gmail.com';
    $mail->Password = 'your_app_password';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('your_email@gmail.com', 'TechRica Admin');
    $mail->addAddress($_POST['reply_email']);
    $mail->Subject = "Reply from TechRica";
    $mail->Body = $_POST['reply_message'];

    if ($mail->send()) {
        echo "<div class='alert alert-success'>Reply sent to {$_POST['reply_email']}!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to send reply. Error: {$mail->ErrorInfo}</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Messages</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4"><i class="fa fa-envelope"></i> User Messages</h1>
        <a href="admin-dashboard.php" class="btn btn-secondary mb-3"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th><i class="fa fa-user"></i> Name</th>
                            <th><i class="fa fa-envelope"></i> Email</th>
                            <th><i class="fa fa-comment-dots"></i> Message</th>
                            <th><i class="fa fa-clock"></i> created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Delete this message?')">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                                <!-- Inline reply button -->
                                <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('reply-form-<?= $row['id'] ?>').style.display='block'">
                                    <i class="fa fa-reply"></i> Reply
                                </button>
                                <form method="POST" style="display:none; margin-top:8px;" id="reply-form-<?= $row['id'] ?>">
                                    <input type="hidden" name="reply_email" value="<?= htmlspecialchars($row['email']) ?>">
                                    <textarea name="reply_message" class="form-control mb-2" placeholder="Type your reply..." required></textarea>
                                    <button type="submit" name="send_reply" class="btn btn-success btn-sm">Send</button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('reply-form-<?= $row['id'] ?>').style.display='none'">Cancel</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No messages found.</div>
        <?php endif; ?>
    </div>
    <script>
    document.getElementById('select-all').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
        for (var cb of checkboxes) cb.checked = this.checked;
    });
    </script>
</body>
</html>
<?php $conn->close(); ?>