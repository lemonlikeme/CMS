
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Homepage</title>
  <link rel="stylesheet" href="siteinfo.css" />
</head>
<body>
  <div class="container">

    <div class="left-panel">
      <div class="left-content">
        <h1>Add <span class="highlight">sections</span> to build your homepage</h1>
        <p>Your homepage is the first impression — make it count by showing what your site is about and what you offer.</p>
      </div>
    </div>    

    <div class="right-panel">

      <div class="header">
        <div class="logo">Placeholder</div>
        <a href="../Get Started/get_Started.php">
        <div class="close">✕</div>
        </a>
      </div>

      <div class="content">
        <h1>Build your homepage</h1>
        <p class="subtext">Build your homepage section-by-section, adding as many or as few sections as you need.</p>
        <div class="section-options">
          <label><input type="checkbox" name="section-intro"> Intro section</label>
          <label><input type="checkbox" name="section-products"> Products section</label>
          <label><input type="checkbox" name="section-services"> Services section</label>
          <label><input type="checkbox" name="section-appointments"> Appointments section</label>
          <label><input type="checkbox" name="section-digital"> Digital Products section</label>
          <label><input type="checkbox" name="section-about"> About section</label>
        </div>        
      </div>

      <div class="progress-container">
        <div class="progress-bar">
          <div class="step done">Site Info</div>
          <div class="step active">Homepage</div>
          <div class="step">Pages</div>
          <div class="step">Colors</div>
          <div class="step">Fonts</div>
        </div>
      </div>

        <div class="button-container">
          <a href="siteInfo.php" class="button-back">BACK</a>
          <a href="pages.php" class="button-next">NEXT</a>
        </div>

      </div>
    </div>
  </div>

  <script src="scripts.js"></script>
</body>
</html>
