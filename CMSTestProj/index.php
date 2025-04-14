<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placeholder</title>
    <link rel='stylesheet' href='css/styles.css'>
</head>
<body>
<?php include 'sections/header.php';?>
    <section class="hero">
        <div class="hero-overlay">
          <div class="hero-content">
            <h1>A website<br>Let's make it real</h1>
            <a href="#" class="cta-button"><span>Get Started</span></a>
          </div>
        </div>
      </section>
    <section class="image-text-section">
        <div class="carousel-container">
            <div class="carousel">
                <img src="imgs/carousel1-image.jpg" alt="Image 1"/>
                <img src="imgs/carousel2-image.jpg" alt="Image 2"/>
                <img src="imgs/carousel3-image.jpg" alt="Image 3"/>
                <img src="imgs/carousel4-image.jpg" alt="Image 4"/>
                <img src="imgs/carousel5-image.jpg" alt="Image 5"/>

                <img class="duplicate" src="imgs/carousel1-image.jpg" alt="Image 1"/>
                <img class="duplicate" src="imgs/carousel2-image.jpg" alt="Image 2"/>
                <img class="duplicate" src="imgs/carousel3-image.jpg" alt="Image 3"/>
                <img class="duplicate" src="imgs/carousel4-image.jpg" alt="Image 4"/>
                <img class="duplicate" src="imgs/carousel5-image.jpg" alt="Image 5"/>
            </div>
        </div>
        <div class="text-content">
            <h2>Explore our feratures</h2>
            <p>Discover powerful tools and service design to make your web experience seamless and productive</p>
        </div>
    </section>

    <section class="about-section">
        <div class="about-container">
            <h2>About Placeholder</h2>
            <p>This website was designed to help users easily create their own stunning websites without writing a single line of code. With intuitive drag-and-drop tools, pre-designed templates, and customization options, building a website has never been easier.</p>
        </div>
    </section>

    <section class="use-cases">
        <h2>Who is Placeholder for?</h2>
        <div class="use-cards">
            <div class="use-card" style="background-image: url('imgs/card-creative.jpg')">
              <div class="card-content">
                <h3>For Creatives</h3>
                <p>Designers, artists, and freelancers can build beautiful portfolios effortlessly.</p>
              </div>
            </div>
            <div class="use-card" style="background-image: url('imgs/card-start-up.jpg')">
              <div class="card-content">
                <h3>For Startups</h3>
                <p>Quickly launch landing pages to pitch, validate, and grow your business ideas.</p>
              </div>
            </div>
            <div class="use-card" style="background-image: url('imgs/card-portfolio.jpg')">
              <div class="card-content">
                <h3>For Portfolios</h3>
                <p>Showcase your work in a stylish, responsive website—no coding needed.</p>
              </div>
            </div>
          </div>          
    </section>

   <?php include 'sections/footer.php';?>
    <div id="authModal" class="modal">
      <div class="auth-container" id="authContainer">
    
        <div class="form-container sign-up-container">
          <form>
            <h2>Create Account</h2>
            <input type="text" placeholder="Name" />
            <input type="email" placeholder="Email" />
            <input type="password" placeholder="Password" />
            <button>Sign Up</button>
          </form>
        </div>
    
        <div class="form-container sign-in-container">
          <form>
            <h2>Sign in</h2>
            <input type="email" placeholder="Email" />
            <input type="password" placeholder="Password" />
            <button>Login</button>
          </form>
        </div>
    
        <div class="overlay-container">
          <div class="overlay">
            <div class="overlay-panel overlay-left">
              <h2>Welcome Back!</h2>
              <p>Already have an account?</p>
              <button id="slideToLogin">Login</button>
            </div>
            <div class="overlay-panel overlay-right">
              <h2>Hello, Friend!</h2>
              <p>Don't have an account?</p>
              <button id="slideToSignup">Sign Up</button>
            </div>
          </div>
        </div>
    
        <span class="close">&times;</span>
      </div>
    </div>
    
    <script src="jscripts/scripts.js"></script>
</body>
</html>