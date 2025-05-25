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

document.getElementById("searchForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Prevent form from actually submitting

  const location = document.getElementById("location").value.trim();

  if (location.length < 2) {
    console.warn("Please enter at least 2 characters.");
    return;
  }
  window.location.href = `pages/results.php?location=${encodeURIComponent(
    location
  )}`;
});

window.addEventListener("DOMContentLoaded", () => {
  const locationInput = document.getElementById("location");

  if (!locationInput) return;

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      async (position) => {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;

        try {
          const response = await fetch("api/search.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ lat, lon }),
          });

          const result = await response.json();
          locationInput.value = result.city || "Not found";
        } catch (err) {
          console.error(err);
          locationInput.value = "Error fetching city";
        }
      },
      () => {
        locationInput.value = "Location denied";
      }
    );
  } else {
    locationInput.value = "Geolocation not supported";
  }
});
const locationInput = document.getElementById("location");
const suggestionsBox = document.getElementById("suggestions");

locationInput.addEventListener("input", async () => {
  const query = locationInput.value.trim();

  // Clear old suggestions
  suggestionsBox.innerHTML = "";

  if (query.length < 2) return; // only search if 2+ chars

  try {
    const response = await fetch(
      `api/autocomplete.php?q=${encodeURIComponent(query)}`
    );
    const data = await response.json();

    // data should be an array of city names
    if (data.length === 0) return;

    const list = document.createElement("ul");
    list.style.position = "absolute";
    list.style.backgroundColor = "white";
    list.style.border = "1px solid #ccc";
    list.style.padding = "0";
    list.style.margin = "0";
    list.style.width = locationInput.offsetWidth + "px";
    list.style.listStyle = "none";
    list.style.maxHeight = "150px";
    list.style.overflowY = "auto";
    list.style.zIndex = "9999";

    data.forEach((city) => {
      const item = document.createElement("li");
      item.textContent = city;
      item.style.padding = "5px";
      item.style.cursor = "pointer";

      item.addEventListener("click", () => {
        locationInput.value = city;
        suggestionsBox.innerHTML = "";
      });

      list.appendChild(item);
    });

    suggestionsBox.appendChild(list);
  } catch (err) {
    console.error("Autocomplete error:", err);
  }
});
