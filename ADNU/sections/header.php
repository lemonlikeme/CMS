<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ateneo de Naga University</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="collegeEntranceProcReq.php">College Entrance Procedure and Requirements</a>
            <a href="#">College Admissions and Enrollment Procedures</a>
            <a href="ContactUs.php">Contact Us</a>
			<button id="search-btn">
        <img src="imgs/searchcon.png" alt="Search" width="20px">
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

	
