document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("itemContainer");
  if (!container) return;

  const listing = JSON.parse(localStorage.getItem("selectedListing"));
  if (!listing) {
    container.innerHTML = "<p>No listing data found.</p>";
    return;
  }

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

  const renderField = (label, value) => {
    if (!value) return "";
    return `<p><strong>${label}:</strong> ${value}</p>`;
  };


  const furnishedText =
    listing.furnished === 1 || listing.furnished === "1"
      ? "Yes"
      : listing.furnished === 0 || listing.furnished === "0"
      ? "No"
      : "";

  const parkingText =
    listing.parking === 1 || listing.parking === "1"
      ? "Yes"
      : listing.parking === 0 || listing.parking === "0"
      ? "No"
      : "";

  let swiperHtml = `
    <div class="swiper item-swiper">
      <div class="swiper-wrapper item-swiper-wrapper" id="item-swiper-wrapper"></div>
      <div class="swiper-pagination item-swiper-pagination"></div>
      <div class="swiper-button-prev item-swiper-button-prev"></div>
      <div class="swiper-button-next item-swiper-button-next"></div>
    </div>
  `;

  container.innerHTML = `
    ${swiperHtml}
    <div class="item_detail">
      ${renderField("Title", listing.title)}
      ${renderField("Location", listing.city)}
      ${renderField("Address", listing.address)}
      ${renderField("Transaction", listing.transaction)}
      ${priceHtml}
      ${renderField(
        "Property Type",
        listing.property_type_name || listing.property_type
      )}
      ${renderField("Size", listing.size ? listing.size + " m²" : "")}
      ${renderField("Rooms", listing.rooms)}
      ${renderField("Beds", listing.beds)}
      ${renderField("Bathrooms", listing.bathroom)}
      ${renderField("Floor", listing.floor)}
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

  // Fetch images and render Swiper
  fetch(`../api/item_slider.php?property_id=${listing.property_id}`)
    .then((res) => res.json())
    .then((resData) => {
      if (resData.status === "success") {
        const wrapper = document.getElementById("item-swiper-wrapper");
        wrapper.innerHTML = resData.data
          .map(
            (img) =>
              `<div class="swiper-slide item-swiper-slide"><img src="${img.image_url}" alt="Property image" /></div>`
          )
          .join("");

        new Swiper(".item-swiper", {
          loop: true,
          pagination: {
            el: ".item-swiper-pagination",
            clickable: true,
          },
          navigation: {
            nextEl: ".item-swiper-button-next",
            prevEl: ".item-swiper-button-prev",
          },
        });
      } else {
        console.error("Failed to load images:", resData.message);
      }
    })
    .catch((err) => {
      console.error("Error loading images:", err);
    });
});
