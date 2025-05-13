<?php

session_start();
if (!isset($_SESSION['user_id'])) {
   
    header("Location: ../index.php?login=required");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Site Info</title>
  <link rel="stylesheet" href="test.css" />
</head>
<body>
  <div class="container">

    <div class="left-panel">
      <div class="scroll-text text1">Your Site Title Your Site Title Your Site Title</div>
      <div class="scroll-text text2">Your Site Title Your Site Title Your Site Title</div>
      <div class="scroll-text text3">Your Site Title Your Site Title Your Site Title</div>
      <div class="scroll-text text4">Your Site Title Your Site Title Your Site Title</div>
    </div>
    
    <div class="right-panel">

      <div class="header">
        <div class="logo">Placeholder</div>
        <a href="../Get Started/get_Started.php">
          <div class="close">✕</div>
        </a>
      </div>

    <div class="right-inner">
       <div class="content">
          <h1>Choose a site title</h1>
           <form id="submit_input" method="POST" action="save_preferences.php">
              <div class="form-group">
                <label for="site-title">Site title</label>
              <div class="note">This is the name of your site. You can change it later.</div>
            <input type="text" id="site-title" name="site_title" placeholder="Your site title" maxlength="100" required />
            </form>
       </div>
    </div>

    <div class="footer">
      <div class="progress-container">
        <div class="progress-bar">
          <div class="step active">Site Info</div>
          <div class="step">Homepage</div>
          <div class="step">Pages</div>
          <div class="step">Colors</div>
          <div class="step">Fonts</div>
        </div>
      </div>
    </div>

      <div class="button-container">
        
            <button type="submit" form="submit_input"class="button-next">NEXT</button>

          </div>  
        </form>
      </div>

    </div>
    
  </div>

  <script src="scripts.js"></script>
</body>
</html>
