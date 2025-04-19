
<header>
  <nav class="navbar">
        <div class="navdiv">
            <div class="logo"><a href='#'>Placeholder</a></div>

            <ul>
                <li><a href='#'>Home</a></li>
                <li><a href='#'>Product</a></li>
                <li><a href='#'>About</a></li>
                <li><a href='#'>Contacts</a></li>
            </ul>

            <div class="nav-btn">
                <?php if (!isset($_SESSION['name'])): ?>
                    <a href="#" id="loginBtn" class="nav-button">Log In</a>
                <?php else: ?>
                    <span class="nav-welcome">Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</span>
                    <a href="db/logout.php" class="nav-button">Logout</a>
                <?php endif; ?>
                <a href="GET%20STARTED/get_Started.php" class="nav-button">Get Started</a>
              </div>
        </div>
    </nav>
</header>
