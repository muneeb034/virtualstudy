<?php
include("db.php");
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = $_POST['password'];
  $confirm = $_POST['confirm'];

  if ($password !== $confirm) {
    $message = "Passwords do not match.";
  } else {
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $check = "SELECT * FROM users WHERE email='$email' OR username='$username'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
      $message = "Email or username already exists.";
    } else {
      $insert = "INSERT INTO users (name, email, username, password) 
                 VALUES ('$name', '$email', '$username', '$hashed')";
      if (mysqli_query($conn, $insert)) {
        $message = "Registration successful! <a href='login.php'>Login here</a>";
      } else {
        $message = " Registration failed. Try again.";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - Virtual Study Buddy</title>
  <link rel="stylesheet" href="css/register.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>
  <header class="navbar">
    <div class="container">
      <h1 class="logo">Virtual Study Buddy</h1>
      <nav>
        <ul>
          <li><a href="index.php" >Home</a></li>
          <li><a href="./planner.php">Study Planner</a></li>
          <li><a href="scholarships.php">Scholarships</a></li>
          <li><a href="groups.php">Study Groups</a></li>
          <li><a href="resources.php">Resources</a></li>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php" class="active" >Sign Up</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="heading">
    <div class="container">
      <h2>Create Your Account</h2>
      <p>Join Virtual Study Buddy to start planning and connecting!</p>
    </div>
  </div>

  <section class="main" style="padding: 40px 0;">
    <div class="container" style="max-width: 500px;">
      <?php if ($message): ?>
        <div class="form-card" style="color: red; margin-bottom: 15px;">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>

      <form action="#" method="post" class="form">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your full name" required />
        <p id="nameError" style="color:red;"></p>

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required />
        <p id="emailError" style="color:red;"></p>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Choose a username" required />
        <p id="usernameError" style="color:red;"></p>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter a password" required />
        <p id="passwordError" style="color:red;"></p>

        <label for="confirm">Confirm Password</label>
        <input type="password" id="confirm" name="confirm" placeholder="Confirm your password" required />
        <p id="confirmError" style="color:red;"></p>

        <button type="submit" class="btn" style="width: 100%; margin-top: 15px;">Register</button>
        <p style="text-align: center; margin-top: 10px;">Already have an account? <a href="login.php">Login here</a>.</p>
      </form>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <p>&copy; 2025 Virtual Study Buddy. All rights reserved.</p>
    </div>
  </footer>
<script src="js/register.js"></script>


</body>
</html>
