document.addEventListener("DOMContentLoaded", () => {
  const sidebarToggle = document.createElement("button");
  sidebarToggle.className = "sidebar-toggle";
  sidebarToggle.innerHTML = '<i class="bx bx-menu"></i>';
  document.body.appendChild(sidebarToggle);

  const sidebar = document.querySelector(".sidebar");
  sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("active");
  });
});

let preloader = select("#preloader");
if (preloader) {
  window.addEventListener("load", () => {
    preloader.remove();
  });
}
