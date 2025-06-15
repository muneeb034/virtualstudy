<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

function isUserInGroup($group_id, $user_id) {
    global $conn;
    $query = "SELECT * FROM group_members WHERE group_id = '$group_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_group'])) {
    $group_name = mysqli_real_escape_string($conn, $_POST['group_name']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $query = "INSERT INTO discussion_groups (group_name, subject, created_by) VALUES ('$group_name', '$subject', '$user_id')";
    mysqli_query($conn, $query);
    $group_id = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO group_members (group_id, user_id) VALUES ('$group_id', '$user_id')");
    header("Location: groups.php");
    exit();
}


if (isset($_GET['join'])) {
    $group_id = intval($_GET['join']);
    if (!isUserInGroup($group_id, $user_id)) {
        mysqli_query($conn, "INSERT INTO group_members (group_id, user_id) VALUES ('$group_id', '$user_id')");
    }
    header("Location: chat.php?group_id=$group_id");
    exit();
}

$groups = mysqli_query($conn, "SELECT discussion_groups.*, users.username FROM discussion_groups JOIN users ON discussion_groups.created_by = users.id");
$user_groups = mysqli_query($conn, "SELECT discussion_groups.* FROM discussion_groups JOIN group_members ON discussion_groups.id = group_members.group_id WHERE group_members.user_id = '$user_id'");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Study Groups</title>
  <link rel="stylesheet" href="css/group.css">
</head>
<body>
  <div class="navbar">
  <div class="container">
    <h1 class="name">Virtual Study Buddy</h1>
    <nav>
      <ul>
        <li><a href="index.php" >Home</a></li>
        <li><a href="planner.php">Study Planner</a></li>
        <li><a href="scholarships.php">Scholarships</a></li>
        <li><a href="groups.php" class="active" >Study Groups</a></li>
        <li><a href="resources.php">Resources</a></li>
        <?php if ($is_logged_in): ?>
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Sign Up</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</div>
  <div class="container">
    <h2>Your Groups</h2>
    <div class="group-list">
      <?php while ($row = mysqli_fetch_assoc($user_groups)) : ?>
        <div class="form-card group-item">
          <h4><?= htmlspecialchars($row['group_name']) ?></h4>
          <p><?= htmlspecialchars($row['subject']) ?></p>
          <a href="chat.php?group_id=<?= $row['id'] ?>" class="btn">Go to Chat</a>
        </div>
      <?php endwhile; ?>
    </div>

    <h2>All Groups</h2>
    <div class="group-list">
      <?php while ($row = mysqli_fetch_assoc($groups)) : ?>
        <div class="form-card group-item">
          <h4><?= htmlspecialchars($row['group_name']) ?></h4>
          <p><?= htmlspecialchars($row['subject']) ?></p>
          <small>Created by: <?= htmlspecialchars($row['username']) ?></small>
          <?php if (!isUserInGroup($row['id'], $user_id)) : ?>
            <a href="groups.php?join=<?= $row['id'] ?>" class="btn">Join Group</a>
          <?php else : ?>
            <a href="chat.php?group_id=<?= $row['id'] ?>" class="btn">Go to Chat</a>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>

    <h2>Create New Group</h2>
    <form method="POST" class="form-card">
      <input type="text" name="group_name" placeholder="Group Name" required>
      <input type="text" name="subject" placeholder="Subject" required>
      <button type="submit" name="create_group" class="btn">Create Group</button>
    </form>
  </div>
</body>
</html>
