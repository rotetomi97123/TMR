document.addEventListener("DOMContentLoaded", () => {
  const resultsContainer = document.getElementById("results");
  const typeSelect = document.getElementById("type");
  const searchForm = document.getElementById("searchForm");

  // Segédfüggvény: csak akkor ad vissza HTML-t, ha van érték
  function renderField(label, value, unit = "") {
    if (value === null || value === undefined || value === "") return "";
    return `<p><strong>${label}:</strong> ${value}${unit}</p>`;
  }

  // Az egyes kártyák renderelése
  function renderListings(listings) {
    if (!listings.length) {
      resultsContainer.innerText = "No listings found.";
      return;
    }

    resultsContainer.innerHTML = ""; // töröljük az előzőeket

    listings.forEach((listing) => {
      const card = document.createElement("div");
      card.className = "listing property_card";

      // Ár kerekítése és megjelenítése
      const price = Math.round(listing.price);
      let priceHtml = "";
      if (listing.transaction === "rent") {
        priceHtml = price
          ? `<p class="prop_price"><span>${price} €</span> / month</p>`
          : "";
      } else {
        priceHtml = price
          ? `<p class="prop_price"><span>${price} €</span></p>`
          : "";
      }

      const image = listing.image_url || "../assets/placeholder.jpg";

      // Kártya belső HTML összeállítása, csak nem üres mezők jelennek meg
      card.innerHTML = `
        <img src="${image}" alt="property image" class="prop_image" />
        <div class="prop_content">
          ${priceHtml}
          ${renderField("City", listing.city)}
          ${renderField("Address", listing.address)}
          <div class="prop_details">
            ${renderField(
              "",
              listing.beds ?? "",
              ` <img src="../assets/bed.svg" class="prop_icon" />`
            )}
            ${renderField(
              "",
              listing.bathroom ?? "",
              ` <img src="../assets/bath.svg" class="prop_icon" />`
            )}
            ${renderField(
              "",
              listing.square_meters ?? "",
              ` m² <i class="bi bi-aspect-ratio"></i>`
            )}
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

  // Az API hívás, keresés
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

  // Típusok betöltése a selectbe
  function loadTypes() {
    return fetch("../api/get_type.php")
      .then((res) => res.json())
      .then((types) => {
        typeSelect.innerHTML = "";
        types.forEach((type) => {
          const option = document.createElement("option");
          option.value = type;
          option.textContent = type.charAt(0).toUpperCase() + type.slice(1);
          typeSelect.appendChild(option);
        });
      });
  }

  // Form előtöltése url paraméterek alapján
  function prefillForm({ location, type, listing_type }) {
    document.getElementById("location").value = location || "";
    typeSelect.value = type || "";

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

    await loadTypes();
    prefillForm({ location, type, listing_type });
    fetchListings(location, type, listing_type, rental_price, square_meters);
  }

  handleInitialSearch();

  searchForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const type = typeSelect.value.trim();
    const location = document.getElementById("location").value.trim();
    const listingTypeRadio = document.querySelector(
      'input[name="listing_type"]:checked'
    );
    const listing_type = listingTypeRadio ? listingTypeRadio.value : "";
    const rental_price =
      document.getElementById("rental_price")?.value.trim() || "";
    const square_meters =
      document.getElementById("square_meters")?.value.trim() || "";

    if (!listing_type) {
      console.warn("Select listing type.");
      return;
    }

    fetchListings(location, type, listing_type, rental_price, square_meters);
  });
});
