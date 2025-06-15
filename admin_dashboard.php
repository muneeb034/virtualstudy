<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/admin_dashboard.css">

</head>
<body>
<h1>Welcome to Admin Panel</h1>
<ul>
  <li><a href="admin_users.php">Manage Users</a></li>
  <li><a href="admin_groups.php">Manage Groups</a></li>
  <li><a href="admin_scholarship.php">Manage Scholarships</a></li>
  <li><a href="admin_logout.php">Logout</a></li>
</ul>
</body>
</html>
