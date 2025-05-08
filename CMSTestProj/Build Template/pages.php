<?php
// You can add any necessary PHP logic here (like session management if needed)
?>

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

            <div class="content">
                <h1>Select Your Pages</h1>
                <p class="subtext">Choose the pages you want to include in your website</p>

                <div class="page-options">
                    <label class="page-option">
                        <input type="checkbox" value="about">
                        <div class="option-content">
                            <img src="images/about.jpg" alt="About">
                            <span>About</span>
                        </div>
                    </label>
                    <label class="page-option">
                        <input type="checkbox" value="contact">
                        <div class="option-content">
                            <img src="images/contact.jpg" alt="Contact">
                            <span>Contact</span>
                        </div>
                    </label>
                    <label class="page-option">
                        <input type="checkbox" value="shop">
                        <div class="option-content">
                            <img src="images/shop.jpg" alt="Shop">
                            <span>Shop</span>
                        </div>
                    </label>
                    <label class="page-option">
                        <input type="checkbox" value="services">
                        <div class="option-content">
                            <img src="images/services.jpg" alt="Services">
                            <span>Services</span>
                        </div>
                    </label>
                    <label class="page-option">
                        <input type="checkbox" value="appointments">
                        <div class="option-content">
                            <img src="images/appointments.jpg" alt="Appointments">
                            <span>Appointments</span>
                        </div>
                    </label>
                    <label class="page-option">
                        <input type="checkbox" value="course">
                        <div class="option-content">
                            <img src="images/course.jpg" alt="Course">
                            <span>Course</span>
                        </div>
                    </label>
                </div>
            </div>

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
                <form action="colors.php" method="get">
                    <button type="submit" class="button-next">NEXT</button>
                </form>
            </div>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
