<?php
$selectedColors = [];
if (isset($_GET['selectedColor'])) {
    $selectedColors = json_decode($_GET['selectedColor'], true);
    error_log('Received colors: ' . print_r($selectedColors, true));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Fonts</title>
  <!-- Add Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Helvetica+Neue&family=Roboto&family=Open+Sans&family=Georgia&family=Times+New+Roman&family=Garamond&family=Playfair+Display&family=Montserrat&family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="test.css" />
  <style>
    <?php if (!empty($selectedColors)): ?>
    .preview-card {
      background-color: <?php echo htmlspecialchars($selectedColors[0]); ?>;
    }
    .preview-text h2 {
      color: <?php echo htmlspecialchars($selectedColors[1]); ?>;
    }
    .preview-text p {
      color: <?php echo htmlspecialchars($selectedColors[2]); ?>;
    }
    .learn-more {
      background-color: <?php echo htmlspecialchars($selectedColors[1]); ?>;
      color: <?php echo htmlspecialchars($selectedColors[0]); ?> !important;
    }
    .learn-more:hover {
      background-color: <?php echo htmlspecialchars($selectedColors[2]); ?>;
    }
    <?php endif; ?>

    /* Font selection styles */
    .font-option {
      cursor: pointer;
      transition: all 0.2s ease;
      padding: 1rem;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-bottom: 0.5rem;
    }
    
    .font-option.selected {
      background-color: #f0f0f0;
      border: 2px solid #333;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Font preview styles */
    .font-preview {
      font-size: 1.1rem;
      line-height: 1.5;
      margin-top: 0.5rem;
    }

    /* Preview card text styles */
    .preview-text h2,
    .preview-text p {
      transition: font-family 0.3s ease;
    }
  </style>
</head>
<body class="fonts-preview">
  <div class="container">
    <div class="left-panel">
      <div class="site-preview">
        <div class="preview-container colors-preview">
          <div class="preview-card">
            <div class="preview-main">
              <img src="images/250x200.jpg" alt="Preview" class="preview-image"/>
              <div class="preview-text">
                <h2 class="pv-text">More about our brand</h2>
                <p class="pv-text">
                  Inform individuals about your identity, the place from which you originate,
                  the methodology you employ in your work, or the sources of inspiration that drive you.
                  You have the capability to do this.
                </p>
                <button class="learn-more">LEARN MORE</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="right-panel">
      <div class="header">
        <div class="logo">Placeholder</div>
        <form action="../Get Started/get_Started.php" method="get">
          <button type="submit" class="close">✕</button>
        </form>
      </div>

      <div class="content">
        <h1>Choose your fonts</h1>
        <p class="subtext">Select the fonts that best represent your brand's personality. You can always change them later.</p>

        <div class="font-options">
          <!-- Modern -->
          <div class="font-set">
            <div class="font-title">Modern</div>
            <div class="font-group">
              <div class="font-option" data-font="helvetica">
                <span class="font-name">Helvetica Neue</span>
                <span class="font-preview font-helvetica">The quick brown fox jumps over the lazy dog</span>
              </div>
              <div class="font-option" data-font="roboto">
                <span class="font-name">Roboto</span>
                <span class="font-preview font-roboto">The quick brown fox jumps over the lazy dog</span>
              </div>
              <div class="font-option" data-font="opensans">
                <span class="font-name">Open Sans</span>
                <span class="font-preview font-opensans">The quick brown fox jumps over the lazy dog</span>
              </div>
            </div>
          </div>

          <!-- Classic -->
          <div class="font-set">
            <div class="font-title">Classic</div>
            <div class="font-group">
              <div class="font-option" data-font="georgia">
                <span class="font-name">Georgia</span>
                <span class="font-preview font-georgia">The quick brown fox jumps over the lazy dog</span>
              </div>
              <div class="font-option" data-font="times">
                <span class="font-name">Times New Roman</span>
                <span class="font-preview font-times">The quick brown fox jumps over the lazy dog</span>
              </div>
              <div class="font-option" data-font="garamond">
                <span class="font-name">Garamond</span>
                <span class="font-preview font-garamond">The quick brown fox jumps over the lazy dog</span>
              </div>
            </div>
          </div>

          <!-- Creative -->
          <div class="font-set">
            <div class="font-title">Creative</div>
            <div class="font-group">
              <div class="font-option" data-font="playfair">
                <span class="font-name">Playfair Display</span>
                <span class="font-preview font-playfair">The quick brown fox jumps over the lazy dog</span>
              </div>
              <div class="font-option" data-font="montserrat">
                <span class="font-name">Montserrat</span>
                <span class="font-preview font-montserrat">The quick brown fox jumps over the lazy dog</span>
              </div>
              <div class="font-option" data-font="poppins">
                <span class="font-name">Poppins</span>
                <span class="font-preview font-poppins">The quick brown fox jumps over the lazy dog</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="progress-container">
        <div class="progress-bar">
          <div class="step done">Site Info</div>
          <div class="step done">Homepage</div>
          <div class="step done">Pages</div>
          <div class="step done">Colors</div>
          <div class="step active">Fonts</div>
        </div>
      </div>

      <div class="button-container">
        <form action="colors.php" method="get">
          <button type="submit" class="button-back">BACK</button>
        </form>
        <form action="/CMS/CMS/CMSTestProj/Build Template/builder/builder.html" method="get" id="fontForm">
          <input type="hidden" name="selectedFont" id="selectedFont" value="">
          <input type="hidden" name="selectedColor" value="<?php echo htmlspecialchars($_GET['selectedColor'] ?? ''); ?>">
          <button type="submit" class="button-next">NEXT</button>
        </form>
      </div>
    </div>
  </div>

  <script src="scripts.js"></script>
</body>
</html>
