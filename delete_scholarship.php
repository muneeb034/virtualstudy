<?php
session_start();
include("db.php");



if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "DELETE FROM scholarships WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['message'] = "Scholarship deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete scholarship.";
    }
} else {
    $_SESSION['message'] = "Invalid delete request.";
}

header("Location: admin_scholarship.php");
exit;
?>
