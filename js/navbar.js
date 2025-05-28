document.addEventListener("DOMContentLoaded", () => {
  const toggle = document.getElementById("menu-toggle");
  const menuIcon = document.getElementById("menu-icon");
  const mobileMenu = document.getElementById("mobile-menu");

  function toggleMenu() {
    mobileMenu.classList.toggle("active");
    menuIcon.classList.toggle("bi-list");
    menuIcon.classList.toggle("bi-x");
  }

  function closeMenuOnResize() {
    if (window.innerWidth > 768) {
      mobileMenu.classList.remove("active");
      menuIcon.classList.add("bi-list");
      menuIcon.classList.remove("bi-x");
    }
  }
  toggle.addEventListener("click", toggleMenu);
  window.addEventListener("resize", closeMenuOnResize);
});
