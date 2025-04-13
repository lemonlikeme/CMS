    <?php
    $jsonFile = 'data.json';

    // Load data from the JSON file
    $content = [];
    if (file_exists($jsonFile)) {
        $content = json_decode(file_get_contents($jsonFile), true);
    }    
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
                color: var(--text-color, #333); /* Use the variable for text color */
                background-color: var(--background-color, #f4f4f4); /* Use the variable for background color */
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
                background-color:rgb(247, 42, 49);
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

            .welcome-section {
                padding: 50px 20px;
                background-color: #f4f4f4;
            }

            .welcome-content {
                display: flex;
                gap: 20px; /* Space between text and video */
                align-items: center; /* Vertically center align */
            }

            .welcome-section h1 {
                font-size: 2.5em;
                margin-bottom: 20px;
            }

            .welcome-section p {
                font-size: 1.2em;
                margin-bottom: 30px;
            }

            .welcome-section .button {
                background-color: #ff4444;
                color: rgb(0, 0, 0);
                padding: 10px 20px;
                border-radius: 5px;
                margin: 0 10px;
                border: 2px solid black;
                text-decoration: none; /* No underline */
                cursor: pointer; /* Add pointer cursor for better UX */
            }

            .welcome-section .button:hover {
                background-color: rgb(255, 255, 255);
                text-decoration: none;
                color: #ff4444;
            }

            /* Carousel Styles */
            .carousel {
                position: relative;
                width: flex;
                margin: 20px auto;
                overflow: hidden;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            }

            .carousel img {
                width: 100%;
                display: none;
                border-radius: 10px;
            }

            .carousel img.active {
                display: block;
                animation: fade 1.5s ease-in-out;
            }

            @keyframes fade {
                from { opacity: 0.4; }
                to { opacity: 1; }
            }

            .carousel-button {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background-color: rgba(0, 0, 0, 0.5);
                color: white;
                border: none;
                padding: 10px;
                cursor: pointer;
                border-radius: 50%;
                font-size: 18px;
            }

            .carousel-button.prev {
                left: 10px;
            }

            .carousel-button.next {
                right: 10px;
            }

            .carousel-button:hover {
                background-color: rgba(0, 0, 0, 0.8);
            }

            /* News Section Styles */
            .news-section {
                margin-top: 40px;
            }

            .news-section h2 {
                font-size: 2em;
                margin-bottom: 20px;
            }

            .news-grid {
                display: flex;
                gap: 20px;
            }

            .news-item {
                flex: 1;
                text-align: center;
            }

            .news-item img {
                width: 150px;
                height: auto;
                display: block;
                margin: 0 auto;
            }

            .news-item h3 {
                margin-top: 10px;
                font-size: 16px;
            }

            .news-item p {
                font-size: 14px;
                color: #555;
            }

            /* Footer Styles */
            footer {
                background-color:rgb(255, 47, 47);
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

            .welcome-text {
                flex: 3; /* Takes 3/4 of the space */
            }

            .welcome-video {
                flex: 2; /* Takes 1/4 of the space */
                max-width: 40%; /* Ensures it doesn't exceed 1/4 of the container */
            }

            .welcome-video iframe {
                width: 100%;
                height: auto;
                aspect-ratio: 16 / 9; /* Maintains video aspect ratio */
                border-radius: 10px; /* Optional: Rounded corners */
            }

            .portal-ad {
                width: 100%; /* Ensure the container spans the full width */
                overflow: hidden; /* Hide any overflow */
                background-color:rgb(250, 52, 52); /* Add a background color */
                border: 5px solid black; /* Outline effect */
            }

            .portal-ad img {
                width: 100%; /* Make the image cover the full width */
                height: auto; /* Maintain aspect ratio */
                display: block; /* Remove extra space below the image */
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
                <li><a href="UE-Hymn.php">UE Hymn</a></li>
                <li><a href="Prospective Students.php">Campus Tour</a></li>
                <li><a href="admin.php">Admin Panel</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="logo">
            <img id="logo" src="<?php echo $content['logo_url']; ?>" alt="Logo">
        </div>

        <section class="welcome-section">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h1 id="welcomeTitle"><?php echo $content['welcome_title']; ?></h1>
                    <p id="welcomeText"><?php echo $content['welcome_text']; ?></p>
                    <a href="https://www.ue.edu.ph/mla/accreditation/" class="button" id="accreditationButton"><?php echo $content['accreditation_button_text']; ?></a>
                    <a href="https://www.ue.edu.ph/mla/ue-campus-tour/" class="button" id="campusTourButton"><?php echo $content['campus_tour_button_text']; ?></a>
                </div>
            </div>
        </section>

        <div class="carousel">
            <img id="carouselImage1" src="<?php echo $content['carousel_image1']; ?>" alt="Image 1" class="active">
            <img id="carouselImage2" src="<?php echo $content['carousel_image2']; ?>" alt="Image 2">
            <img id="carouselImage3" src="<?php echo $content['carousel_image3']; ?>" alt="Image 3">
            <img id="carouselImage4" src="<?php echo $content['carousel_image4']; ?>" alt="Image 4">

            <button class="carousel-button prev" onclick="prevSlide()">&#10094;</button>
            <button class="carousel-button next" onclick="nextSlide()">&#10095;</button>
        </div>


        <section class="news-section">
            <h2><?php echo 'University News and Announcements'; ?></h2>
            <div class="news-grid">
                <div class="news-item">
                    <img src="<?php echo $content['news_image1']; ?>" alt="News Image 1">
                    <h3><?php echo $content['news_title1']; ?></h3>
                    <p><?php echo $content['news_date1']; ?></p>
                </div>
                <div class="news-item">
                    <img src="<?php echo $content['news_image2']; ?>" alt="News Image 2">
                    <h3><?php echo $content['news_title2']; ?></h3>
                    <p><?php echo $content['news_date2']; ?></p>
                </div>
                <div class="news-item">
                    <img src="<?php echo $content['news_image3']; ?>" alt="News Image 3">
                    <h3><?php echo $content['news_title3']; ?></h3>
                    <p><?php echo $content['news_date3']; ?></p>
                </div>
                <div class="news-item">
                    <img src="<?php echo $content['news_image4']; ?>" alt="News Image 4">
                    <h3><?php echo $content['news_title4']; ?></h3>
                    <p><?php echo $content['news_date4']; ?></p>
                </div>
            </div>
        </section>

        <div class="portal-ad">
            <img src="<?php echo $content['portal_ad_image']; ?>" alt="Portal Ad 2023">
        </div>
    </main>




        <footer>
            <div class="marquee-background">
                <div class="marquee">
                    <span id="marqueeText">Let Your Tomorrow Begin in the East.</span>
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

            //LOAD
            function loadChanges() {
                // Load welcome section
                const savedTitle = localStorage.getItem('welcomeTitle');
                const savedText = localStorage.getItem('welcomeText');
                if (savedTitle) document.getElementById('welcomeTitle').textContent = savedTitle;
                if (savedText) document.getElementById('welcomeText').textContent = savedText;

                // Load buttons
                const savedAccreditationButtonText = localStorage.getItem('accreditationButtonText');
                const savedCampusTourButtonText = localStorage.getItem('campusTourButtonText');
                if (savedAccreditationButtonText) document.getElementById('accreditationButton').textContent = savedAccreditationButtonText;
                if (savedCampusTourButtonText) document.getElementById('campusTourButton').textContent = savedCampusTourButtonText;

                // Load carousel images
                const savedCarouselImage1 = localStorage.getItem('carouselImage1');
                const savedCarouselImage2 = localStorage.getItem('carouselImage2');
                const savedCarouselImage3 = localStorage.getItem('carouselImage3');
                const savedCarouselImage4 = localStorage.getItem('carouselImage4');
                if (savedCarouselImage1) document.getElementById('carouselImage1').src = savedCarouselImage1;
                if (savedCarouselImage2) document.getElementById('carouselImage2').src = savedCarouselImage2;
                if (savedCarouselImage3) document.getElementById('carouselImage3').src = savedCarouselImage3;
                if (savedCarouselImage4) document.getElementById('carouselImage4').src = savedCarouselImage4;

                const savedNewsImage1 = localStorage.getItem('newsImage1');
                const savedNewsImage2 = localStorage.getItem('newsImage2');
                const savedNewsImage3 = localStorage.getItem('newsImage3');
                const savedNewsImage4 = localStorage.getItem('newsImage4');
                if (savedNewsImage1) document.querySelector('.news-item:nth-child(1) img').src = savedNewsImage1;
                if (savedNewsImage2) document.querySelector('.news-item:nth-child(2) img').src = savedNewsImage2;
                if (savedNewsImage3) document.querySelector('.news-item:nth-child(3) img').src = savedNewsImage3;
                if (savedNewsImage4) document.querySelector('.news-item:nth-child(4) img').src = savedNewsImage4;

                const savedPortalAdImage = localStorage.getItem('portalAdImage');
                if (savedPortalAdImage) document.querySelector('.portal-ad img').src = savedPortalAdImage;
                
                // Load logo
                const savedLogoUrl = localStorage.getItem('logoUrl');
                if (savedLogoUrl) document.getElementById('logo').src = savedLogoUrl;

                // Load marquee text
                const savedMarqueeText = localStorage.getItem('marqueeText');
                if (savedMarqueeText) document.getElementById('marqueeText').textContent = savedMarqueeText;

                // Load colors
                const savedBgColor = localStorage.getItem('backgroundColor');
                const savedTextColor = localStorage.getItem('textColor');
                if (savedBgColor) document.documentElement.style.setProperty('--background-color', savedBgColor);
                if (savedTextColor) document.documentElement.style.setProperty('--text-color', savedTextColor);
            }

            // Load changes when the page loads
            window.onload = loadChanges;
        </script>
    </body>
    </html>