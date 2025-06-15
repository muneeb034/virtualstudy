<?php
session_start();
include("db.php"); 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_scholarship'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $pubDate = mysqli_real_escape_string($conn, $_POST['pubDate']);
    $source = mysqli_real_escape_string($conn, $_POST['source']);

    $query = "INSERT INTO scholarships (title, description, link, pubDate, source) 
              VALUES ('$title', '$description', '$link', '$pubDate', '$source')";
    mysqli_query($conn, $query);
    header("Location: admin_scholarship.php");
    exit;
}

$results = mysqli_query($conn, "SELECT * FROM scholarships ORDER BY pubDate DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - Manage Scholarships</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <div class="container">
    <h2>Scholarship Management</h2>

    <h3>Add New Scholarship</h3>
    <form method="POST" class="form-card">
      <label>Title</label>
      <input type="text" name="title" required>

      <label>Description</label>
      <textarea name="description" rows="4" required></textarea>

      <label>Link</label>
      <input type="text" name="link" required>

      <label>Publish Date</label>
      <input type="date" name="pubDate" required>

      <label>Source</label>
      <input type="text" name="source" required>

      <button type="submit" name="add_scholarship" class="btn">Add Scholarship</button>
    </form>

    <h3>Existing Scholarships</h3>
    <div class="scholarship-list">
      <?php while ($row = mysqli_fetch_assoc($results)) : ?>
        <div class="card">
          <h4><?= htmlspecialchars($row['title']) ?></h4>
          <p><?= htmlspecialchars($row['description']) ?></p>
          <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank">View</a>
          <small><?= $row['pubDate'] ?> | Source: <?= $row['source'] ?></small><br><br>
         <a href="delete_scholarship.php?id=<?= $row['id'] ?>" class="btn" onclick="return confirm('Are you sure you want to delete this scholarship?')">Delete</a>

        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>
