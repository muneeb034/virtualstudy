<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id']) || !isset($_GET['group_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$group_id = intval($_GET['group_id']);


$check = mysqli_query($conn, "SELECT * FROM group_members WHERE group_id = '$group_id' AND user_id = '$user_id'");
if (mysqli_num_rows($check) == 0) {
    die("You are not a member of this group.");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $file_path = null;

   
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir);
        $filename = basename($_FILES['file']['name']);
        $target_file = $target_dir . time() . "_" . $filename;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            $file_path = $target_file;
        }
    }

    $query = "INSERT INTO group_messages (group_id, user_id, message, file_path) VALUES ('$group_id', '$user_id', '$message', '$file_path')";
    mysqli_query($conn, $query);
    header("Location: chat.php?group_id=$group_id");
    exit;
}


$messages = mysqli_query($conn, "
    SELECT gm.*, u.username 
    FROM group_messages gm 
    JOIN users u ON gm.user_id = u.id 
    WHERE gm.group_id = '$group_id' 
    ORDER BY gm.timestamp ASC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Group Chat</title>
    <link rel="stylesheet" href="css/chat.css">
</head>
<body>
    
    <div class="container">
        <h2>Group Chat</h2>
        <div class="chat-box">
            <?php while ($row = mysqli_fetch_assoc($messages)): ?>
                <div class="message">
                    <strong><?= htmlspecialchars($row['username']) ?>:</strong> 
                    <?= nl2br(htmlspecialchars($row['message'])) ?>
                    <?php if ($row['file_path']): ?>
                        <div><a href="<?= $row['file_path'] ?>" target="_blank">📎 Download File</a></div>
                    <?php endif; ?>
                    <small><?= $row['timestamp'] ?></small>
                </div>
            <?php endwhile; ?>
        </div>

        <form method="POST" enctype="multipart/form-data" class="chat-form">
            <textarea name="message" placeholder="Enter your message..." ></textarea>
            <input type="file" name="file">
            <button type="submit">Send</button>
        </form>
        <a href="groups.php" class="btn">Back to Groups</a>
    </div>
</body>
</html>
