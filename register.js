
    document.addEventListener("DOMContentLoaded", function () {
      document.querySelector(".form").addEventListener("submit", function (e) {
        let valid = validateName() & validateEmail() & validateUsername() & validatePassword() & validateConfirm();
        if (!valid) {
          e.preventDefault();
        }
      });
    });

    function validateName() {
      let name = document.getElementById("name").value.trim();
      let error = document.getElementById("nameError");
      if (name.length < 3) {
        error.innerText = "Name must be at least 3 characters.";
        return false;
      }
      error.innerText = "";
      return true;
    }

    function validateEmail() {
      let email = document.getElementById("email").value.trim();
      let error = document.getElementById("emailError");
      let pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if (!pattern.test(email)) {
        error.innerText = "Invalid email format.";
        return false;
      }
      error.innerText = "";
      return true;
    }

    function validateUsername() {
      let username = document.getElementById("username").value.trim();
      let error = document.getElementById("usernameError");
      if (username.length < 3) {
        error.innerText = "Username must be at least 3 characters.";
        return false;
      }
      error.innerText = "";
      return true;
    }

    function validatePassword() {
      let password = document.getElementById("password").value;
      let error = document.getElementById("passwordError");
      let pattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
      if (!pattern.test(password)) {
        error.innerText = "Password must be 8+ chars, include 1 uppercase, 1 number & 1 special character.";
        return false;
      }
      error.innerText = "";
      return true;
    }

    function validateConfirm() {
      let password = document.getElementById("password").value;
      let confirm = document.getElementById("confirm").value;
      let error = document.getElementById("confirmError");
      if (password !== confirm) {
        error.innerText = "Passwords do not match.";
        return false;
      }
      error.innerText = "";
      return true;
    }
  