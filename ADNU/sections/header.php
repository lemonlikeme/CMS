<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ateneo de Naga University</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ADNU/css/styles.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="/ADNU/index.php">Home</a>
            <a href="/ADNU/collegeEntranceProcReq.php">College Entrance Procedure and Requirements</a>
			
            <div class="dropdown">
            <a href="#">Academics ▼</a>
            <ul class="dropdown-menu">
                <li><a href="inner/gradeschool.php">Grade School</a></li>
                <li><a href="juniorHigh.php">Junior High</a></li>
                <li><a href="seniorHigh.php">Senior High</a></li>
                <li><a href="college.php">College</a></li>
                <li><a href="postGrad.php">Post Graduate</a></li>
            </ul>
        </div>

            <a href="/ADNU/ContactUs.php">Contact Us</a>
			<button id="search-btn">
        <img src="/ADNU/imgs/searchcon.png" alt="Search" width="20px">
    </button>
    <div id="search-bar">
        <input type="text" id="search-input" placeholder="Search...">
        
    </div>
        </nav>
    </header>
    <div class="pageheader">
        <div class="hid">
             <?php if (basename($_SERVER['PHP_SELF']) != 'ContactUs.php'): ?>
                <h1>Ateneo de Naga University Admissions</h1>
            <?php endif; ?>
        </div>
    </div>
	<script src="jscript/script.js"></script>

	
