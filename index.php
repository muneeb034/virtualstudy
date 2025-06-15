<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Virtual Study Buddy</title>
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

  
<div class="navbar">
  <div class="container">
    <h1 class="name">Virtual Study Buddy</h1>
    <nav>
      <ul>
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="planner.php">Study Planner</a></li>
        <li><a href="scholarships.php">Scholarships</a></li>
        <li><a href="groups.php">Study Groups</a></li>
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



  <section class="intro">
    <div class="container">
      <h2>Welcome to Virtual Study Buddy</h2>
      <p>Your all-in-one platform to plan, study, and succeed together.</p>
      <?php if ($is_logged_in): ?>
  <a href="dashboard.php" class="btn">Go to Dashboard</a>
<?php else: ?>
  <a href="register.php" class="btn">Get Started</a>
<?php endif; ?>

    </div>
  </section>

 
  <section class="main">
    <div class="container">
      <div class="feature">
        <i class="fas fa-calendar-alt"></i>
        <h3>Study Planner</h3>
        <p>Create, schedule, and track your study sessions effectively.</p>
      </div>
      <div class="feature">
        <i class="fas fa-graduation-cap"></i>
        <h3>Scholarships</h3>
        <p>Find real-time scholarship opportunities from different platforms.</p>
      </div>
      <div class="feature">
        <i class="fas fa-users"></i>
        <h3>Study Groups</h3>
        <p>Join or create virtual groups and prepare together.</p>
      </div>
      <div class="feature">
        <i class="fas fa-book"></i>
        <h3>Resources</h3>
        <p>Share and access helpful notes, past papers, and guides.</p>
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
