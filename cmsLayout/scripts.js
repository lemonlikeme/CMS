let headerAdded = false;
let footerAdded = false;
let navbarAdded = false;

// Function to toggle the sidebar
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
}

// Function to add elements to the canvas
function addElement(type) {
    const canvas = document.getElementById('canvas');
    let element;

    switch (type) {
        case 'button':
            element = document.createElement('button');
            element.innerText = 'Click Me'; // Default text
            element.style.padding = '10px 20px'; // Add padding
            element.style.border = '2px solid #3498db'; // Add border
            element.style.backgroundColor = document.getElementById('buttonColor').value || '#3498db'; // Use selected color or default
            element.style.color = 'white'; // Text color
            element.style.borderRadius = '5px'; // Rounded corners
            element.style.cursor = 'pointer'; // Pointer cursor
            element.style.fontSize = '16px'; // Font size

            // Allow the user to rename the button
            element.addEventListener('dblclick', () => {
                const newText = prompt('Enter new button text:', element.innerText);
                if (newText !== null) {
                    element.innerText = newText; // Update button text
                }
            });
            break;
        case 'text':
            element = document.createElement('p');
            element.innerText = 'Text'; // Default text
            element.style.position = 'absolute';
            element.style.cursor = 'pointer';

            // Make the text editable on double-click
            element.addEventListener('dblclick', () => {
                const newText = prompt('Edit text:', element.innerText);
                if (newText !== null) {
                    element.innerText = newText; // Update text
                }
            });

            // Create a container for the text and the delete button
            const textContainer = document.createElement('div');
            textContainer.style.position = 'absolute';
            textContainer.style.display = 'inline-block';

            // Add the text to the container
            textContainer.appendChild(element);

            // Add a delete button (X) that floats with the text
            const deleteButton = document.createElement('button');
            deleteButton.innerText = '×'; // "X" symbol
            deleteButton.style.position = 'absolute';
            deleteButton.style.top = '-10px'; // Position outside the text
            deleteButton.style.right = '-10px'; // Position outside the text
            deleteButton.style.backgroundColor = 'red';
            deleteButton.style.color = 'white';
            deleteButton.style.border = 'none';
            deleteButton.style.cursor = 'pointer';
            deleteButton.style.padding = '2px 6px';
            deleteButton.style.borderRadius = '50%';
            deleteButton.style.fontSize = '14px';
            deleteButton.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.2)';
            deleteButton.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent dragging when clicking the delete button
                textContainer.remove(); // Remove the container (and the text) when the delete button is clicked
            });

            // Append the delete button to the container
            textContainer.appendChild(deleteButton);

            // Add resize handles
            const resizeHandle = document.createElement('div');
            resizeHandle.style.position = 'absolute';
            resizeHandle.style.bottom = '0';
            resizeHandle.style.right = '0';
            resizeHandle.style.width = '10px';
            resizeHandle.style.height = '10px';
            resizeHandle.style.backgroundColor = '#3498db';
            resizeHandle.style.cursor = 'se-resize'; // Resize cursor
            resizeHandle.style.border = '2px solid white';
            resizeHandle.style.borderRadius = '50%';

            // Append the resize handle to the container
            textContainer.appendChild(resizeHandle);

            // Make the container draggable
            makeDraggable(textContainer);

            // Make the text resizable
            makeResizable(element, resizeHandle);

            // Calculate the center position of the canvas
            const canvasRect = canvas.getBoundingClientRect();
            const centerX = (canvasRect.width - element.offsetWidth) / 2;
            const centerY = (canvasRect.height - element.offsetHeight) / 2;

            // Set the initial position of the container to the center of the canvas
            textContainer.style.left = `${centerX}px`;
            textContainer.style.top = `${centerY}px`;

            // Append the container to the canvas
            canvas.appendChild(textContainer);
            break;
        case 'image':
            // Create a file input for image upload
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'image/*'; // Only allow image files
            fileInput.style.display = 'none'; // Hide the file input

            // When the user selects an image
            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0]; // Get the selected file
                if (file) {
                    const reader = new FileReader(); // Create a FileReader to read the file
                    reader.onload = (event) => {
                        // Create an image element and set its source to the uploaded image
                        const img = document.createElement('img');
                        img.src = event.target.result; // Set the image source
                        img.style.width = '150px'; // Set default width
                        img.style.height = 'auto'; // Maintain aspect ratio

                        // Create a container for the image, delete button, and resize handles
                        const container = document.createElement('div');
                        container.style.position = 'absolute';
                        container.style.display = 'inline-block';

                        // Add the image to the container
                        container.appendChild(img);

                        // Add a delete button (X) that floats with the image
                        const deleteButton = document.createElement('button');
                        deleteButton.innerText = '×'; // "X" symbol
                        deleteButton.style.position = 'absolute';
                        deleteButton.style.top = '-10px'; // Position outside the image
                        deleteButton.style.right = '-10px'; // Position outside the image
                        deleteButton.style.backgroundColor = 'red';
                        deleteButton.style.color = 'white';
                        deleteButton.style.border = 'none';
                        deleteButton.style.cursor = 'pointer';
                        deleteButton.style.padding = '2px 6px';
                        deleteButton.style.borderRadius = '50%';
                        deleteButton.style.fontSize = '14px';
                        deleteButton.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.2)';
                        deleteButton.addEventListener('click', (e) => {
                            e.stopPropagation(); // Prevent dragging when clicking the delete button
                            container.remove(); // Remove the container (and the image) when the delete button is clicked
                        });

                        // Append the delete button to the container
                        container.appendChild(deleteButton);

                        // Add resize handles
                        const resizeHandle = document.createElement('div');
                        resizeHandle.style.position = 'absolute';
                        resizeHandle.style.bottom = '0';
                        resizeHandle.style.right = '0';
                        resizeHandle.style.width = '10px';
                        resizeHandle.style.height = '10px';
                        resizeHandle.style.backgroundColor = '#3498db';
                        resizeHandle.style.cursor = 'se-resize'; // Resize cursor
                        resizeHandle.style.border = '2px solid white';
                        resizeHandle.style.borderRadius = '50%';

                        // Append the resize handle to the container
                        container.appendChild(resizeHandle);

                        // Make the container draggable
                        makeDraggable(container);

                        // Make the image resizable
                        makeResizable(img, resizeHandle);

                        // Calculate the center position of the canvas
                        const canvasRect = canvas.getBoundingClientRect();
                        const centerX = (canvasRect.width - img.offsetWidth) / 2;
                        const centerY = (canvasRect.height - img.offsetHeight) / 2;

                        // Set the initial position of the container to the center of the canvas
                        container.style.left = `${centerX}px`;
                        container.style.top = `${centerY}px`;

                        // Append the container to the canvas
                        canvas.appendChild(container);
                    };
                    reader.readAsDataURL(file); // Read the file as a data URL
                }
            });

            // Trigger the file input when adding an image element
            fileInput.click();
            return; // Exit the function after triggering the file input
        case 'navbar':
            if (navbarAdded) {
                alert('Only one navbar can be added!');
                return;
            }
            element = document.createElement('div');
            element.className = 'navbar';
            element.innerHTML = `
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                    <button>Search</button>
                </div>
                <div class="nav-buttons">
                    <button>Home</button>
                    <button>About</button>
                    <button>Contact</button>
                </div>
            `;
            navbarAdded = true; // Mark navbar as added

            // Apply the selected navbar button color
            const navbarButtonColor = document.getElementById('navbarButtonColor').value;
            const navbarButtons = element.querySelectorAll('.nav-buttons button');
            navbarButtons.forEach(button => {
                button.style.backgroundColor = navbarButtonColor; // Set navbar button color
            });
            break;
        case 'header':
            if (headerAdded) {
                alert('Only one header can be added!');
                return;
            }
            element = document.createElement('div');
            element.className = 'header';
            element.innerText = 'Header';
            headerAdded = true; // Mark header as added
            break;
        case 'footer':
            if (footerAdded) {
                alert('Only one footer can be added!');
                return;
            }
            element = document.createElement('div');
            element.className = 'footer';
            element.innerText = 'Footer';
            footerAdded = true; // Mark footer as added
            break;
        case 'section':
            element = document.createElement('div');
            element.className = 'section';
            element.innerHTML = `
                <div class="section-content"></div>
            `;
            break;
        default:
            return;
    }

    // Make elements draggable except for header, navbar, footer, and section
    if (type !== 'header' && type !== 'navbar' && type !== 'footer' && type !== 'section') {
        // Create a container for the element and the delete button
        const container = document.createElement('div');
        container.style.position = 'absolute';
        container.style.display = 'inline-block';

        // Add the element to the container
        container.appendChild(element);

        // Add a delete button (X) that floats with the element
        const deleteButton = document.createElement('button');
        deleteButton.innerText = '×'; // "X" symbol
        deleteButton.style.position = 'absolute';
        deleteButton.style.top = '-10px'; // Position outside the element
        deleteButton.style.right = '-10px'; // Position outside the element
        deleteButton.style.backgroundColor = 'red';
        deleteButton.style.color = 'white';
        deleteButton.style.border = 'none';
        deleteButton.style.cursor = 'pointer';
        deleteButton.style.padding = '2px 6px';
        deleteButton.style.borderRadius = '50%';
        deleteButton.style.fontSize = '14px';
        deleteButton.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.2)';
        deleteButton.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent dragging when clicking the delete button
            container.remove(); // Remove the container (and the element) when the delete button is clicked
        });

        // Append the delete button to the container
        container.appendChild(deleteButton);

        // Make the container draggable
        makeDraggable(container);

        // Calculate the center position of the canvas
        const canvasRect = canvas.getBoundingClientRect();
        const centerX = (canvasRect.width - element.offsetWidth) / 2;
        const centerY = (canvasRect.height - element.offsetHeight) / 2;

        // Set the initial position of the container to the center of the canvas
        container.style.left = `${centerX}px`;
        container.style.top = `${centerY}px`;

        // Append the container to the canvas
        canvas.appendChild(container);
    } else {
        // Append non-draggable elements directly to the canvas
        canvas.appendChild(element);
    }
}

