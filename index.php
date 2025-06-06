<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>StanoviSrbije</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="./css/styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
    />
    <link rel="icon" href="./assets/favicon.ico" type="image/x-icon" />
  </head>
  <body>
    <?php include 'includes/header.php'; ?>
    
  <div class="hero_bg">
    <div class="hero_wrapper">
    <?php include 'includes/banner_form.php'; ?>
      <div class="featured_properties">
        <div class="property_showcase"></div>
        <div class="showcase_dots"></div>
      <button id="prevArrow" class="property_arrow prev_arrow" aria-label="Previous">
        <i class="bi bi-chevron-left"></i>
      </button>
      <button id="nextArrow" class="property_arrow next_arrow" aria-label="Next">
        <i class="bi bi-chevron-right"></i>
      </button>
      </div>
    </div>
  </div>
    <?php include 'includes/newhome.php'; ?>
    <?php require_once 'includes/config.php'; ?>
      <script>
        const BASE_URL = "<?= $base_url ?>";
      </script>
    <script src="js/navbar.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
