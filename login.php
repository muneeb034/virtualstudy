<?php
session_start();
include("db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email_or_username = mysqli_real_escape_string($conn, $_POST['email']);
  $password = $_POST['password'];

  
  $query = "SELECT * FROM users WHERE email='$email_or_username' OR username='$email_or_username'";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user['password'])) {
    
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['name'] = $user['name'];

      header("Location: index.php");
      exit;
    } else {
      $message = "invalid password.";
    }
  } else {
    $message = " No user found with that email or username.";
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Virtual Study Buddy</title>
  <link rel="stylesheet" href="css/login.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 

</head>
<body>

 
  <div class="navbar">
    <div class="container">
      <h1 class="logo">Virtual Study Buddy</h1>
      <nav>
      <ul>
          <li><a href="index.php" >Home</a></li>
          <li><a href="./planner.php">Study Planner</a></li>
          <li><a href="scholarships.php">Scholarships</a></li>
          <li><a href="groups.php">Study Groups</a></li>
          <li><a href="resources.php">Resources</a></li>
          <li><a href="login.php" class="active" >Login</a></li>
          <li><a href="register.php">Sign Up</a></li>
        </ul>
      </nav>
    </div>
  </div>

 
  <section class="heading">
    <div class="container">
      <h2>Welcome Back</h2>
      <p>Login to access your dashboard and study tools</p>
    </div>
  </section>

  
  <div class="main" style="padding: 40px 0;">
    <div class="container" style="max-width: 500px;">
    <?php if ($message): ?>
  <div class="form-card" style="color: red; margin-bottom: 15px;">
    <?php echo $message; ?>
  </div>
<?php endif; ?>
      <form action="#" method="post" class="form" onsubmit="return validateLogin() >ju
        <label for="email">Email or Username</label>
        <input type="text" id="email" name="email" placeholder="Enter your email or username" required />

       <br> <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required />

        <button type="submit" class="btn" style="width: 100%; margin-top: 15px;">Login</button>

        <p style="text-align: center; margin-top: 10px;">Don't have an account? <a href="register.php">Register here</a>.</p>
      </form>
    </div>
  </div>

 
  <footer class="footer">
    <div class="container">
      <p>&copy; 2025 Virtual Study Buddy. All rights reserved.</p>
    </div>
  </footer>


<script src="js/login.js"></script>
   
</body>
</html>
