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
    <link rel="icon" href="./assets/favicon.ico" type="image/x-icon" />
  </head>
  <body>
    
    <?php include 'includes/header.php'; ?>
    
    <div class="hero_wrapper">
      <div class="hero_wrapper_content">
        <h1>Buy, rent, or sell your property easily</h1>
        <p>A great platform to buy, sell, or even rent your properties without any commisions.</p>
        <div class="hero_wrapper_contentFlex">
          <div>
            <p><span>50k+</span></p>
            <p>renters</p>
          </div>
          <div>
            <p><span>10k+</span></p>
            <p>properties</p>
          </div>
        </div>
        <form id="searchForm" class="searchForm">
          <label class="radio-label">
            <input type="radio" name="option" value="rent" checked  />
            <div class="radio-text">Rent</div>
          </label>
          <label class="radio-label">
            <input type="radio" name="option" value="buy" />
            <div class="radio-text">Buy</div>
          </label>     
          <br>
          <div class="form-group-flex">
            <div class="form-group">
              <label for="location">Location</label>
              <input
              id="location"
              name="location"
              type="text"
              placeholder="Start typing your city..."
              autocomplete="off"
              class="form-input"
            />
          </div>
          
          <div class="form-group">
            <label for="date">When</label>
            <input type="date" id="date" class="form-input" />
          </div>
          <div class="form-group-submit">  
            <input type="submit" value="Browse properties" class="form-submit" />
          </div>
          
          <div id="suggestions" class="suggestions"></div>
        </div>
          </form>
      </div>
    </div>

    <div class="result"></div>
    <div id="listings"></div>
    <?php include 'includes/newhome.php'; ?>
    <script src="js/main.js"></script>
  </body>
</html>
