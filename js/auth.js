document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#register-form");

  const username = document.querySelector("#username");
  const email = document.querySelector("#email");
  const password = document.querySelector("#password");
  const first_name = document.querySelector("#first_name");
  const last_name = document.querySelector("#last_name");
  const phone = document.querySelector("#phone");

  const error_username = document.querySelector("#error_username");
  const error_email = document.querySelector("#error_email");
  const error_password = document.querySelector("#error_password");
  const error_first_name = document.querySelector("#error_first_name");
  const error_last_name = document.querySelector("#error_last_name");
  const error_phone = document.querySelector("#error_phone");

  form.addEventListener("submit", (event) => {
    let isValid = true;

    const username_value = username.value.trim();
    const email_value = email.value.trim();
    const password_value = password.value.trim();
    const first_name_value = first_name.value.trim();
    const last_name_value = last_name.value.trim();
    const phone_value = phone.value.trim();

    // USERNAME
    if (username_value.length < 8 || username_value === "") {
      error_username.textContent =
        "Username must contain at least 8 characters.";
      error_username.style.color = "red";
      username.style.border = "2px solid red";
      isValid = false;
    }

    // EMAIL
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email_value)) {
      error_email.textContent = "Invalid email format.";
      error_email.style.color = "red";
      email.style.border = "2px solid red";
      isValid = false;
    }

    // PASSWORD
    if (password_value.length < 8) {
      error_password.textContent = "Password must be at least 8 characters.";
      error_password.style.color = "red";
      password.style.border = "2px solid red";
      isValid = false;
    }

    // FIRST NAME
    if (
      !/^[a-zA-Z-' ]{3,50}$/.test(first_name_value) ||
      first_name_value === ""
    ) {
      error_first_name.textContent =
        "First name should contain only letters and be at least 3 characters.";
      error_first_name.style.color = "red";
      first_name.style.border = "2px solid red";
      isValid = false;
    }

    // LAST NAME
    if (
      !/^[a-zA-Z-' ]{3,50}$/.test(last_name_value) ||
      last_name_value === ""
    ) {
      error_last_name.textContent =
        "Last name should contain only letters and be at least 3 characters.";
      error_last_name.style.color = "red";
      last_name.style.border = "2px solid red";
      isValid = false;
    }

    // PHONE
    if (!/^[0-9 +\-]{5,20}$/.test(phone_value)) {
      error_phone.textContent = "Phone format is incorrect.";
      error_phone.style.color = "red";
      phone.style.border = "2px solid red";
      isValid = false;
    }

    if (!isValid) {
      event.preventDefault(); // Block form submission if validation fails
    }
  });

  // Clear errors on input
  username.addEventListener("input", () => {
    username.style.border = "";
    error_username.textContent = "";
  });

  email.addEventListener("input", () => {
    email.style.border = "";
    error_email.textContent = "";
  });

  password.addEventListener("input", () => {
    password.style.border = "";
    error_password.textContent = "";
  });

  first_name.addEventListener("input", () => {
    first_name.style.border = "";
    error_first_name.textContent = "";
  });

  last_name.addEventListener("input", () => {
    last_name.style.border = "";
    error_last_name.textContent = "";
  });

  phone.addEventListener("input", () => {
    phone.style.border = "";
    error_phone.textContent = "";
  });
});
