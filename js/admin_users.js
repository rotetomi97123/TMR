document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".btn-user-action").forEach((button) => {
    button.addEventListener("click", async () => {
      const userId = button.dataset.id;
      const action = button.dataset.action;

      if (!confirm(`Are you sure you want to ${action} this user?`)) return;

      try {
        const res = await fetch("../auth/user_action.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id: userId, action }),
        });

        const data = await res.json();
        if (data.success) {
          // Remove card and optionally refresh
          const card = button.closest(".property-card");
          if (card) card.remove();

          // Or reload the page to reflect changes:
          location.reload();
        } else {
          alert(data.message || "Action failed.");
        }
      } catch (err) {
        alert("Error connecting to server.");
      }
    });
  });
  const toggleBtn = document.getElementById("toggle-users-btn");
  const inactiveUsers = document.getElementById("inactive-users");
  const activeUsers = document.getElementById("active-users");

  // Track which list is visible on small screens
  let showingActive = false;

  function updateView() {
    if (window.innerWidth > 1024) {
      // On large screens, show both
      inactiveUsers.style.display = "";
      activeUsers.style.display = "";
      toggleBtn.style.display = "none"; // hide toggle button
    } else {
      // On small screens, toggle between lists
      toggleBtn.style.display = "inline-block"; // show toggle button
      if (showingActive) {
        inactiveUsers.style.display = "none";
        activeUsers.style.display = "block";
        toggleBtn.textContent = "Show Inactive Users";
      } else {
        inactiveUsers.style.display = "block";
        activeUsers.style.display = "none";
        toggleBtn.textContent = "Show Active Users";
      }
    }
  }

  // Initial call
  updateView();

  // On window resize, update view
  window.addEventListener("resize", updateView);

  // Toggle on button click
  toggleBtn.addEventListener("click", () => {
    showingActive = !showingActive;
    updateView();
  });
});
