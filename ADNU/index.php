<?php include 'sections/header.php'; ?>


<!-- Settings -->
<button id="settings-btn" class="settings-btn">⚙️ Settings</button>


<div id="settings-panel" class="settings-panel">
    <div class="settings-header">
        <h2>Settings</h2>
        <button id="close-settings">&times;</button>
    </div>
    
    <div class="settings-content">
     
        <label for="hero-bg">Hero Background Color:</label>
        <input type="color" id="hero-bg">

        <label for="left-bg">Left Content Background Color:</label>
        <input type="color" id="left-bg">

        <label for="right-bg">Right Content Background Color:</label>
        <input type="color" id="right-bg">

     
        <label for="left-title">Change Left Section Title:</label>
        <input type="text" id="left-title" placeholder="Enter new title">

        <label for="left-text">Change Left Section Text:</label>
        <textarea id="left-text" placeholder="Enter new content"></textarea>

        
		
		<label for="hero-upload">Upload Hero Image:</label>
		<input type="file" id="hero-upload" accept="image/*">
		<!-- Image Preview -->
		<img id="preview-image" style="width: 100%; max-height: 200px; display: none; margin-top: 10px;"> 
		
		<label for="hero-slide-select">Select Hero Slide:</label>
		<select id="hero-slide-select"></select>
		
		<label for="hero-title">Change Hero Title:</label>
		<input type="text" id="hero-title" placeholder="Enter new title">

		<label for="hero-text">Change Hero Text:</label>
		<textarea id="hero-text" placeholder="Enter new text"></textarea>

		<button id="save-settings">Save Changes</button>
		<button id="reset-settings" class="reset-btn">Reset to Default</button>
    </div>
</div>

<!-- hero -->
<div class="hero">
    <div class="hero-overlay">
        <h1 id="hero-title"></h1>
        <p id="hero-text"></p>
    </div>
</div>



<div class="content-wrapper">
  
    <div class="leftContent"> 
        <h2>Welcome to Ateneo de Naga University Admissions</h2>
        <p>The College Admissions and Aid Office (CAAO) is a student service office performing academic support functions within Ateneo de Naga University...</p>
    </div>

    <div class="divider"></div> 

    <div class="rightContent">  
        <h2>Topics</h2>
        <ul class="topics-list">
            <li><a href="collegeEntranceProcReq.php">College Entrance</a></li>
            
        </ul>
    </div>
</div>

<?php include 'sections/footer.php'; ?>
