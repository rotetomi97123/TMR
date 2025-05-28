document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("itemContainer");
  if (!container) return;

  const listing = JSON.parse(localStorage.getItem("selectedListing"));
  if (!listing) {
    container.innerHTML = "<p>No listing data found.</p>";
    return;
  }

  let priceDisplay = "";
  if (listing.listing_type === "sale") {
    let priceEUR =
      Math.floor(parseFloat(listing.rental_price) / 117 / 1000) * 1000;
    priceDisplay = priceEUR.toLocaleString("de-DE") + " €";
  } else {
    // Rental price formatting
    const price = Math.ceil(parseFloat(listing.rental_price) / 117 / 50) * 50;
    priceDisplay = `€${price}/month`;
  }

  container.innerHTML = `
    <div class="item_detail">
      <img src="${listing.image_url}" alt="Property Image" />
      <h2>${listing.title}</h2>
      <p><strong>Location:</strong> ${listing.city_area}</p>
      <p><strong>Address:</strong> ${listing.address}</p>
      <p><strong>Price:</strong> ${priceDisplay}</p>
      <p><strong>Beds:</strong> ${listing.beds}</p>
      <p><strong>Bathrooms:</strong> ${listing.bathroom}</p>
      <p><strong>Size:</strong> ${listing.square_meters} m²</p>
    </div>
  `;
});
