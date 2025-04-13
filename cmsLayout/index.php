<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customizable Web Builder</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Sidebar Toggle Button -->
    <div id="sidebar-toggle" onclick="toggleSidebar()">☰</div>

    <!-- Sidebar -->
    <div id="sidebar">
    <h2>Add Elements</h2>
    <button onclick="addElement('button')">Add Button</button>
    <button onclick="addElement('text')">Add Text</button>
    <button onclick="addElement('image')">Add Image</button>
    <button onclick="addElement('navbar')">Add Navbar</button>
    <button onclick="addElement('header')">Add Header</button>
    <button onclick="addElement('footer')">Add Footer</button>
    <button onclick="addElement('section')">Add Section</button>
    <button onclick="saveLayout()">Save Layout</button>
    <button onclick="loadLayout()">Load Layout</button>
    <br><br>
    <label for="buttonColor">Button Color:</label>
    <input type="color" id="buttonColor" onchange="changeButtonColor(this.value)">
    <br><br>
    <label for="navbarButtonColor">Navbar Button Color:</label>
    <input type="color" id="navbarButtonColor" onchange="changeNavbarButtonColor(this.value)">
    <br><br>
    <label for="textColor">Text Color:</label>
    <input type="color" id="textColor" onchange="changeTextColor(this.value)">
    <br><br>
    <label for="headerColor">Header Color:</label>
    <input type="color" id="headerColor" onchange="changeHeaderColor(this.value)">
    <br><br>
    <label for="navbarColor">Navbar Color:</label>
    <input type="color" id="navbarColor" onchange="changeNavbarColor(this.value)">
    <br><br>
    <label for="footerColor">Footer Color:</label>
    <input type="color" id="footerColor" onchange="changeFooterColor(this.value)">
    <br><br>
    <label for="headerText">Header Text:</label>
    <input type="text" id="headerText" placeholder="Edit header text" onchange="updateHeaderText(this.value)">
    <br><br>
    <label for="footerText">Footer Text:</label>
    <input type="text" id="footerText" placeholder="Edit footer text" onchange="updateFooterText(this.value)">
    <br><br>
</div>

    <!-- Canvas -->
    <div id="canvas">
        <!-- Header, Navbar, Footer, and other elements will be added here -->
    </div>

    <script>
        // Function to save the canvas layout to the database
        function saveLayout() {
            const canvas = document.getElementById('canvas');
            const canvasContent = canvas.innerHTML; // Get the HTML content of the canvas

            // Prompt the user for a layout name
            const layoutName = prompt('Enter a name for this layout:');
            if (!layoutName) return; // Exit if the user cancels

            // Send the data to the server using Fetch API
            fetch('save_layout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ name: layoutName, content: canvasContent }), // Send layout name and content
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Layout saved successfully!');
                } else {
                    alert('Failed to save layout: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the layout.');
            });
        }

        // Function to load a layout from the database
        function loadLayout() {
            // Prompt the user for the layout name to load
            const layoutName = prompt('Enter the name of the layout to load:');
            if (!layoutName) return; // Exit if the user cancels

            // Send the layout name to the server using Fetch API
            fetch('load_layout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ name: layoutName }), // Send layout name
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const canvas = document.getElementById('canvas');
                    canvas.innerHTML = data.content; // Load the saved content into the canvas
                    alert('Layout loaded successfully!');
                } else {
                    alert('Failed to load layout: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while loading the layout.');
            });
        }
    </script>

    <script src="scripts.js"></script>
</body>
</html>