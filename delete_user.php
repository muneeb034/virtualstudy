<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

$id = intval($_GET['id']);


mysqli_query($conn, "DELETE FROM group_messages WHERE user_id = $id");


mysqli_query($conn, "DELETE FROM users WHERE id = $id");

header("Location: admin_users.php");
exit;
?>
