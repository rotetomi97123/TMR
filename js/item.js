document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("itemContainer");
  if (!container) return;

  const listing = JSON.parse(localStorage.getItem("selectedListing"));
  if (!listing) {
    container.innerHTML = "<p>No listing data found.</p>";
    return;
  }

  container.innerHTML = `
    <div class="item_detail">
      <img src="${listing.image_url}" alt="Property Image" />
      <h2>${listing.title}</h2>
      <p><strong>Location:</strong> ${listing.city_area}</p>
      <p><strong>Address:</strong> ${listing.address}</p>
      <p><strong>Price:</strong> €${Math.round(
        listing.rental_price / 117
      )}/month</p>
      <p><strong>Beds:</strong> ${listing.beds}</p>
      <p><strong>Bathrooms:</strong> ${listing.bathroom}</p>
      <p><strong>Size:</strong> ${listing.square_meters} m²</p>
    </div>
  `;
});
