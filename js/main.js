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
  fetch("/project/api/get_cities.php")
    .then((res) => res.json())
    .then((cities) => {
      const select = document.getElementById("location");

      cities.forEach((city) => {
        const option = document.createElement("option");
        option.value = city;
        option.textContent = city;
        select.appendChild(option);
      });
    });
});

window.addEventListener("DOMContentLoaded", () => {
  fetch("/project/api/hero_listing.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ location: "Beograd" }),
  })
    .then((res) => {
      if (!res.ok) throw new Error("Network response not ok");
      return res.json();
    })
    .then((response) => {
      if (response.success) {
        const listings = response.data;

        // Find the container div where you want to place listings
        const container = document.getElementById("listingsContainer");
        if (!container) {
          console.error("Container div with id 'listingsContainer' not found");
          return;
        }

        // Clear previous content
        container.innerHTML = "";

        // Create divs with all data for each listing
        listings.forEach((listing) => {
          const div = document.createElement("div");
          div.classList.add("listing");

          div.innerHTML = `
             <div class="listing2">
                  <img src=${
                    listing.image_url
                  }  alt="property_image" class="hero_image"/>
                  <div class="listing_content">
                   <p class="listing_content_price">
                      <span>
                        ${Math.round(parseFloat(listing.rental_price) / 117)}€
                      </span>
                      /month
                    </p>
                    <h4>${listing.city_area}</h4>
                    <p>${listing.address}</p>
                    <div class="listing_content_properties">
                        <p>
                          <img src="/project/assets/bed.svg" alt="bed icon" class="icon" />
                          ${listing.beds} beds
                        </p>
                        <p>
                          <img src="/project/assets/bath.svg" alt="bathroom icon" class="icon" />
                          ${listing.bathroom} bathrooms
                        </p>
                      <p><i class="bi bi-aspect-ratio"></i> ${
                        listing.square_meters
                      } m²</p>
                    </div>
                  </div>
                </div>
          `;

          container.appendChild(div);
        });
      } else {
        console.error("API error:", response.error);
      }
    })
    .catch((error) => {
      console.error("Fetch error:", error);
    });
});
