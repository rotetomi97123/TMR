document.addEventListener("DOMContentLoaded", () => {
  const resultsContainer = document.getElementById("results");
  const typeSelect = document.getElementById("type");
  const searchForm = document.getElementById("searchForm");

  function renderListings(listings) {
    if (!listings.length) {
      resultsContainer.innerText = "No listings found.";
      return;
    }

    resultsContainer.innerHTML = ""; // clear old results

    listings.forEach((listing) => {
      const card = document.createElement("div");
      card.className = "listing property_card";
      // CALCULATE PRICE
      let priceHtml = "";
      const price = Math.round(listing.price);

      if (listing.transaction === "rent") {
        priceHtml = `<p class="prop_price"><span>${price} €</span> / month</p></p>`;
      } else {
        priceHtml = `<p class="prop_price"><span>${price} €</span></p>`;
      }

      const image = listing.image_url || "../assets/placeholder.jpg";

      card.innerHTML = `
  <img src="${image}" alt="property image" class="prop_image" />
  <div class="prop_content">
    ${priceHtml}
    <h4 class="prop_city">${listing.city}</h4>
    <p class="prop_address">${listing.address}</p>
    <div class="prop_details">
      <p><img src="../assets/bed.svg" class="prop_icon" /> ${
        listing.beds ?? "-"
      } </p>
      <p><img src="../assets/bath.svg" class="prop_icon" /> ${
        listing.bathroom ?? "-"
      } </p>
      <p><i class="bi bi-aspect-ratio"></i> ${
        listing.square_meters ?? "-"
      } m²</p>
    </div>
  </div>
`;

      card.addEventListener("click", () => {
        localStorage.setItem("selectedListing", JSON.stringify(listing));
        window.location.href = "../pages/item.php";
      });

      resultsContainer.appendChild(card);
    });
  }

  function fetchListings(city, type, transaction, price, square_meters) {
    resultsContainer.innerText = "Loading...";
    fetch("../api/listing.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        location: city,
        type,
        listing_type: transaction,
        rental_price: price,
        square_meters,
      }),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          renderListings(data.data);
        } else {
          resultsContainer.innerText = "Error: " + data.error;
        }
      })
      .catch((err) => {
        resultsContainer.innerText = "Fetch error: " + err;
      });
  }

  function loadCities() {
    return fetch("../api/get_type.php")
      .then((res) => res.json())
      .then((cities) => {
        typeSelect.innerHTML = "";
        cities.forEach((city) => {
          const option = document.createElement("option");
          option.value = city;
          option.textContent = city.charAt(0).toUpperCase() + city.slice(1);
          typeSelect.appendChild(option);
        });
      });
  }

  function prefillForm({ location, type, listing_type }) {
    typeSelect.value = location;
    document.getElementById("type").value = type;

    const radio = document.querySelector(
      `input[name="listing_type"][value="${listing_type}"]`
    );
    if (radio) radio.checked = true;
  }

  async function handleInitialSearch() {
    const params = new URLSearchParams(window.location.search);
    const location = params.get("location") || "";
    const type = params.get("type") || "";
    const listing_type = params.get("listing_type") || "";
    const rental_price = params.get("rental_price") || "";
    const square_meters = params.get("square_meters") || "";

    await loadCities();
    prefillForm({ location, type, listing_type });
    fetchListings(location, type, listing_type, rental_price, square_meters);
  }

  handleInitialSearch();

  searchForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const type = typeSelect.value.trim();
    const location = document.getElementById("location").value;
    const listingTypeRadio = document.querySelector(
      'input[name="listing_type"]:checked'
    );
    const listing_type = listingTypeRadio ? listingTypeRadio.value : "";
    const rental_price =
      document.getElementById("rental_price")?.value.trim() || "";
    const square_meters =
      document.getElementById("square_meters")?.value.trim() || "";

    if (!listing_type) return console.warn("Select listing type.");

    fetchListings(location, type, listing_type, rental_price, square_meters);
  });
});
