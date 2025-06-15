<?php
session_start();
include("db.php");
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<html>
  <head>
    <title></title>
    <link rel="stylesheet" href="css/admin_users.css">

  </head>
<body>
      

<h2>All Registered Users</h2>
<table border="1">
<tr><th>ID</th><th>Username</th><th>Email</th><th>Actions</th></tr>
<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= $row['username'] ?></td>
  <td><?= $row['email'] ?></td>
  <td>
    <a href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete user?')">Delete</a>
  </td>
</tr>
<?php } ?>
</table>
<a href="admin_dashboard.php">Back</a>


</body>
</html>