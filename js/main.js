const toggle = document.getElementById("menu-toggle");
const menuIcon = document.getElementById("menu-icon");
const mobileMenu = document.getElementById("mobile-menu");

toggle.addEventListener("click", () => {
  mobileMenu.classList.toggle("active");

  // Toggle icon class
  if (menuIcon.classList.contains("bi-list")) {
    menuIcon.classList.replace("bi-list", "bi-x");
  } else {
    menuIcon.classList.replace("bi-x", "bi-list");
  }
});

// Hide menu on resize and reset icon
window.addEventListener("resize", () => {
  if (window.innerWidth > 768) {
    mobileMenu.classList.remove("active");
    menuIcon.classList.replace("bi-x", "bi-list");
  }
});
document.addEventListener("DOMContentLoaded", () => {
  fetch("api/listing.php")
    .then((res) => res.json())
    .then((data) => {
      const container = document.getElementById("listings");
      if (data.success) {
        data.data.forEach((listing) => {
          const div = document.createElement("div");
          div.innerHTML = `
            <h2>${listing.title}</h2>
            <p>${listing.description}</p>
            <p><strong>Price:</strong> ${listing.rental_price} €</p>
            <hr>
          `;
          container.appendChild(div);
        });
      } else {
        container.textContent = "Error loading listings.";
      }
    })
    .catch((err) => {
      console.error("Fetch error:", err);
      document.getElementById("listings").textContent = "Network error.";
    });
});
