const resultsContainer = document.getElementById("results");
const locationSelect = document.getElementById("location");
const searchForm = document.getElementById("searchForm");

function renderListings(listings) {
  if (!listings.length) {
    resultsContainer.innerText = "No listings found.";
    return;
  }

  // Clear container first
  resultsContainer.innerHTML = "";

  listings.forEach((listing) => {
    const card = document.createElement("div");
    card.className = "listing property_card";
    let priceEUR = 0;
    if (listing.listing_type === "rent") {
      priceEUR = Math.ceil(parseFloat(listing.rental_price) / 117 / 50) * 50;
    } else {
      priceEUR =
        Math.floor(parseFloat(listing.rental_price) / 117 / 1000) * 1000;
    }

    priceEUR = priceEUR.toLocaleString("de-DE") + " €";
    card.innerHTML = `
      <img src="${listing.image_url}" alt="property_image" />
      <div class="listing_content">
        <p class="listing_content_price"><span>${priceEUR}</p>
        <h4>${listing.city_area}</h4>
        <p>${listing.address}</p>
        <div class="listing_content_properties">
          <p><img src="/project/assets/bed.svg" alt="bed icon" class="icon" /> ${listing.beds} beds</p>
          <p><img src="/project/assets/bath.svg" alt="bathroom icon" class="icon" /> ${listing.bathroom} bathrooms</p>
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

function fetchListings(
  location,
  type,
  listing_type,
  rental_price,
  square_meters
) {
  resultsContainer.innerText = "Loading...";
  fetch("/project/api/listing.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      location,
      type,
      listing_type,
      rental_price,
      square_meters,
    }),
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

// Load cities and return a Promise so we can await it
function loadCities() {
  return fetch("/project/api/get_cities.php")
    .then((res) => res.json())
    .then((cities) => {
      locationSelect.innerHTML = ""; // Clear previous options
      cities.forEach((city) => {
        const option = document.createElement("option");
        option.value = city;
        option.textContent = city;
        locationSelect.appendChild(option);
      });
    });
}

// Prefill form inputs from parameters
function prefillForm({ location, type, listing_type }) {
  locationSelect.value = location;
  document.getElementById("type").value = type;

  const radioToCheck = document.querySelector(
    `input[name="listing_type"][value="${listing_type}"]`
  );
  if (radioToCheck) radioToCheck.checked = true;
}

async function handleInitialSearch() {
  const params = new URLSearchParams(window.location.search);
  const location = params.get("location");
  const type = params.get("type");
  const listing_type = params.get("listing_type");
  const rental_price = params.get("rental_price");
  const square_meters = params.get("square_meters");

  if (!location || !type || !listing_type) {
    resultsContainer.innerText =
      "Location, type,price, and listing type must be provided.";
    return;
  }

  await loadCities(); // wait for cities to load first
  prefillForm({ location, type, listing_type });
  fetchListings(location, type, listing_type, rental_price, square_meters);
}

window.addEventListener("DOMContentLoaded", () => {
  handleInitialSearch();
});

searchForm.addEventListener("submit", (e) => {
  e.preventDefault();
  const location = locationSelect.value.trim();
  const type = document.getElementById("type").value;
  const listingTypeRadio = document.querySelector(
    'input[name="listing_type"]:checked'
  );
  const listing_type = listingTypeRadio ? listingTypeRadio.value : "";
  const rental_price = document.getElementById("rental_price").value.trim();
  const square_meters = document.getElementById("square_meters").value.trim();

  if (location.length < 2) {
    console.warn("Please enter at least 2 characters.");
    return;
  }
  if (!listing_type) {
    console.warn("Please select a listing type.");
    return;
  }

  fetchListings(location, type, listing_type, rental_price, square_meters);
});
