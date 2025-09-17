<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-sign-up.php");
    exit;
}
$conn = new mysqli("localhost", "root", "27580072@willy", "members");

// Handle image upload
if (isset($_POST['upload']) && isset($_FILES['gallery_image'])) {
    $caption = trim($_POST['caption'] ?? '');
    $target_dir = "uploads/gallery/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    $target_file = $target_dir . basename($_FILES["gallery_image"]["name"]);
    if (move_uploaded_file($_FILES["gallery_image"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO gallery (image_path, caption) VALUES (?, ?)");
        $stmt->bind_param("ss", $target_file, $caption);
        $stmt->execute();
        $stmt->close();
        echo "<div class='alert alert-success'>Image uploaded!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to upload image.</div>";
    }
}

// Handle image delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("SELECT image_path FROM gallery WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($img_path);
    if ($stmt->fetch()) {
        unlink($img_path);
    }
    $stmt->close();
    $conn->query("DELETE FROM gallery WHERE id=$id");
    echo "<div class='alert alert-success'>Image deleted!</div>";
}

// Handle image replace
if (isset($_POST['replace']) && isset($_FILES['replace_image']) && isset($_POST['replace_id'])) {
    $id = intval($_POST['replace_id']);
    $target_dir = "uploads/gallery/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    $target_file = $target_dir . basename($_FILES["replace_image"]["name"]);
    if (move_uploaded_file($_FILES["replace_image"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("SELECT image_path FROM gallery WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($old_path);
        if ($stmt->fetch()) {
            unlink($old_path);
        }
        $stmt->close();
        $stmt = $conn->prepare("UPDATE gallery SET image_path=? WHERE id=?");
        $stmt->bind_param("si", $target_file, $id);
        $stmt->execute();
        $stmt->close();
        echo "<div class='alert alert-success'>Image replaced!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to replace image.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Gallery</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1><i class="fa fa-images"></i> Manage Gallery</h1>
        <form action="admin-gallery.php" method="POST" enctype="multipart/form-data" class="mb-4">
            <label for="gallery-image">Upload Image:</label>
            <input type="file" name="gallery_image" id="gallery-image" accept="image/*" required>
            <input type="text" name="caption" placeholder="Caption (optional)">
            <button type="submit" name="upload" class="btn btn-success">Upload</button>
        </form>
        <div class="row">
            <?php
            $result = $conn->query("SELECT id, image_path, caption FROM gallery ORDER BY id DESC");
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-3 mb-4">';
                echo '<div class="card">';
                echo '<img src="' . htmlspecialchars($row['image_path']) . '" class="card-img-top" style="max-height:150px;object-fit:cover;">';
                echo '<div class="card-body">';
                echo '<p class="card-text">' . htmlspecialchars($row['caption']) . '</p>';
                echo '<a href="admin-gallery.php?delete=' . $row['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Delete this image?\')">Delete</a>';
                echo '<form action="admin-gallery.php" method="POST" enctype="multipart/form-data" class="mt-2">';
                echo '<input type="hidden" name="replace_id" value="' . $row['id'] . '">';
                echo '<input type="file" name="replace_image" accept="image/*" required>';
                echo '<button type="submit" name="replace" class="btn btn-warning btn-sm">Replace</button>';
                echo '</form>';
                echo '</div></div></div>';
            }
            ?>
        </div>
        <a href="admin-dashboard.php" class="btn btn-secondary mt-3"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
    </div>
</body>
</html>
<?php $conn->close(); ?>