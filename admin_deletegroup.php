<?php
include("db.php");

if (isset($_GET['id'])) {
    $group_id = intval($_GET['id']);

    
    $deleteMessages = mysqli_query($conn, "DELETE FROM group_messages WHERE group_id = $group_id");

   
    $deleteGroup = mysqli_query($conn, "DELETE FROM discussion_groups WHERE id = $group_id");

    if ($deleteGroup) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($conn);
    }
} else {
    echo "invalid";
}
?>
