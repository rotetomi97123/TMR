document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("itemContainer");
  if (!container) return;

  const listing = JSON.parse(localStorage.getItem("selectedListing"));
  if (!listing) {
    container.innerHTML = "<p>No listing data found.</p>";
    return;
  }

  console.log(listing);

  let priceHtml = "";
  if (listing.transaction === "rent") {
    priceHtml = `<p><strong>Price:</strong> ${listing.price} RSD / month</p>`;
  } else {
    priceHtml = `<p><strong>Price:</strong> ${listing.price} EUR</p>`;
  }

  container.innerHTML = `
  <div class="item_detail">
    <img src="${listing.image_url}" alt="Property Image" />
    <h2>${listing.title}</h2>
    <p><strong>Location:</strong> ${listing.city}</p>
    <p><strong>Address:</strong> ${listing.address}</p>
    ${priceHtml}
    <p><strong>Beds:</strong> ${listing.beds}</p>
    <p><strong>Bathrooms:</strong> ${listing.bathroom}</p>
    <p><strong>Size:</strong> ${listing.size} m²</p>
    <div class='item_detail_flex'> 
      <p><a href="mailto:${listing.email}" class='item-contact'>Send Email</a></p> 
      <p><a href="tel:${listing.phone}" class='item-contact'>Call number</a></p>
    </div>
    </div>
`;
});
