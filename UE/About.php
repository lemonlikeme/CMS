<?php
// PHP logic can be added here if needed
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>University of the East – Let Your Tomorrow Begin in the East.</title>
    <meta name="description" content="The University of the East (UE) is a private, non-sectarian university in Manila. Home of topnotchers and achievers.">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        a {
            text-decoration: none;
            color: #0073e6;
        }

        a:hover {
            text-decoration: underline;
        }

        h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
        }

        /* Header Styles */
        header {
            background-color: rgb(247, 42, 49);
            padding: 10px 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        header .logo img {
            height: 50px;
        }

        nav {
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: flex-end;
        }

        nav ul li {
            position: relative;
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            padding: 10px;
            display: block;
        }

        nav ul li ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #9f1015;
            padding: 10px;
            z-index: 1000;
        }

        nav ul li:hover ul {
            display: block;
        }

        nav ul li ul li {
            margin: 0;
        }

        nav ul li ul li a {
            white-space: nowrap;
        }

        /* Main Content Styles */
        main {
            padding: 20px;
            background-color: #fff;
            margin: 20px auto;
            max-width: 1200px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #9f1015;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Button Styles */
        .button {
            background-color: #9f1015;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 10px 0;
            display: inline-block;
            text-align: center;
        }
        
        .buttons {
            display: flex; /* Enables Flexbox */
            justify-content: center; /* Horizontal Centering */
            align-items: center; /* Vertical Centering (Optional) */
            gap: 10px; /* Optional - adds spacing between buttons */
            text-align: center; /* Align text inside buttons if needed */
        }
        .btn {
            background-color: #9f1015;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 10px 0;
            display: inline-block;
            text-align: center;
        }


        .button:hover {
            background-color: #7a0c0e;
        }

        /* Footer Styles */
        footer {
            background-color: rgb(255, 47, 47);
            color: #fff;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .footer-section {
            flex: 1;
            margin: 10px;
            min-width: 200px;
        }

        .footer-section img {
            height: 40px;
            margin-bottom: 10px;
        }

        .footer-section h3 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 5px;
        }

        .footer-section ul li a {
            color: #fff;
        }

        .copyright {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #444;
            position: relative;
            z-index: 1;
        }

        /* Marquee Container */
        .marquee {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: transparent;
            z-index: 0;
            overflow: hidden;
        }

        /* Marquee Text */
        .marquee span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 10s linear infinite;
            color: #fff;
            font-size: 16vw;
            opacity: 0.2;
            white-space: nowrap;
            line-height: 1.5;
        }

        /* Marquee Animation */
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        .welcome-text {
            flex: 3;
        }

        .welcome-video {
            flex: 2;
            max-width: 40%;
        }

        .welcome-video iframe {
            width: 100%;
            height: auto;
            aspect-ratio: 16 / 9;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="cc-1m2mf" aria-label="Open chat (non-functional)">
            <span class="cc-6lwfw"></span>
            <span class="cc-157aw cc-1kgzy" data-has-unread="false">
                <span data-prefer-search="false" data-id="chat_opened" class="cc-d73fc" data-is-ongoing="false">
                    <span class="cc-1bvfm"></span>
                    <span class="cc-i0mv8"></span>
                </span>
            </span>
        </div>

        <nav>
            <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="About.php">Contact</a></li>
                <li><a href="Welcome.php">Welcome Note</a></li>
                <li><a href="UE-Hymn.php">UE Hymn </a></li>
                <li><a href="Prospective Students.php">Campus Tour</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="logo">
            <img src="https://www.ue.edu.ph/mla/wp-content/uploads/2020/07/ue_name_shadowed-1.png" alt="University of the East Logo">
        </div>

        <?php echo '<h1>Phone Directory</h1>'; ?>
        <hr style="height: 1px; border-width: 0; color: gray; background-color: gray;">
        <div class="buttons">
            <?php
            echo '<a class="btn" href="https://www.ue.edu.ph/cal/telephone-directory/">Caloocan Campus Phone Directory</a>';
            echo '<a class="btn" href="https://www.ue.edu.ph/mla/email-directory/">Email Directory</a>';
            ?>
        </div>
        <?php
        echo '<h3 style="text-align: center;">Manila Campus<br>✆ Trunk line: (632) 8735-54-71<br>5328-5471</h3>';
        echo '<p style="text-align: center;"><i>2219 C.M. Recto Avenue, Brgy. 404, Zone 41, Sampaloc, Manila, Philippines</i></p>';
        ?>

        <!-- Department Table -->
        <table align="center">
            <thead>
                <tr>
                    <th class="table-head" align="center">DEPARTMENT</th>
                    <th class="table-head" align="center">LOCAL</th>
                    <th class="table-head" align="center">DIRECT LINE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo '<tr><td align="left">Admission</td><td align="left">loc 399 or 398</td><td align="left">8735-8577</td></tr>';
                echo '<tr><td colspan="3" align="left">Admission Mobile no.: 0961-568-2179 (Smart)</td></tr>';
                ?>
            </tbody>
        </table>

        <!-- Colleges Table -->
        <table align="center">
            <thead>
                <tr>
                    <th class="table-head" align="center">COLLEGES</th>
                    <th class="table-head" align="center">LOCAL</th>
                    <th class="table-head" align="center">DIRECT LINE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo '<tr><td align="left">College of Arts and Sciences</td><td align="left">loc 370</td><td align="left">8735-8539</td></tr>';
                echo '<tr><td align="left">College of Business Administration</td><td align="left">loc 354</td><td align="left">8735-8532</td></tr>';
                ?>
            </tbody>
        </table>

        <!-- Departments Table -->
        <table align="center">
            <thead>
                <tr>
                    <th class="table-head" align="center">DEPARTMENTS</th>
                    <th class="table-head" align="center">LOCAL</th>
                    <th class="table-head" align="center">DIRECT LINE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo '<tr><td align="left">Accounting</td><td align="left">loc 408</td><td align="left">8735-6977</td></tr>';
                echo '<tr><td align="left">Admission</td><td align="left">loc 399</td><td align="left">8735-8577</td></tr>';
                ?>
            </tbody>
        </table>

        <!-- Executive Office Table -->
        <table align="center">
            <thead>
                <tr>
                    <th class="table-head" align="center">EXECUTIVE OFFICE</th>
                    <th class="table-head" align="center">LOCAL</th>
                    <th class="table-head" align="center">DIRECT LINE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo '<tr><td align="left">President</td><td align="left">loc 307</td><td align="left">8735-6973</td></tr>';
                echo '<tr><td align="left">Senior Vice President</td><td align="left">loc 312</td><td align="left">8736-0546</td></tr>';
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <div class="marquee-background">
            <div class="marquee">
                <span>Let Your Tomorrow Begin in the East.</span>
            </div>
        </div>
        <div class="footer-content">
            <div class="footer-section">
                <img src="https://www.ue.edu.ph/cal/wp-content/uploads/2020/08/footer_name_ue.png" alt="UE Logo">
                <p>2219 C.M. Recto Avenue, Brgy. 404, Zone 41, Sampaloc, Manila, Philippines</p>
                <p>Trunklines:<br>
                ✆ Manila Campus (632) 8735-54-71 | 5328-5471<br>
                ✆ Caloocan Campus (632) 8367-45-72 | 5328 4572<br>
                ✆ UERMMMCI (632) 8715-08-61</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Phone Directory</a></li>
                    <li><a href="#">Email Directory</a></li>
                    <li><a href="#">Data Privacy Notice</a></li>
                    <li><a href="#">Disclaimer</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Academics</h3>
                <ul>
                    <li><a href="https://www.ue.edu.ph/mla/accreditation/">Accreditation</a></li>
                    <li><a href="https://www.ue.edu.ph/mla/quick-list-of-academic-programs/">Academic Programs</a></li>
                    <li><a href="https://www.ue.edu.ph/mla/souvenir-shop/">Souvenir Shop</a></li>
                    <li><a href="https://www.ue.edu.ph/mla/ue-colleges-logo/">UE/Colleges seal</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Admissions</h3>
                <ul>
                    <li><a href="https://www.ue.edu.ph/mla/admissions-brochure/">Brochure</a></li>
                    <li><a href="https://www.ue.edu.ph/mla/school-fees/">School Fees</a></li>
                    <li><a href="https://www.ue.edu.ph/mla/ue-forms/">UE Forms</a></li>
                    <li><a href="https://www.ue.edu.ph/mla/job-hiring/">Job Hiring</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>Copyright © 2025. University of the East., Philippines</p>
        </div>
    </footer>

    <script>
        // JavaScript for Carousel Functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel img');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove('active');
                if (i === index) {
                    slide.classList.add('active');
                }
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        // Automatically change slides every 5 seconds
        setInterval(nextSlide, 5000);

        // JavaScript for Dropdown Menus
        document.addEventListener('DOMContentLoaded', function () {
            const dropdowns = document.querySelectorAll('nav ul li');

            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('mouseenter', function () {
                    const submenu = this.querySelector('ul');
                    if (submenu) {
                        submenu.style.display = 'block';
                    }
                });

                dropdown.addEventListener('mouseleave', function () {
                    const submenu = this.querySelector('ul');
                    if (submenu) {
                        submenu.style.display = 'none';
                    }
                });
            });
        });

        // Smooth Scrolling for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Example: Add a class to the header on scroll
        window.addEventListener('scroll', function () {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>