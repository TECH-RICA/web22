<?php
$conn = new mysqli("localhost", "root", "", "members");
$result = $conn->query("SELECT * FROM messages ORDER BY sent_at DESC");
while ($row = $result->fetch_assoc()) {
    echo "<div>";
    echo "<strong>From:</strong> " . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['email']) . ")<br>";
    echo "<strong>Subject:</strong> " . htmlspecialchars($row['subject']) . "<br>";
    echo "<strong>Message:</strong> " . nl2br(htmlspecialchars($row['message'])) . "<br>";
    echo "<em>Sent at: " . $row['sent_at'] . "</em>";
    echo "<hr></div>";
}
$conn->close();
?>