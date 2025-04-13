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
        .cc-1m2mf {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #ff4444; /* Red color */
            color: white;
            padding: 15px;
            border-radius: 50%;
            cursor: not-allowed; /* Indicates non-functionality */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000; /* Ensure it stays on top */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px; /* Size of the message icon */
        }
        .cc-1m2mf:hover {
            background-color: #cc0000; /* Darker red on hover */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }

        a {
            text-decoration: none;
            color: #0073e6;
        }

        a:hover {
            text-decoration: none;
        }

        /* Header Styles */
        header {
            background-color: rgb(247, 42, 49);
            padding: 10px 20px;
            display: flex;
            flex-direction: column; /* Stack nav and logo vertically */
            align-items: flex-end; /* Align items to the left */
        }

        header .logo img {
            height: 50px;
        }

        nav {
            width: 100%; /* Ensure nav takes full width */
            position: sticky; /* Make the nav sticky */
            top: 0; /* Stick to the top of the viewport */
            z-index: 1000; /* Ensure the nav stays above other content */
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: flex-end; /* Align nav items to the left */
            text-decoration: none; /* No underline */
        }

        nav ul li {
            position: relative;
            margin-right: 20px;
            text-decoration: none; /* No underline */
        }

        nav ul li a {
            color: #fff;
            padding: 10px;
            display: block;
            text-decoration: none; /* No underline */
        }

        nav ul li ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #9f1015;
            padding: 10px;
            z-index: 1000;
            text-decoration: none; /* No underline */
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
        }

        /* UE Hymn Section */
        .ue-hymn-section {
            background-color: #565656; /* Gray background */
            padding: 40px 20px;
            text-align: center;
        }

        .ue-hymn-bg {
            background-image: url('https://www.ue.edu.ph/mla/wp-content/uploads/2021/05/ue_hymn_bg_collage.jpg');
            background-size: cover; /* Ensures the background covers the element */
            background-position: center;
            background-repeat: no-repeat;
            
            width: 100%; /* Ensures it does not exceed the container width */
            max-width: 1200px; /* Adjust this value based on your website's layout */
            height: 100vh; /* Full viewport height */
            
            margin: 0 auto; /* Centers it horizontally */
            padding: 100px;
            border-radius: 10px;
            
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ue-hymn-lyrics {
            font-size: 18px;
            line-height: 1.8;
            color: #333;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            margin: 0 auto;
        }

        .ue-hymn-lyrics h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #d3475b; /* UE Red */
        }

        .ue-hymn-video {
            margin-top: 40px;
        }

        .ue-hymn-video iframe {
            width: 100%;
            max-width: 800px;
            height: 450px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Footer Styles */
        footer {
            background-color: rgb(255, 47, 47);
            color: #fff;
            padding: 20px;
            position: relative; /* Ensure marquee is positioned correctly */
            overflow: hidden; /* Hide overflowing marquee text */
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            position: relative; /* Ensure content is above marquee */
            z-index: 1; /* Place content above marquee */
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
            z-index: 1; /* Ensure copyright is above marquee */
        }

        /* Marquee Container */
        .marquee {
            position: absolute; /* Position marquee absolutely within footer */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: transparent; /* Remove background color */
            z-index: 0; /* Place marquee behind footer content */
            overflow: hidden;
        }

        /* Marquee Text */
        .marquee span {
            display: inline-block;
            padding-left: 100%; /* Start off-screen */
            animation: marquee 10s linear infinite;
            color: #fff;
            font-size: 16vw; /* Set font size to 8vw */
            opacity: 0.2; /* Set opacity to 50% */
            white-space: nowrap;
            line-height: 1.5; /* Adjust line height for better visibility */
        }

        /* Marquee Animation */
        @keyframes marquee {
            100% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
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

    <!-- UE Hymn Section -->
    <div class="ue-hymn-section">
        <div class="ue-hymn-bg">
            <div class="ue-hymn-lyrics">
                <h2><?php echo 'Pamantasan Ka Naming Mahal (UE Hymn)'; ?></h2>
                <?php echo '<p>Pamantasan ka naming mahal<br>
                Ilaw sa karimlan<br>
                Buhay, lakas, dunong, dangal<br>
                Pamantasan ka ng bayan.</p>'; ?>
                <?php echo '<p>Ang pangalan mo ay Lualhati<br>
                At sandigan ka ng lahi<br>
                Pamantasan ng Silangan<br>
                Pamantasan ka naming mahal.</p>'; ?>
            </div>
        </div>
        <div class="ue-hymn-video">
            <iframe src="https://www.youtube.com/embed/-ELvekcRLME" title="UE Hymn" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
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