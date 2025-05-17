<?php

session_start();
if (!isset($_SESSION['user_id'])) {
   
    header("Location: ../index.php?login=required");
    exit();
}

// Check if we're editing an existing template
$editing = false;
$template_id = '';

if (isset($_GET['page_id']) && !empty($_GET['page_id'])) {
    // We are editing an existing template
    $editing = true;
    $template_id = $_GET['page_id'];
    $_SESSION['current_template_id'] = $template_id;
} else {
    // Generate a new unique template ID
    $template_id = 'template_' . time() . '_' . uniqid();
    $_SESSION['current_template_id'] = $template_id;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo $editing ? 'Edit Template' : 'New Template'; ?></title>
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
              <input type="hidden" name="template_id" value="<?php echo htmlspecialchars($template_id); ?>">
              <div class="form-group">
                <label for="site-title">Site title</label>
                <div class="note">This is the name of your site. You can change it later.</div>
                <input type="text" id="site-title" name="site_title" placeholder="Your site title" maxlength="100" required />
              </div>
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
            <button type="submit" form="submit_input" class="button-next">NEXT</button>
      </div>

    </div>
    
  </div>  

  <script src="scripts.js"></script>
</body>
</html>
