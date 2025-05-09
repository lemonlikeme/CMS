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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
          <img src="" alt="Placeholder" class="logo" />
          <a href="../index.php">
          <button class="close-btn">CLOSE</button>
          </a>
        </div>
      
        <div class="step-info">
          <h1>How would you like to start building your website?</h1>
        </div>
      
        <div class="options">
          <div class="option-card">
            <img src="template1.jpg" alt="Designer Templates" class="preview" />
            <h2>Designer Templates</h2>
            <p>Choose from a curated set of professionally designed website templates.</p>
            <button class="action-btn">Choose a Template</button>
          </div>
      
          <div class="option-card">
            <img src="template2.jpg" alt="Blueprint AI" class="preview" />
            <h2>Blueprint AI</h2>
            <p>Build a custom website guided by Placeholder.</p>
            <a href="../Build Template/site.php">
            <button class="action-btn">Build a Template</button>
            </a>
          </div>
        </div>
      
        <a href="../index.php">
          <button class="action-btn">BACK</button>
        </a>
      </div>
</body>
</html>