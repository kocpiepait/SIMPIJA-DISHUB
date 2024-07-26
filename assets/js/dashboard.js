document.addEventListener("DOMContentLoaded", () => {
  const sidebarToggle = document.createElement("button");
  sidebarToggle.className = "sidebar-toggle";
  sidebarToggle.innerHTML = '<i class="bx bx-menu"></i>';
  document.body.appendChild(sidebarToggle);

  const sidebar = document.querySelector(".sidebar");
  sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("active");
  });

  const logoutLink = document.querySelector('a[href="autentikasi/logout.php"]');
  if (logoutLink) {
    logoutLink.addEventListener("click", (e) => {
      e.preventDefault();
      const confirmLogout = confirm("Apakah Anda yakin ingin logout?");
      if (confirmLogout) {
        window.location.href = logoutLink.href;
      }
    });
  }
});

let preloader = select("#preloader");
if (preloader) {
  window.addEventListener("load", () => {
    preloader.remove();
  });
}
