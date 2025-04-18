<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pages</title>
  <link rel="stylesheet" href="siteinfo.css" />
</head>
<body class="page-pages">
  <div class="container">
    <div class="left-panel">
      <div class="carousel-wrapper">
        <div class="carousel-controls">
          <button id="carousel-prev">←</button>
          <span id="carousel-title">Selected Pages</span>
          <button id="carousel-next">→</button>
        </div>

        <div class="carousel-container" id="carousel-container"></div>
      </div>
    </div>

    <div class="right-panel">
      <div class="header">
        <div class="logo">Placeholder</div>
        <div class="close">✕</div>
      </div>

      <div class="content">
        <h1>Add pages to your site</h1>
        <p class="subtext">We recommend starting with these, but you can always add or remove pages later.</p>

        <div class="section-options">
          <label><input type="checkbox" value="about"> About</label>
          <label><input type="checkbox" value="contact"> Contact</label>
          <label><input type="checkbox" value="shop"> Shop</label>
          <label><input type="checkbox" value="services"> Services</label>
          <label><input type="checkbox" value="appointments"> Appointments</label>
          <label><input type="checkbox" value="course"> Course</label>
        </div>        
      </div>

      <div class="progress-container">
        <div class="progress-bar">
          <div class="step done">Site Info</div>
          <div class="step done">Homepage</div>
          <div class="step active">Pages</div>
          <div class="step">Colors</div>
          <div class="step">Fonts</div>
        </div>
      </div>

      <div class="button-container">
        <a href="homepage.php" class="button-back">BACK</a>
        <a href="colors.html" class="button-next">NEXT</a>
      </div>
    </div>
  </div>

  <script src="scripts.js"></script>
</body>
</html>
