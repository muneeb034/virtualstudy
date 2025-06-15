
  function validateLogin() {
    const email = document.getElementById("email").value.trim();
    const pass = document.getElementById("password").value.trim();
    if (email === "" || pass === "") {
      alert("Please fill in all fields.");
      return false;
    }
    return true;
  }
