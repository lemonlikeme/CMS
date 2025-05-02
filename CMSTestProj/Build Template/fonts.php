<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Fonts</title>
  <link rel="stylesheet" href="../Build Template/siteinfo.css" />
</head>
<body class="page-fonts">

  <div class="container">
    
    <div class="left-panel">
      <div class="site-preview">
        <div class="preview-container">
          <div class="preview-card">
            <div class="preview-main">
              <img src="../images/250x200.jpg" alt="Preview" class="preview-image" />
              <div class="preview-text">
                <h2>More about our brand</h2>
                <p>
                  Inform individuals about your identity, the place from which you originate,<br>
                  the methodology you employ in your work, or the sources of inspiration that drive you.<br>
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
        <div class="close">✕</div>
      </div>

      <div class="content">
        <h1>Choose a font</h1>
        <p class="subtext">These custom fonts were curated by our designers. You can always change up your fonts later.</p>

        <div class="font-grid">

          <div class="font-set">
            <div class="font-title">Professional</div>
            <div class="font-group">
              <div class="font" onclick="changeFont('Arial')">
                <div class="font-preview" style="font-family: 'Arial', sans-serif;">Arial</div>
              </div>
              <div class="font" onclick="changeFont('Helvetica')">
                <div class="font-preview" style="font-family: 'Helvetica', sans-serif;">Helvetica</div>
              </div>
              <div class="font" onclick="changeFont('Times New Roman')">
                <div class="font-preview" style="font-family: 'Times New Roman', serif;">Times New Roman</div>
              </div>
            </div>
          </div>

          <div class="font-set">
            <div class="font-title">Playful</div>
            <div class="font-group">
              <div class="font" onclick="changeFont('Comic Sans MS')">
                <div class="font-preview" style="font-family: 'Comic Sans MS', cursive;">Comic Sans</div>
              </div>
              <div class="font" onclick="changeFont('Pacifico')">
                <div class="font-preview" style="font-family: 'Pacifico', cursive;">Pacifico</div>
              </div>
              <div class="font" onclick="changeFont('Lobster')">
                <div class="font-preview" style="font-family: 'Lobster', cursive;">Lobster</div>
              </div>
            </div>
          </div>

          <div class="font-set">
            <div class="font-title">Sophisticated</div>
            <div class="font-group">
              <div class="font" onclick="changeFont('Georgia')">
                <div class="font-preview" style="font-family: 'Georgia', serif;">Georgia</div>
              </div>
              <div class="font" onclick="changeFont('Garamond')">
                <div class="font-preview" style="font-family: 'Garamond', serif;">Garamond</div>
              </div>
              <div class="font" onclick="changeFont('Baskerville')">
                <div class="font-preview" style="font-family: 'Baskerville', serif;">Baskerville</div>
              </div>
            </div>
          </div>

          <div class="font-set">
            <div class="font-title">Friendly</div>
            <div class="font-group">
              <div class="font" onclick="changeFont('Poppins')">
                <div class="font-preview" style="font-family: 'Poppins', sans-serif;">Poppins</div>
              </div>
              <div class="font" onclick="changeFont('Quicksand')">
                <div class="font-preview" style="font-family: 'Quicksand', sans-serif;">Quicksand</div>
              </div>
              <div class="font" onclick="changeFont('Nunito')">
                <div class="font-preview" style="font-family: 'Nunito', sans-serif;">Nunito</div>
              </div>
            </div>
          </div>

          <div class="font-set">
            <div class="font-title">Bold</div>
            <div class="font-group">
              <div class="font" onclick="changeFont('Roboto')">
                <div class="font-preview" style="font-family: 'Roboto', sans-serif;">Roboto</div>
              </div>
              <div class="font" onclick="changeFont('Montserrat')">
                <div class="font-preview" style="font-family: 'Montserrat', sans-serif;">Montserrat</div>
              </div>
              <div class="font" onclick="changeFont('Oswald')">
                <div class="font-preview" style="font-family: 'Oswald', sans-serif;">Oswald</div>
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
        <a href="colors.php" class="button-back">BACK</a>
        <a href="#" class="button-next">NEXT</a>
      </div>
    </div> 

  </div> 

  <script src="scripts.js"></script>
  <script src="../jscripts/bTfont.js" defer></script>

</body>
</html>
