document.addEventListener("DOMContentLoaded", () => {
  const save_profile_form = document.querySelector(".save_profile");

  const save_username = document.querySelector(".save_profile_username");
  const save_first_name = document.querySelector(".save_profile_first_name");
  const save_last_name = document.querySelector(".save_profile_last_name");
  const save_phone = document.querySelector(".save_profile_phone");

  const error_msg_username = document.querySelector("#error_msg_username");
  const error_msg_first_name = document.querySelector("#error_msg_first_name");
  const error_msg_last_name = document.querySelector("#error_msg_last_name");
  const error_msg_phone = document.querySelector("#error_msg_phone");

  save_profile_form.addEventListener("submit", (event) => {
    let isValid = true;

    const save_username_value = save_username.value.trim();
    const save_first_name_value = save_first_name.value.trim();
    const save_last_name_value = save_last_name.value.trim();
    const save_phone_value = save_phone.value.trim();

    // USERNAME
    if (save_username_value.length < 8 || save_username_value === "") {
      error_msg_username.textContent =
        "Username must contain at least 8 characters.";
      error_msg_username.style.color = "red";
      save_username.style.border = "2px solid red";
      isValid = false;
    }
    // FIRST NAME
    if (
      !/^[a-zA-Z-' ]{2,50}$/.test(save_first_name_value) ||
      save_username_value === "" ||
      save_first_name_value.length < 3
    ) {
      error_msg_first_name.textContent =
        "First name should be only characters atleast 3.";
      error_msg_first_name.style.color = "red";
      save_first_name.style.border = "2px solid red";
      isValid = false;
    }
    // LAST NAME
    if (
      !/^[a-zA-Z-' ]{2,50}$/.test(save_last_name_value) ||
      save_last_name_value === "" ||
      save_last_name_value.length < 3
    ) {
      error_msg_last_name.textContent =
        "Last name should be only characters atleast 3.";
      error_msg_last_name.style.color = "red";
      save_last_name.style.border = "2px solid red";
      isValid = false;
    }
    // PHONE NUMBER
    if (
      !/^[0-9 +\-]{5,20}$/.test(save_phone_value) ||
      save_phone_value === "" ||
      save_phone_value.length < 3
    ) {
      error_msg_phone.textContent = "Phone format incorrect.";
      error_msg_phone.style.color = "red";
      save_phone.style.border = "2px solid red";
      isValid = false;
    }

    if (!isValid) {
      event.preventDefault();
    }
  });

  save_username.addEventListener("input", () => {
    save_username.style.border = "";
    error_msg_username.textContent = "";
  });
  save_first_name.addEventListener("input", () => {
    save_first_name.style.border = "";
    error_msg_first_name.textContent = "";
  });
  save_last_name.addEventListener("input", () => {
    save_last_name.style.border = "";
    error_msg_last_name.textContent = "";
  });
  save_phone.addEventListener("input", () => {
    save_phone.style.border = "";
    error_msg_phone.textContent = "";
  });
});
