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
document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);
  const searchQuery = params.get("location");
  const selectedType = params.get("type");

  const container = document.getElementById("results");

  if (!searchQuery || !selectedType) {
    container.innerText = "Location and type must be provided.";
    return;
  }

  fetch("/project/api/listing.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      location: searchQuery,
      type: selectedType,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        if (data.data.length === 0) {
          container.innerText = "No listings found.";
        } else {
          container.innerHTML = data.data
            .map(
              (listing) => `
                <div class="listing">
                  <img src="${listing.image_url}" alt="property_image" />
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
                      <p>
                        <i class="bi bi-aspect-ratio"></i> ${
                          listing.square_meters
                        } m²
                      </p>
                    </div>
                  </div>
                </div>
              `
            )
            .join("");
        }
      } else {
        container.innerText = "Error: " + data.error;
      }
    })
    .catch((err) => {
      container.innerText = "Fetch error: " + err;
    });
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

document.getElementById("searchForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Prevent form from submitting

  const location = document.getElementById("location").value.trim();
  const type = document.getElementById("type").value; // Get selected type
  const container = document.getElementById("results");

  if (location.length < 2) {
    console.warn("Please enter at least 2 characters.");
    return;
  }

  fetch("/project/api/listing.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      location: location,
      type: type,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        if (data.data.length === 0) {
          container.innerText = "No listings found.";
        } else {
          container.innerHTML = data.data
            .map(
              (listing) => `
                <div class="listing">
                  <img src="${listing.image_url}" alt="property_image" />
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
              `
            )
            .join("");
        }
      } else {
        container.innerText = "Error: " + data.error;
      }
    })
    .catch((err) => {
      container.innerText = "Fetch error: " + err;
    });
});
