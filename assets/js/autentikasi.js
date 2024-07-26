document.addEventListener("DOMContentLoaded", () => {
  const registerForm = document.getElementById("register-form");
  const togglePasswordIcons = document.querySelectorAll(".eye-icon");

  if (registerForm) {
    registerForm.addEventListener("submit", (e) => {
      let valid = true;

      const namaPengguna = document.getElementById("username");
      const email = document.getElementById("email");
      const password = document.getElementById("password");
      const confirmPassword = document.getElementById("confirm-password");

      if (namaPengguna.value.trim() === "") {
        valid = false;
        showError("username", "Nama pengguna harus diisi");
      } else {
        hideError("username");
      }

      if (email.value.trim() === "") {
        valid = false;
        showError("email", "Email harus diisi");
      } else {
        hideError("email");
      }

      if (password.value.trim() === "") {
        valid = false;
        showError("password", "Password harus diisi");
      } else {
        hideError("password");
      }

      if (confirmPassword.value.trim() === "") {
        valid = false;
        showError("confirm-password", "Konfirmasi password harus diisi");
      } else if (confirmPassword.value !== password.value) {
        valid = false;
        showError("confirm-password", "Konfirmasi password tidak cocok");
      } else {
        hideError("confirm-password");
      }

      if (!valid) {
        e.preventDefault();
      }
    });
  }

  togglePasswordIcons.forEach((icon) => {
    icon.addEventListener("click", () => {
      const passwordField = icon.previousElementSibling;
      const type =
        passwordField.getAttribute("type") === "password" ? "text" : "password";
      passwordField.setAttribute("type", type);
      icon.classList.toggle("bx-show");
      icon.classList.toggle("bx-hide");
    });
  });

  function showError(field, message) {
    const errorElement = document.getElementById(`${field}-error`);
    errorElement.textContent = message;
    errorElement.style.display = "block";
  }

  function hideError(field) {
    const errorElement = document.getElementById(`${field}-error`);
    errorElement.textContent = "";
    errorElement.style.display = "none";
  }
});
