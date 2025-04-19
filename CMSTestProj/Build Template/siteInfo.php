<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Site Info</title>
  <link rel="stylesheet" href="siteinfo.css" />
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

      <div class="content">
        <h1>Choose a site title</h1>
        <div class="form-group">
          <label for="site-title">Site title</label>
          <div class="note">This is the name of your site. You can change it later.</div>
          <input type="text" id="site-title" placeholder="Your site title" maxlength="100" />
        </div>
      </div>

      <div class="progress-container">
        <div class="progress-bar">
          <div class="step active">Site Info</div>
          <div class="step">Homepage</div>
          <div class="step">Pages</div>
          <div class="step">Colors</div>
          <div class="step">Fonts</div>
        </div>
      </div>

      <div class="button-container">
      <a href="homepage.php" class="button-next">NEXT</a>
      </div>
    </div>
  </div>

  <script src="scripts.js"></script>
</body>
</html>
