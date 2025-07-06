document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".btn-show-more").forEach((button) => {
    button.addEventListener("click", () => {
      const details = button.previousElementSibling;
      if (details.classList.contains("hidden")) {
        details.classList.remove("hidden");
        button.textContent = "Show Less";
      } else {
        details.classList.add("hidden");
        button.textContent = "Show More";
      }
    });
  });
  document.querySelectorAll(".btn-action").forEach((button) => {
    button.addEventListener("click", async () => {
      const propertyId = button.dataset.id;
      const action = button.dataset.action;

      if (!confirm(`Are you sure you want to ${action} this property?`)) return;

      try {
        const res = await fetch("../auth/property_action.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id: propertyId, action }),
        });

        const data = await res.json();
        console.log(data);
        if (data.success) {
          const wrapper = button.closest(".property-card");
          wrapper?.remove();

          // Refresh the page after action success
          location.reload();
        } else {
          alert(data.message || "Action failed.");
        }
      } catch (err) {
        alert("Error connecting to server.");
      }
    });
  });

  const toggleBtn = document.getElementById("toggle-properties-btn");
  const activeDiv = document.getElementById("active-properties");
  const inactiveDiv = document.getElementById("inactive-properties");

  if (!toggleBtn || !activeDiv || !inactiveDiv) return;

  // On page load, under 1024px, show inactive by default
  function updateVisibility() {
    if (window.innerWidth <= 1024) {
      inactiveDiv.classList.add("active");
      activeDiv.classList.remove("active");
      toggleBtn.textContent = "Show Active Properties";
      toggleBtn.style.display = "flex";
    } else {
      // On larger screens, show both and hide toggle button
      inactiveDiv.classList.remove("active");
      activeDiv.classList.remove("active");
      inactiveDiv.style.display = "flex";
      activeDiv.style.display = "flex";
      toggleBtn.style.display = "none";
    }
  }

  updateVisibility();

  window.addEventListener("resize", updateVisibility);

  toggleBtn.addEventListener("click", () => {
    if (inactiveDiv.classList.contains("active")) {
      inactiveDiv.classList.remove("active");
      activeDiv.classList.add("active");
      toggleBtn.textContent = "Show Inactive Properties";
    } else {
      inactiveDiv.classList.add("active");
      activeDiv.classList.remove("active");
      toggleBtn.textContent = "Show Active Properties";
    }
  });
});
