<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Gallery</title>
  <link rel="stylesheet" href="gallery.css" />
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Your Gallery</h1>
      <a href="get_Started.php"><button class="back-btn">BACK</button></a>
    </div>

    <div class="gallery">
      <h2>Recently Opened</h2>
      <div class="gallery-grid animated fade-in">
        <div class="gallery-item placeholder"><span>Recent Work 1</span></div>
        <div class="gallery-item placeholder"><span>Recent Work 2</span></div>
        <div class="gallery-item placeholder"><span>Recent Work 3</span></div>
        <div class="gallery-item placeholder"><span>Recent Work 4</span></div>
        <div class="gallery-item placeholder"><span>Recent Work 5</span></div>
        <div class="gallery-item placeholder"><span>Recent Work 6</span></div>
      </div>

      <h2>All Works by Date Created</h2>
      <div class="gallery-grid animated fade-in">
        <div class="gallery-item placeholder"><span>Work Title A</span></div>
        <div class="gallery-item placeholder"><span>Work Title B</span></div>
        <div class="gallery-item placeholder"><span>Work Title C</span></div>
        <div class="gallery-item placeholder"><span>Work Title D</span></div>
        <div class="gallery-item placeholder"><span>Work Title E</span></div>
        <div class="gallery-item placeholder"><span>Work Title F</span></div>
      </div>

      <a href="../Build Template/site.php"><button class="action-btn">Upload New Work</button></a>
    </div>
  </div>
</body>
</html>
