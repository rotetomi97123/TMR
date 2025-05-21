document.addEventListener("DOMContentLoaded", () => {
  fetch("api/listing.php")
    .then((res) => res.json())
    .then((data) => {
      const container = document.getElementById("listings");
      if (data.success) {
        data.data.forEach((listing) => {
          const div = document.createElement("div");
          div.innerHTML = `
            <h2>${listing.title}</h2>
            <p>${listing.description}</p>
            <p><strong>Price:</strong> ${listing.rental_price} €</p>
            <hr>
          `;
          container.appendChild(div);
        });
      } else {
        container.textContent = "Error loading listings.";
      }
    })
    .catch((err) => {
      console.error("Fetch error:", err);
      document.getElementById("listings").textContent = "Network error.";
    });
});
