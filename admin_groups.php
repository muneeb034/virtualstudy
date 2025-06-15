<?php
include("db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css\admin_groups.css">
  <title>Manage Discussion Groups</title>
</head>
<body>

<h2 style="text-align: center;">All Discussion Groups</h2>
<table>
  <tr><th>ID</th><th>Group Name</th><th>Action</th></tr>
  <?php
  $result = mysqli_query($conn, "SELECT * FROM discussion_groups");
  $counter = 0;
  while ($row = mysqli_fetch_assoc($result)) {
      $rowId = "group_row_" . $counter;
      echo "<tr id='{$rowId}'>
              <td>{$row['id']}</td>
              <td>{$row['group_name']}</td>
              <td>
                <button class='btn-delete' onclick='deleteGroup({$row['id']}, \"{$rowId}\")'>Delete</button>
              </td>
            </tr>";
      $counter++;
  }
  ?>
</table>
<script src="JS\admin_group.js" ></script>

</body>
</html>
