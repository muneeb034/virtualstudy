
    function confirmDelete(taskId) {
      if (confirm("Are you sure you want to delete this task?")) {
        window.location.href = "planner.php?delete=" + taskId;
      }
    }
 