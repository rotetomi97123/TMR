const toggle = document.getElementById("menu-toggle");
const menuIcon = document.getElementById("menu-icon");
const mobileMenu = document.getElementById("mobile-menu");
const resultsContainer = document.getElementById("results");
const locationSelect = document.getElementById("location");
const searchForm = document.getElementById("searchForm");

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

function renderListings(listings) {
  if (!listings.length) {
    resultsContainer.innerText = "No listings found.";
    return;
  }

  // Clear container first
  resultsContainer.innerHTML = "";

  listings.forEach((listing) => {
    const card = document.createElement("div");
    card.className = "listing property_card"; // add your property_card class here

    card.innerHTML = `
      <img src="${listing.image_url}" alt="property_image" />
      <div class="listing_content">
        <p class="listing_content_price"><span>${Math.round(
          parseFloat(listing.rental_price) / 117
        )}€</span>/month</p>
        <h4>${listing.city_area}</h4>
        <p>${listing.address}</p>
        <div class="listing_content_properties">
          <p><img src="/project/assets/bed.svg" alt="bed icon" class="icon" /> ${
            listing.beds
          } beds</p>
          <p><img src="/project/assets/bath.svg" alt="bathroom icon" class="icon" /> ${
            listing.bathroom
          } bathrooms</p>
          <p><i class="bi bi-aspect-ratio"></i> ${listing.square_meters} m²</p>
        </div>
      </div>
    `;

    card.addEventListener("click", () => {
      localStorage.setItem("selectedListing", JSON.stringify(listing));
      window.location.href = "/project/pages/item.php";
    });

    resultsContainer.appendChild(card);
  });
}

function fetchListings(location, type) {
  resultsContainer.innerText = "Loading...";
  fetch("/project/api/listing.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({ location, type }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) renderListings(data.data);
      else resultsContainer.innerText = "Error: " + data.error;
    })
    .catch((err) => {
      resultsContainer.innerText = "Fetch error: " + err;
    });
}

function loadCities() {
  fetch("/project/api/get_cities.php")
    .then((res) => res.json())
    .then((cities) => {
      cities.forEach((city) => {
        const option = document.createElement("option");
        option.value = city;
        option.textContent = city;
        locationSelect.appendChild(option);
      });
    });
}

function handleInitialSearch() {
  const params = new URLSearchParams(window.location.search);
  const location = params.get("location");
  const type = params.get("type");

  if (!location || !type) {
    resultsContainer.innerText = "Location and type must be provided.";
    return;
  }
  fetchListings(location, type);
}

toggle.addEventListener("click", toggleMenu);
window.addEventListener("resize", closeMenuOnResize);
window.addEventListener("DOMContentLoaded", () => {
  loadCities();
  handleInitialSearch();
});

searchForm.addEventListener("submit", (e) => {
  e.preventDefault();
  const location = locationSelect.value.trim();
  const type = document.getElementById("type").value;

  if (location.length < 2) {
    console.warn("Please enter at least 2 characters.");
    return;
  }
  fetchListings(location, type);
});
