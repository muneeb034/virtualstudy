<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task'], $_POST['deadline'])) {
  $task = mysqli_real_escape_string($conn, $_POST['task']);
  $deadline = $_POST['deadline'];
  $user_id = $_SESSION['user_id'];

  $sql = "INSERT INTO tasks (user_id, task, deadline) VALUES ('$user_id', '$task', '$deadline')";
  mysqli_query($conn, $sql);
  header("Location: planner.php");
  exit;
}


if (isset($_GET['delete'])) {
  $task_id = $_GET['delete'];
  $user_id = $_SESSION['user_id'];
  mysqli_query($conn, "DELETE FROM tasks WHERE id = $task_id AND user_id = $user_id");
  header("Location: planner.php");
  exit;
}


$user_id = $_SESSION['user_id'];
$tasks = mysqli_query($conn, "SELECT * FROM tasks WHERE user_id = $user_id ORDER BY deadline ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Study Planner - Virtual Study Buddy</title>
  <link rel="stylesheet" href="css/planner.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 
</head>
<body>


  <div class="navbar">
    <div class="container">
      <h1 class="name">Virtual Study Buddy</h1>
      <nav>
        <ul>
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="planner.php" class="active">Study Planner</a></li>
          <li><a href="scholarships.php">Scholarships</a></li>
          <li><a href="groups.php">Study Groups</a></li>
          <li><a href="resources.php">Resources</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </div>
  </div>

  <section class="hero">
    <div class="container">
      <h2>Study Planner</h2>
      <p>Organize your study tasks and stay on track</p>
    </div>
  </section>


  <section class="features" style="padding: 40px 0;">
    <div class="container" style="max-width: 700px;">
      <div class="form-card">
        <form method="post">
          <label for="task">Study Task</label>
          <input type="text" id="task" name="task" placeholder="e.g. Revise Chapter 3 - Networking" required />

          <label for="deadline">Deadline</label>
          <input type="date" id="deadline" name="deadline" required />

          <button type="submit" class="btn" style="width: 100%; margin-top: 15px;">Add to Planner</button>
        </form>
      </div>

   
      <div class="task-list" style="margin-top: 30px;">
        <h3 style="color:#1a237e; margin-bottom: 10px;">Your Tasks</h3>
        <ul class="form-card" style="list-style: none; padding: 20px;">
          <?php while ($row = mysqli_fetch_assoc($tasks)): ?>
            <li style="margin-bottom: 15px;">
              <strong><?php echo htmlspecialchars($row['task']); ?></strong><br/>
              <small>Due: <?php echo $row['deadline']; ?></small><br/>
              <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)" style="color: red; font-size: 13px;">Delete</a>
            </li>
          <?php endwhile; ?>
          <?php if (mysqli_num_rows($tasks) == 0): ?>
            <li>No tasks yet. Add some above </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </section>


  <footer class="footer">
    <div class="container">
      <p>&copy; 2025 Virtual Study Buddy. All rights reserved.</p>
    </div>
  </footer>

<script src="js/planner.js"></script>

</body>
</html>
