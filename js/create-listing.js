document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#property-form");

  const image = document.querySelector("#image");
  const image_url = document.querySelector("#image_url");
  const title = document.querySelector("#title");
  const description = document.querySelector("#description");
  const city = document.querySelector("#city");
  const property_type = document.querySelector("#property_type");
  const listing_type = document.querySelector("#listing_type");
  const rental_price = document.querySelector("#rental_price");
  const address = document.querySelector("#address");
  const beds = document.querySelector("#beds");
  const bathroom = document.querySelector("#bathroom");
  const square_meters = document.querySelector("#square_meters");
  const rooms = document.querySelector("#rooms");
  const floor = document.querySelector("#floor");
  const furnished = document.querySelector("#furnished");
  const heating_type = document.querySelector("#heating_type");

  const error_image = document.querySelector("#error_image");
  const error_image_url = document.querySelector("#error_image_url");
  const error_title = document.querySelector("#error_title");
  const error_description = document.querySelector("#error_description");
  const error_city = document.querySelector("#error_city");
  const error_property_type = document.querySelector("#error_property_type");
  const error_listing_type = document.querySelector("#error_listing_type");
  const error_rental_price = document.querySelector("#error_rental_price");
  const error_address = document.querySelector("#error_address");
  const error_beds = document.querySelector("#error_beds");
  const error_bathroom = document.querySelector("#error_bathroom");
  const error_square_meters = document.querySelector("#error_square_meters");
  const error_rooms = document.querySelector("#error_rooms");
  const error_floor = document.querySelector("#error_floor");
  const error_furnished = document.querySelector("#error_furnished");
  const error_heating_type = document.querySelector("#error_heating_type");

  const allowedFormats = ["image/jpeg", "image/png", "image/gif"];
  const maxFileSize = 2 * 1024 * 1024; // 2 MB

  form.addEventListener("submit", (event) => {
    let isValid = true;

    const image_value = image.files.length;
    const image_url_value = image_url.value.trim();
    const title_value = title.value.trim();
    const description_value = description.value.trim();
    const city_value = city.value.trim();
    const property_type_value = property_type.value;
    const listing_type_value = listing_type.value;
    const rental_price_value = rental_price.value.trim();
    const address_value = address.value.trim();
    const beds_value = beds.value.trim();
    const bathroom_value = bathroom.value.trim();
    const square_meters_value = square_meters.value.trim();
    const rooms_value = rooms.value.trim();
    const floor_value = floor.value.trim();
    const furnished_value = furnished.value.trim();
    const heating_type_value = heating_type.value.trim();

    // IMAGE or IMAGE URL
    if (image_value === 0 && image_url_value === "") {
      error_image.textContent = "Please upload an image or enter an image URL.";
      error_image.style.color = "red";
      image.style.border = "2px solid red";

      error_image_url.textContent =
        "Please upload an image or enter an image URL.";
      error_image_url.style.color = "red";
      image_url.style.border = "2px solid red";
      isValid = false;
    } else {
      if (image_value > 0) {
        const file = image.files[0];

        if (!allowedFormats.includes(file.type)) {
          error_image.textContent =
            "Invalid file format. Only JPG, PNG and GIF are allowed.";
          error_image.style.color = "red";
          image.style.border = "2px solid red";
          isValid = false;
        } else if (file.size > maxFileSize) {
          error_image.textContent = "File size exceeds 2 MB.";
          error_image.style.color = "red";
          image.style.border = "2px solid red";
          isValid = false;
        } else {
          error_image.textContent = "";
          image.style.border = "";
        }

        error_image_url.textContent = "";
        image_url.style.border = "";
      } else if (image_url_value !== "") {
        const urlPattern = /^(https?:\/\/[^\s]+)$/;
        if (!urlPattern.test(image_url_value)) {
          error_image_url.textContent = "Invalid URL format.";
          error_image_url.style.color = "red";
          image_url.style.border = "2px solid red";
          isValid = false;
        } else {
          error_image_url.textContent = "";
          image_url.style.border = "";
          error_image.textContent = "";
          image.style.border = "";
        }
      }
    }

    // TITLE
    if (title_value.length < 5) {
      error_title.textContent = "Title must be at least 5 characters.";
      error_title.style.color = "red";
      title.style.border = "2px solid red";
      isValid = false;
    } else {
      error_title.textContent = "";
      title.style.border = "";
    }

    // DESCRIPTION
    if (description_value.length < 10) {
      error_description.textContent =
        "Description must be at least 10 characters.";
      error_description.style.color = "red";
      description.style.border = "2px solid red";
      isValid = false;
    } else {
      error_description.textContent = "";
      description.style.border = "";
    }

    // CITY
    if (!/^[a-zA-Z\s\-]{2,50}$/.test(city_value)) {
      error_city.textContent =
        "City must contain only letters and be at least 2 characters.";
      error_city.style.color = "red";
      city.style.border = "2px solid red";
      isValid = false;
    } else {
      error_city.textContent = "";
      city.style.border = "";
    }

    // PROPERTY TYPE
    if (!property_type_value) {
      error_property_type.textContent = "Please select a property type.";
      error_property_type.style.color = "red";
      property_type.style.border = "2px solid red";
      isValid = false;
    } else {
      error_property_type.textContent = "";
      property_type.style.border = "";
    }

    // LISTING TYPE
    if (!listing_type_value) {
      error_listing_type.textContent = "Please select a listing type.";
      error_listing_type.style.color = "red";
      listing_type.style.border = "2px solid red";
      isValid = false;
    } else {
      error_listing_type.textContent = "";
      listing_type.style.border = "";
    }

    // PRICE
    if (
      rental_price_value === "" ||
      isNaN(rental_price_value) ||
      Number(rental_price_value) <= 0
    ) {
      error_rental_price.textContent = "Price must be a positive number.";
      error_rental_price.style.color = "red";
      rental_price.style.border = "2px solid red";
      isValid = false;
    } else {
      error_rental_price.textContent = "";
      rental_price.style.border = "";
    }

    // ADDRESS
    if (address_value.length < 5) {
      error_address.textContent = "Address must be at least 5 characters.";
      error_address.style.color = "red";
      address.style.border = "2px solid red";
      isValid = false;
    } else {
      error_address.textContent = "";
      address.style.border = "";
    }

    // BEDS
    if (
      !beds_value ||
      !Number.isInteger(Number(beds_value)) ||
      Number(beds_value) < 0 ||
      Number(beds_value) > 20
    ) {
      error_beds.textContent = "Beds must be an integer between 0 and 20.";
      error_beds.style.color = "red";
      beds.style.border = "2px solid red";
      isValid = false;
    } else {
      error_beds.textContent = "";
      beds.style.border = "";
    }

    // BATHROOM
    if (
      !bathroom_value ||
      !Number.isInteger(Number(bathroom_value)) ||
      Number(bathroom_value) < 0 ||
      Number(bathroom_value) > 20
    ) {
      error_bathroom.textContent =
        "Bathroom must be an integer between 0 and 20.";
      error_bathroom.style.color = "red";
      bathroom.style.border = "2px solid red";
      isValid = false;
    } else {
      error_bathroom.textContent = "";
      bathroom.style.border = "";
    }

    // SQUARE METERS
    if (
      !square_meters_value ||
      !Number.isInteger(Number(square_meters_value)) ||
      Number(square_meters_value) < 1
    ) {
      error_square_meters.textContent =
        "Square meters must be a positive integer.";
      error_square_meters.style.color = "red";
      square_meters.style.border = "2px solid red";
      isValid = false;
    } else {
      error_square_meters.textContent = "";
      square_meters.style.border = "";
    }

    // ROOMS
    if (
      !rooms_value ||
      !Number.isInteger(Number(rooms_value)) ||
      Number(rooms_value) < 1 ||
      Number(rooms_value) > 20
    ) {
      error_rooms.textContent = "Rooms must be an integer between 1 and 20.";
      error_rooms.style.color = "red";
      rooms.style.border = "2px solid red";
      isValid = false;
    } else {
      error_rooms.textContent = "";
      rooms.style.border = "";
    }

    // FLOOR
    if (
      !floor_value ||
      !Number.isInteger(Number(floor_value)) ||
      Number(floor_value) < -5 ||
      Number(floor_value) > 50
    ) {
      error_floor.textContent = "Floor must be an integer between -5 and 50.";
      error_floor.style.color = "red";
      floor.style.border = "2px solid red";
      isValid = false;
    } else {
      error_floor.textContent = "";
      floor.style.border = "";
    }

    // FURNISHED
    if (furnished_value === "") {
      error_furnished.textContent =
        "Please specify if the property is furnished.";
      error_furnished.style.color = "red";
      furnished.style.border = "2px solid red";
      isValid = false;
    } else {
      error_furnished.textContent = "";
      furnished.style.border = "";
    }

    // HEATING TYPE
    if (heating_type_value === "") {
      error_heating_type.textContent = "Please select a heating type.";
      error_heating_type.style.color = "red";
      heating_type.style.border = "2px solid red";
      isValid = false;
    } else {
      error_heating_type.textContent = "";
      heating_type.style.border = "";
    }

    if (!isValid) {
      event.preventDefault();
    }
  });

  // Clear errors on input
  [
    [image, error_image],
    [image_url, error_image_url],
    [title, error_title],
    [description, error_description],
    [city, error_city],
    [property_type, error_property_type],
    [listing_type, error_listing_type],
    [rental_price, error_rental_price],
    [address, error_address],
    [beds, error_beds],
    [bathroom, error_bathroom],
    [square_meters, error_square_meters],
    [rooms, error_rooms],
    [floor, error_floor],
    [furnished, error_furnished],
    [heating_type, error_heating_type],
  ].forEach(([field, errorField]) => {
    field.addEventListener("input", () => {
      errorField.textContent = "";
      field.style.border = "";
    });
  });
});