// Function to make elements resizable
function makeResizable(element, resizeHandle) {
    let isResizing = false;

    resizeHandle.addEventListener('mousedown', (e) => {
        isResizing = true;
        e.stopPropagation(); // Prevent dragging when resizing
    });

    document.addEventListener('mousemove', (e) => {
        if (isResizing) {
            // Calculate new width and height based on mouse position
            const newWidth = e.clientX - element.getBoundingClientRect().left;
            const newHeight = e.clientY - element.getBoundingClientRect().top;

            // Apply new width and height to the element
            element.style.width = `${newWidth}px`;
            element.style.height = `${newHeight}px`;
        }
    });

    document.addEventListener('mouseup', () => {
        isResizing = false;
    });
}

function makeDraggable(element) {
    let isDragging = false;
    let offsetX, offsetY;

    element.addEventListener('mousedown', (e) => {
        isDragging = true;

        // Calculate the offset between the mouse pointer and the element's top-left corner
        offsetX = e.clientX - element.offsetLeft;
        offsetY = e.clientY - element.offsetTop;

        // Change cursor to grabbing
        element.style.cursor = 'grabbing';

        // Prevent text selection while dragging
        e.preventDefault();
    });

    document.addEventListener('mousemove', (e) => {
        if (isDragging) {
            // Calculate the new position of the element
            const newLeft = e.clientX - offsetX;
            const newTop = e.clientY - offsetY;

            // Apply the new position to the element
            element.style.left = `${newLeft}px`;
            element.style.top = `${newTop}px`;
        }
    });

    document.addEventListener('mouseup', () => {
        if (isDragging) {
            isDragging = false;

            // Reset cursor to grab
            element.style.cursor = 'grab';
        }
    });

    // Prevent dragging from accidentally selecting text
    element.addEventListener('selectstart', (e) => {
        e.preventDefault();
    });
}

