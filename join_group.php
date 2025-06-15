<?php
session_start();
require 'db.php';

$group_id = $_POST['group_id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT IGNORE INTO group_members (group_id, user_id) VALUES (?, ?)");
$stmt->bind_param("ii", $group_id, $user_id);
$stmt->execute();

header("Location: chat.php?group_id=$group_id");
exit;
?>
