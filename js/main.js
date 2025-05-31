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

      if (location.length < 2) {
        console.warn("Please enter at least 2 characters.");
        return;
      }

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
    fetch("/project/api/get_cities.php")
      .then((res) => res.json())
      .then((cities) => {
        const select = document.getElementById("location");
        cities.forEach((city) => {
          const option = document.createElement("option");
          option.value = city;
          option.textContent = city;
          select?.appendChild(option);
        });
      });
  });
  let currentProperty = 0;
  let autoRotateInterval;

  function initPropertyShowcase() {
    const properties = document.querySelectorAll(".property_card");
    const dots = document.querySelectorAll(".showcase_dots .dot");
    const prevArrow = document.getElementById("prevArrow");
    const nextArrow = document.getElementById("nextArrow");

    if (properties.length === 0) return;

    function showProperty(index) {
      properties.forEach((card) => card.classList.remove("active", "next"));
      dots.forEach((dot) => dot.classList.remove("active"));

      if (properties[index]) properties[index].classList.add("active");
      if (dots[index]) dots[index].classList.add("active");

      const nextIndex = (index + 1) % properties.length;
      if (properties[nextIndex]) properties[nextIndex].classList.add("next");

      currentProperty = index;
    }

    function autoRotate() {
      const nextIndex = (currentProperty + 1) % properties.length;
      showProperty(nextIndex);
    }

    // Arrow event handlers
    prevArrow?.addEventListener("click", () => {
      clearInterval(autoRotateInterval);
      const prevIndex =
        (currentProperty - 1 + properties.length) % properties.length;
      showProperty(prevIndex);
      autoRotateInterval = setInterval(autoRotate, 6000);
    });

    nextArrow?.addEventListener("click", () => {
      clearInterval(autoRotateInterval);
      const nextIndex = (currentProperty + 1) % properties.length;
      showProperty(nextIndex);
      autoRotateInterval = setInterval(autoRotate, 6000);
    });

    window.showProperty = showProperty;
    autoRotateInterval = setInterval(autoRotate, 6000);

    const showcase = document.querySelector(".property_showcase");
    showcase?.addEventListener("mouseenter", () =>
      clearInterval(autoRotateInterval)
    );
    showcase?.addEventListener(
      "mouseleave",
      () => (autoRotateInterval = setInterval(autoRotate, 4000))
    );

    showProperty(0);
  }

  // Fetch slider data
  fetch("/project/api/hero_slider.php", { method: "POST" })
    .then((res) => res.json())
    .then((data) => {
      if (data.success && data.data.length > 0) {
        const showcase = document.querySelector(".property_showcase");
        const dots = document.querySelector(".showcase_dots");

        data.data.forEach((listing, index) => {
          let priceDisplay = "";
          if (listing.listing_type === "sale") {
            let priceEUR =
              Math.floor(parseFloat(listing.rental_price) / 117 / 1000) * 1000;
            priceDisplay = priceEUR.toLocaleString("de-DE") + " €";
          } else {
            // Rental price formatting
            const price =
              Math.ceil(parseFloat(listing.rental_price) / 117 / 50) * 50;
            priceDisplay = `€${price}/month`;
          }
          const imageUrl =
            listing.image_url || "https://via.placeholder.com/400x250";
          const badgeText =
            index === 0 ? "Featured" : index === 1 ? "New" : "Popular";

          const card = document.createElement("div");
          card.className = "property_card";
          card.addEventListener("click", () => {
            localStorage.setItem("selectedListing", JSON.stringify(listing));
            window.location.href = "/project/pages/item.php";
          });
          card.innerHTML = `
          <div class="property_image" style="background-image: url('${imageUrl}');">
            <div class="property_badge">${badgeText}</div>
          </div>
          <div class="property_info">
            <p class="property_price"><span>${priceDisplay}</span></p>
            <h4 class="property_title">${
              listing.title || "Untitled Property"
            }</h4>
            <p class="property_location">${listing.city_area}</p>
            <div class="property_features">
              <p><img src="/project/assets/bed.svg" class="icon" /> ${
                listing.beds
              } beds</p>
              <p><img src="/project/assets/bath.svg" class="icon" /> ${
                listing.bathroom
              } bathrooms</p>
              <p><i class="bi bi-aspect-ratio"></i> ${
                listing.square_meters
              } m²</p>
            </div>
          </div>
        `;

          showcase?.appendChild(card);

          const dot = document.createElement("div");
          dot.className = "dot";
          dots?.appendChild(dot);
        });

        initPropertyShowcase();
      }
    });
});
