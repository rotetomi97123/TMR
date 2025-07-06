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
    priceHtml = listing.price
      ? `<p><strong>Price:</strong> ${listing.price} € / month</p>`
      : "";
  } else {
    priceHtml = listing.price
      ? `<p><strong>Price:</strong> ${listing.price} €</p>`
      : "";
  }

  // Helper function to render only if value exists and is not empty string
  const renderField = (label, value) => {
    if (value === null || value === undefined || value === "") return "";
    return `<p><strong>${label}:</strong> ${value}</p>`;
  };

  // Format date if exists
  const availableFrom = listing.available_from
    ? new Date(listing.available_from).toLocaleDateString()
    : "";

  // Furnished display (assuming 0 = No, 1 = Yes)
  let furnishedText = "";
  if (listing.furnished === 1 || listing.furnished === "1") {
    furnishedText = "Yes";
  } else if (listing.furnished === 0 || listing.furnished === "0") {
    furnishedText = "No";
  }

  // Parking display
  let parkingText = "";
  if (listing.parking === 1 || listing.parking === "1") {
    parkingText = "Yes";
  } else if (listing.parking === 0 || listing.parking === "0") {
    parkingText = "No";
  }

  container.innerHTML = `
    <div class="item_detail">
      ${
        listing.image_url
          ? `<img src="${listing.image_url}" alt="Property Image" />`
          : ""
      }
      ${renderField("Title", listing.title)}
      ${renderField("Location", listing.city)}
      ${renderField("Address", listing.address)}
      ${renderField("Zip Code", listing.zip_code)}
      ${renderField("Transaction", listing.transaction)}
      ${priceHtml}
      ${
        availableFrom
          ? `<p><strong>Available From:</strong> ${availableFrom}</p>`
          : ""
      }
      ${renderField(
        "Property Type",
        listing.property_type_name || listing.property_type
      )}
      ${renderField("Size", listing.size ? listing.size + " m²" : "")}
      ${renderField("Rooms", listing.rooms)}
      ${renderField("Beds", listing.beds)}
      ${renderField("Bathrooms", listing.bathroom)}
      ${renderField(
        "Floor",
        listing.floor !== null && listing.floor !== undefined
          ? listing.floor
          : ""
      )}
      ${
        furnishedText
          ? `<p><strong>Furnished:</strong> ${furnishedText}</p>`
          : ""
      }
      ${renderField("Heating Type", listing.heating_type)}
      ${parkingText ? `<p><strong>Parking:</strong> ${parkingText}</p>` : ""}
      <div class='item_detail_flex'>
        ${
          listing.email
            ? `<p><a href="mailto:${listing.email}" class='item-contact'>Send Email</a></p>`
            : ""
        }
        ${
          listing.phone
            ? `<p><a href="tel:${listing.phone}" class='item-contact'>Call number</a></p>`
            : ""
        }
      </div>
    </div>
  `;
});
