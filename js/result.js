document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);
  const searchQuery = params.get("location");

  const container = document.getElementById("results");

  if (!searchQuery) {
    container.innerText = "No location provided.";
    return;
  }

  fetch("../api/listing.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({ location: searchQuery }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        if (data.data.length === 0) {
          container.innerText = "No listings found.";
        } else {
          container.innerHTML = data.data
            .map(
              (listing) => `
                <div class="listing">
                  <h3>${listing.title}</h3>
                  <p>${listing.city_area}</p>
                </div>
              `
            )
            .join("");
        }
      } else {
        container.innerText = "Error: " + data.error;
      }
    })
    .catch((err) => {
      container.innerText = "Fetch error: " + err;
    });
});
