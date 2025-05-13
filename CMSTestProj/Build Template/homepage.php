<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?login=required");
    exit();
}
?>
<script>
        console.group('Form Submission Data');
        console.log('Site Title:', <?php echo json_encode($_SESSION['site_title'] ?? 'Not set'); ?>);
        console.log('Submission Time:', <?php echo json_encode($_SESSION['submission_time'] ?? 'Not set'); ?>);
        console.log('Full Session:', <?php echo json_encode($_SESSION); ?>);
        console.groupEnd();
    </script>


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
        <form id="homepage_input" method="POST" action="save_preferences.php">
          <div class="section-options">
              <label><input type="checkbox" name="homepage_sections[]" value="intro"> Intro section</label>
              <label><input type="checkbox" name="homepage_sections[]" value="products"> Products section</label>
              <label><input type="checkbox" name="homepage_sections[]" value="services"> Services section</label>
              <label><input type="checkbox" name="homepage_sections[]" value="appointments"> Appointments section</label>
              <label><input type="checkbox" name="homepage_sections[]" value="digital"> Digital Products section</label>
              <label><input type="checkbox" name="homepage_sections[]" value="about"> About section</label>
           
          </div>
           </form>
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
       
          <button type="submit" form="homepage_input" class="button-next">NEXT</button>
        
      </div>
    </div>
  </div>

  <script src="scripts.js"></script>
</body>
</html>
