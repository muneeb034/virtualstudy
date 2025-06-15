
    function deleteGroup(groupId, rowId) {
      if (confirm("Are you sure you want to delete this group?")) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "admin_deletegroup.php?id=" + groupId, true);
        xhr.onload = function () {
          if (this.status === 200 && this.responseText.trim() === "success") {
            document.getElementById(rowId).remove();
          } else {
            alert("Failed to delete the group.");
          }
        };
        xhr.send();
      }
    }
 