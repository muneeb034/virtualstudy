<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - Virtual Study Buddy</title>
  <link rel="stylesheet" href="css/dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>


  <div class="navbar">
    <div class="container">
      <h1 class="name">Virtual Study Buddy</h1>
      <nav>
        <ul>
          <li><a href="dashboard.php" class="active">Dashboard</a></li>
          <li><a href="planner.php">Study Planner</a></li>
          <li><a href="scholarships.php">Scholarships</a></li>
          <li><a href="groups.php">Study Groups</a></li>
          <li><a href="resources.php">Resources</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </div>
  </div>


  <section class="intro">
    <div class="container">
      <h2>Welcome, <?php echo $_SESSION['name']; ?></h2>
      <p>Glad to see you back! Use the tools below to manage your study journey.</p>
    </div>
  </section>

  <section class="main">
    <div class="container">

      <div class="card">
        <i class="fas fa-calendar-alt"></i>
        <h3>Study Planner</h3>
        <p>Track tasks and organize your schedule.</p>
        <a href="planner.php" class="btn">Open</a>
      </div>

      <div class="card">
        <i class="fas fa-graduation-cap"></i>
        <h3>Scholarships</h3>
        <p>Explore funding options for your education.</p>
        <a href="scholarships.php" class="btn">Explore</a>
      </div>

      <div class="card">
        <i class="fas fa-users"></i>
        <h3>Study Groups</h3>
        <p>Collaborate and learn together with others.</p>
        <a href="groups.php" class="btn">Join</a>
      </div>

      <div class="card">
        <i class="fas fa-book"></i>
        <h3>Resources</h3>
        <p>Notes, past papers, and guides — all in one place.</p>
        <a href="resources.php" class="btn">Browse</a>
      </div>

    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <p>&copy; 2025 Virtual Study Buddy. All rights reserved.</p>
    </div>
  </footer>

</body>
</html>