// Function to change header color
function changeHeaderColor(color) {
    const header = document.querySelector('.header');
    if (header) {
        header.style.backgroundColor = color;
    }
}

// Function to change navbar color
function changeNavbarColor(color) {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        navbar.style.backgroundColor = color;
    }
}

// Function to change footer color
function changeFooterColor(color) {
    const footer = document.querySelector('.footer');
    if (footer) {
        footer.style.backgroundColor = color;
    }
}

// Function to update header text
function updateHeaderText(text) {
    const header = document.querySelector('.header');
    if (header) {
        header.innerText = text;
    }
}

// Function to update footer text
function updateFooterText(text) {
    const footer = document.querySelector('.footer');
    if (footer) {
        footer.innerText = text;
    }
}

// Function to change button color
function changeButtonColor(color) {
    const buttons = document.querySelectorAll('.draggable button'); // Select all draggable buttons
    buttons.forEach(button => {
        button.style.backgroundColor = color; // Update button color
    });
}

// Function to change navbar button color
function changeNavbarButtonColor(color) {
    const navbarButtons = document.querySelectorAll('.navbar .nav-buttons button'); // Select all navbar buttons
    navbarButtons.forEach(button => {
        button.style.backgroundColor = color; // Update navbar button color
    });
}

function saveLayout() {
    const canvas = document.getElementById('canvas');
    const canvasContent = canvas.innerHTML;

    const layoutName = prompt('Enter a name for this layout:');
    if (!layoutName) return;

    fetch('save_layout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: layoutName, content: canvasContent }),
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

function loadLayout() {
    const layoutName = prompt('Enter the name of the layout to load:');
    if (!layoutName) return;

    fetch('load_layout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: layoutName }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const canvas = document.getElementById('canvas');
            canvas.innerHTML = data.content;
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