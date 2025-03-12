<?php 
session_start(); 
include 'sections/header.php'; 
?>

<!-- Link external CSS -->
<link rel="stylesheet" href="styles.css">

<!-- Pop-up Modal -->
<div id="overlay" class="overlay" onclick="closePopup()"></div>
<div id="popup" class="modal">
    <span class="close-btn" onclick="closePopup()">&times;</span>
    <p id="popup-message"></p>
</div>

<div class="pageheader">
    <div class="hid">
        <h1>Contact Us</h1>
    </div>
</div>

<div class="container">
    <div class="card">
        <h2>Contact Information</h2>
        <p>
            <strong>College Admissions and Aid Office</strong><br>
            Ateneo de Naga University<br>
            Ateneo Avenue, Bagumbayan Sur, Naga City 4400 Philippines<br>
            <strong>Telephone:</strong> (054) 881-4119 or 473-8447 Loc. 2312<br>
            <strong>Mobile:</strong> 09216755155<br>
            <strong>Email:</strong> <a href="mailto:caao@gbox.adnu.edu.ph">caao@gbox.adnu.edu.ph</a>
        </p>
    </div>

    <div class="card">
        <h2>Send Us a Message</h2>
        <form action="process_form.php" method="POST" class="contact-form">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="nameD" id="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="emailD" id="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea name="messageD" id="message" placeholder="Type your message here..." rows="5" required></textarea>
            </div>

            <button type="submit" class="btn-submit">Send Message</button>
        </form>
    </div>
</div>

<?php 
include 'sections/footer.php'; 

// Show the popup if session variables exist
if (isset($_SESSION['name']) && isset($_SESSION['email'])) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showPopup('Thank you, " . $_SESSION['name'] . "! We have received your message from " . $_SESSION['email'] . ".');
            });
          </script>";
    session_unset();
    session_destroy();
}
?>

<!-- Link external JavaScript -->
<script src="script.js"></script>
