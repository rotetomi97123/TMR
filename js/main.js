document.addEventListener("DOMContentLoaded", () => {
  // Handle search form
  document
    .getElementById("searchForm")
    ?.addEventListener("submit", function (e) {
      e.preventDefault();

      const location = document.getElementById("location").value.trim();
      const type = document.getElementById("type").value;

      // Get selected radio button value for listing_type
      const listingTypeRadio = document.querySelector(
        'input[name="listing_type"]:checked'
      );
      const listing_type = listingTypeRadio ? listingTypeRadio.value : "";

      if (!listing_type) {
        console.warn("Please select a listing type.");
        return;
      }

      // Redirect with all parameters
      window.location.href = `pages/results.php?location=${encodeURIComponent(
        location
      )}&type=${encodeURIComponent(type)}&listing_type=${encodeURIComponent(
        listing_type
      )}`;
    });

  // Populate location dropdown
  window.addEventListener("DOMContentLoaded", () => {
    fetch(BASE_URL + "api/get_type.php")
      .then((res) => res.json())
      .then((property_types) => {
        const select = document.getElementById("type");
        property_types.forEach((type) => {
          const option = document.createElement("option");
          option.value = type;
          option.textContent = type.charAt(0).toUpperCase() + type.slice(1);
          select?.appendChild(option);
        });
      });
  });
});
document.addEventListener("DOMContentLoaded", function () {
  fetch(BASE_URL + "api/hero_slider.php", { method: "POST" })
    .then((res) => res.json())
    .then((data) => {
      const swiperWrapper = document.querySelector(".swiper-wrapper");

      data.data.forEach((listing, index) => {
        // CALCULATE PRICE
        let priceHtml = "";
        const price = Math.round(listing.price);

        if (listing.transaction === "rent") {
          priceHtml = `<p class="prop_price"><span>${price} €</span> / month</p></p>`;
        } else {
          priceHtml = `<p class="prop_price"><span>${price} €</span></p>`;
        }

        const slide = document.createElement("div");
        slide.className = "swiper-slide property_card"; // add swiper-slide class
        slide.addEventListener("click", () => {
          localStorage.setItem("selectedListing", JSON.stringify(listing));
          window.location.href = BASE_URL + "pages/item.php";
        });

        slide.innerHTML = `
         <img src="${
           listing.image_url
         }" alt="property_image" class="property_image" />
      <div class="listing_content">
        ${priceHtml}
        <h4>${listing.city}</h4>
        <p>${listing.address}</p>
        <div class="listing_content_properties">
          <p><img src=${
            BASE_URL + "assets/bed.svg"
          } alt="bed icon" class="icon" /> ${listing.beds} </p>
          <p><img src=${
            BASE_URL + "assets/bath.svg"
          } alt="bathroom icon" class="icon" /> ${listing.bathroom} </p>
          <p><i class="bi bi-aspect-ratio"></i> ${listing.size} m²</p>
        </div>
      </div>
    `;

        swiperWrapper.appendChild(slide);
      });

      // Initialize swiper AFTER slides added
      const swiper = new Swiper(".swiper", {
        loop: true,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
      });
    })
    .catch((error) => {
      console.error("Error fetching slides:", error);
    });
  const input = document.getElementById("location");
  const results = document.getElementById("suggestions");

  input.addEventListener("input", () => {
    const value = input.value.trim();
    if (value.length === 0) return;
    fetch(
      BASE_URL + `api/search_suggestions.php?q=${encodeURIComponent(value)}`,
      { method: "POST" }
    )
      .then((res) => res.json())
      .then((data) => {
        results.innerHTML = "";
        console.log(data);
        data.forEach((item) => {
          const li = document.createElement("li");
          li.textContent = item;
          results.appendChild(li);
        });
      });
  });
});
