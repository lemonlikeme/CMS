
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
        console.log('Homepage Sections (array):', <?php echo json_encode($_SESSION['homepage_sections'] ?? 'Not set'); ?>);
        console.log('Homepage Sections (string):', <?php echo json_encode($_SESSION['homepage_sections_string'] ?? 'Not set'); ?>);
        console.log('Pages Selected (array):', <?php echo json_encode($_SESSION['pages_selected'] ?? 'Not set'); ?>);
        console.log('Pages Selected (string):', <?php echo json_encode($_SESSION['pages_selected_string'] ?? 'Not set'); ?>); 
 
        console.log('Full Session:', <?php echo json_encode($_SESSION); ?>);
        console.groupEnd();
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Colors</title>
  <link rel="stylesheet" href="test.css" />
</head>
<body class="colors-preview">
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
        <h1>Choose a color palette</h1>
        <p class="subtext">These custom palettes were curated by our designers. You can always change up your colors later.</p>
        <form id="color_input" method="POST" action="save_preferences.php">
          <div class="palette-grid">
            <!-- Professional -->
            <div class="palette-set">
              <div class="palette-title">Professional</div>
              <div class="palette-group">
                <div class="palette">
                  <input type="radio" name="selected_palette" value="professional1" style="display:none;">
                  <div class="palette-color" style="background: #ffffff;"></div>
                  <div class="palette-color" style="background: #2c3e50;"></div>
                  <div class="palette-color" style="background: #34495e;"></div>
                </div>
                <div class="palette">
                  <input type="radio" name="selected_palette" value="professional2" style="display:none;">
                  <div class="palette-color" style="background: #f8f9fa;"></div>
                  <div class="palette-color" style="background: #1a237e;"></div>
                  <div class="palette-color" style="background: #0d47a1;"></div>
                </div>
                <div class="palette">
                  <input type="radio" name="selected_palette" value="professional3" style="display:none;">
                  <div class="palette-color" style="background: #f5f5f5;"></div>
                  <div class="palette-color" style="background: #263238;"></div>
                  <div class="palette-color" style="background: #37474f;"></div>
                </div>
              </div>
            </div>

            <!-- Playful -->
            <div class="palette-set">
              <div class="palette-title">Playful</div>
              <div class="palette-group">
                <div class="palette">
                  <input type="radio" name="selected_palette" value="playful1" style="display:none;">
                  <div class="palette-color" style="background: #fff8e1;"></div>
                  <div class="palette-color" style="background: #ff6f00;"></div>
                  <div class="palette-color" style="background: #bf360c;"></div>
                </div>
                <div class="palette">
                <input type="radio" name="selected_palette" value="playful2" style="display:none;">
                  <div class="palette-color" style="background: #e8f5e9;"></div>
                  <div class="palette-color" style="background: #2e7d32;"></div>
                  <div class="palette-color" style="background: #1b5e20;"></div>
                </div>
                <div class="palette">
                <input type="radio" name="selected_palette" value="playful3" style="display:none;">
                  <div class="palette-color" style="background: #e3f2fd;"></div>
                  <div class="palette-color" style="background: #1565c0;"></div>
                  <div class="palette-color" style="background: #0d47a1;"></div>
                </div>
              </div>
            </div>

            <!-- Sophisticated -->
            <div class="palette-set">
              <div class="palette-title">Sophisticated</div>
              <div class="palette-group">
                <div class="palette">
                  <input type="radio" name="selected_palette" value="sophisticated1" style="display:none;">
                  <div class="palette-color" style="background: #fafafa;"></div>
                  <div class="palette-color" style="background: #424242;"></div>
                  <div class="palette-color" style="background: #212121;"></div>
                </div>
                <div class="palette">
                  <input type="radio" name="selected_palette" value="sophisticated2" style="display:none;">
                  <div class="palette-color" style="background: #f5f5f5;"></div>
                  <div class="palette-color" style="background: #455a64;"></div>
                  <div class="palette-color" style="background: #263238;"></div>
                </div>
                <div class="palette">
                  <input type="radio" name="selected_palette" value="sophisticated3" style="display:none;">
                  <div class="palette-color" style="background: #fafafa;"></div>
                  <div class="palette-color" style="background: #3e2723;"></div>
                  <div class="palette-color" style="background: #1b0000;"></div>
                </div>
              </div>
            </div>

            <!-- Friendly -->
            <div class="palette-set">
              <div class="palette-title">Friendly</div>
              <div class="palette-group">
                <div class="palette">
                  <input type="radio" name="selected_palette" value="friendly1" style="display:none;">
                  <div class="palette-color" style="background: #e8f5e9;"></div>
                  <div class="palette-color" style="background: #43a047;"></div>
                  <div class="palette-color" style="background: #1b5e20;"></div>
                </div>
                <div class="palette">
                  <input type="radio" name="selected_palette" value="friendly2" style="display:none;">
                  <div class="palette-color" style="background: #fff3e0;"></div>
                  <div class="palette-color" style="background: #e65100;"></div>
                  <div class="palette-color" style="background: #bf360c;"></div>
                </div>
                <div class="palette">
                  <input type="radio" name="selected_palette" value="friendly3" style="display:none;">
                  <div class="palette-color" style="background: #e3f2fd;"></div>
                  <div class="palette-color" style="background: #1976d2;"></div>
                  <div class="palette-color" style="background: #0d47a1;"></div>
                </div>
              </div>
            </div>

            <!-- Bold -->
            <div class="palette-set">
              <div class="palette-title">Bold</div>
              <div class="palette-group">
                <div class="palette">
                  <input type="radio" name="selected_palette" value="bold1" style="display:none;">
                  <div class="palette-color" style="background: #ffffff;"></div>
                  <div class="palette-color" style="background: #d32f2f;"></div>
                  <div class="palette-color" style="background: #b71c1c;"></div>
                </div>
                <div class="palette">
                  <input type="radio" name="selected_palette" value="bold2" style="display:none;">
                  <div class="palette-color" style="background: #f5f5f5;"></div>
                  <div class="palette-color" style="background: #6a1b9a;"></div>
                  <div class="palette-color" style="background: #4a148c;"></div>
                </div>
                <div class="palette">
                  <input type="radio" name="selected_palette" value="bold3" style="display:none;">
                  <div class="palette-color" style="background: #fafafa;"></div>
                  <div class="palette-color" style="background: #c2185b;"></div>
                  <div class="palette-color" style="background: #880e4f;"></div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="progress-container">
        <div class="progress-bar">
          <div class="step done">Site Info</div>
          <div class="step done">Homepage</div>
          <div class="step done">Pages</div>
          <div class="step active">Colors</div>
          <div class="step">Fonts</div>
        </div>
      </div>

      <div class="button-container">
        <form action="pages.php" method="get">
          <button type="submit" class="button-back">BACK</button>
        </form>
          <button type="submit" form="color_input" class="button-next">NEXT</button>
      </div>
    </div>
  </div>

  <script src="scripts.js"></script>
  <script src="../jscripts/bTcolor.js" defer></script>
</body>
<script>document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('.palette').forEach(palette => {
    palette.addEventListener('click', function() {
      const radio = this.querySelector('input[type="radio"]');
      if (radio) {
        radio.checked = true;
        console.log('Palette selected:', radio.value); 
      }
      document.querySelectorAll('.palette').forEach(p => p.classList.remove('selected'));
      
      this.classList.add('selected');
    });
  });
});
</script>
</html>
