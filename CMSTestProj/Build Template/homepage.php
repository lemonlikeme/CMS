<?php
// You can add any necessary PHP logic here (like session management if needed)
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Homepage</title>
  <link rel="stylesheet" href="test.css" />
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
      <!-- Header -->
      <div class="header">
        <div class="logo">Placeholder</div>
        <form action="../Get Started/get_Started.php" method="get">
          <button type="submit" class="close">✕</button>
        </form>
      </div>

      <!-- Main Content -->
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

      <!-- Progress Bar -->
      <div class="progress-container">
        <div class="progress-bar">
          <div class="step done">Site Info</div>
          <div class="step active">Homepage</div>
          <div class="step">Pages</div>
          <div class="step">Colors</div>
          <div class="step">Fonts</div>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <div class="button-container">
        <form action="site.php" method="get">
          <button type="submit" class="button-back">BACK</button>
        </form>
        <form action="pages.php" method="get">
          <button type="submit" class="button-next">NEXT</button>
        </form>
      </div>
    </div>
  </div>

  <script src="scripts.js"></script>
</body>
</html>
