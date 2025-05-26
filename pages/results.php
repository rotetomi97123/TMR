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

    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
 
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon" />
  </head>
  <body>
    <?php include '../includes/header.php'; ?>
      <div class="result_bg">
        <div class="result_wrapper">
          <form id="searchForm" class="searchForm">
            <div class="radio_wrapper"> 
              <label class="radio-label">
                <input type="radio" name="option" value="rent" checked  />
                <div class="radio-text">Rent</div>
              </label>
              <label class="radio-label">
                <input type="radio" name="option" value="buy" />
                <div class="radio-text">Buy</div>
              </label>     
            </div>
            <div class="form-group-flex">
              <div class="form-group">
                <label for="location">Location</label>
                <select id="location" class="form_input">
                </select>
              </div>
              
              <div class="form-group">
                <label for="date">When</label>
                <input type="date" id="date" class="form-input" />
              </div>
              <div class="form-group-submit">  
                <input type="submit" value="Browse properties" class="form-submit" />
              </div>

            </div>
          </form>
        </div>
        <div id="results">Loading...</div>
      </div>

    <script src="../js/result.js"></script>

  </body>
  </html>
