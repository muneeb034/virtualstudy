<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

include("db.php");
$message = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
  $user_id = $_SESSION['user_id'];
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $file = $_FILES['file'];

  $allowed = ['pdf', 'doc', 'docx', 'txt'];
  $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

  if (in_array($ext, $allowed)) {
    $filename = time() . '_' . basename($file['name']);
    $target_path = "uploads/" . $filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
      $sql = "INSERT INTO resources (user_id, title, filename) VALUES ('$user_id', '$title', '$filename')";
      if (mysqli_query($conn, $sql)) {
        $message = "Resource uploaded successfully!";
      } else {
        $message = " Database error!";
      }
    } else {
      $message = "Failed to move uploaded file.";
    }
  } else {
    $message = "Invalid file type. Only PDF, DOC, DOCX, and TXT are allowed.";
  }
}

$result = mysqli_query($conn, "SELECT resources.*, users.name FROM resources JOIN users ON users.id = resources.user_id ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Resources - Virtual Study Buddy</title>
  <link rel="stylesheet" href="css/resources.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <li><a href="groups.php">Study Groups</a></li>
        <li><a href="resources.php" class="active">Resources</a></li>
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


  <section class="hero">
    <div class="container">
      <h2>Study Resources</h2>
      <p>Browse and upload helpful notes, guides, and materials</p>
    </div>
  </section>

  
  <section class="features" style="padding: 40px 0;">
    <div class="container" style="max-width: 800px;">
      <?php if ($message): ?>
        <div class="form-card" style="color: green; margin-bottom: 15px;">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>

      <div class="form-card" style="margin-bottom: 30px;">
        <h3 style="color: #1a237e;">Upload Your Resource</h3>
        <form method="post" enctype="multipart/form-data">
          <label for="title">Title</label>
          <input type="text" name="title" id="title" required>

          <label for="file">Select File</label>
          <input type="file" name="file" id="file" required>

          <button type="submit" class="btn" style="width: 100%; margin-top: 15px;">Upload Resource</button>
        </form>
      </div>

    
      <div class="resource-list">
        <h3 style="color: #1a237e; margin-bottom: 15px;">Available Resources</h3>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <div class="form-card resource-item">
            <h4><?php echo htmlspecialchars($row['title']); ?></h4>
            <p>Uploaded by: <strong><?php echo htmlspecialchars($row['name']); ?></strong></p>
            <p><small><?php echo $row['uploaded_at']; ?></small></p>
            <a href="uploads/<?php echo $row['filename']; ?>" class="btn" download>Download</a>
          </div>
        <?php endwhile; ?>
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
