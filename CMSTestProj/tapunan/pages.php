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
        console.log('Full Session:', <?php echo json_encode($_SESSION); ?>);
        console.groupEnd();
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Select Pages</title>
    <link rel="stylesheet" href="test.css" />
</head>
<body>
    <div class="container">
        <!-- Left Panel - Preview -->
        <div class="left-panel">
            <div class="left-content">
                <h1>Select your <span class="highlight">pages</span></h1>
                <p>Choose the pages you want to include in your website. Each page comes with its own set of features and functionality.</p>
            </div>
        </div>

        <!-- Right Panel - Selection -->
        <div class="right-panel">
            <div class="header">
                <div class="logo">Placeholder</div>
                <form action="../Get Started/get_Started.php" method="get">
                    <button type="submit" class="close">✕</button>
                </form>
            </div>
            <form id="pages_input" method="POST" action="save_preferences.php">
                
            <div class="content">
                <h1>Select Your Pages</h1>
                <p class="subtext">Choose the pages you want to include in your website</p>

                <div class="page-options">
                    <label class="page-option">
                        <input type="checkbox" name="pages_selected[]" value="about">
                        <div class="option-content">
                            <img src="images/about.jpg" alt="About">
                            <span>About</span>
                        </div>
                    </label>
                    <label class="page-option">
                        <input type="checkbox" name="pages_selected[]" value="contact">
                        <div class="option-content">
                            <img src="images/contact.jpg" alt="Contact">
                            <span>Contact</span>
                        </div>
                    </label>
                    <label class="page-option">
                        <input type="checkbox" name="pages_selected[]" value="shop">
                        <div class="option-content">
                            <img src="images/shop.jpg" alt="Shop">
                            <span>Shop</span>
                        </div>
                    </label>
                    <label class="page-option">
                        <input type="checkbox" name="pages_selected[]" value="services">
                        <div class="option-content">
                            <img src="images/services.jpg" alt="Services">
                            <span>Services</span>
                        </div>  
                    </label>
                    <label class="page-option">
                        <input type="checkbox" name="pages_selected[]"  value="appointments">
                        <div class="option-content">
                            <img src="images/appointments.jpg" alt="Appointments">
                            <span>Appointments</span>
                        </div>
                    </label>
                    <label class="page-option">
                        <input type="checkbox" name="pages_selected[]"  value="course">
                        <div class="option-content">
                            <img src="images/course.jpg" alt="Course">
                            <span>Course</span>
                        </div>
                    </label>
                </div>
            </div>
            </form>

            <div class="progress-container">
                <div class="progress-bar">
                    <div class="step done">Site Info</div>
                    <div class="step done">Homepage</div>
                    <div class="step active">Pages</div>
                    <div class="step">Colors</div>
                    <div class="step">Fonts</div>
                </div>
            </div>

            <div class="button-container">
                <form action="homepage.php" method="get">
                    <button type="submit" class="button-back">BACK</button>
                </form>
                
                    <button type="submit" form="pages_input"class="button-next">NEXT</button>
               
            </div>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
