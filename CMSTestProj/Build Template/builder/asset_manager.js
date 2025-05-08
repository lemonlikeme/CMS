// Initialize state from PHP
let state = window.assetState || {
    assets: [],
    styles: [],
    header: {
        logo: 'assets/logo.png',
        title: 'University Name',
        nav: {
            home: 'Home',
            about: 'About',
            admissions: 'Admissions',
            contact: 'Contact'
        },
        styles: {
            bgColor: '#ffffff',
            textColor: '#333333',
            navColor: '#333333',
            navHoverColor: '#4A90E2'
        }
    },
    footer: {
        contact: {
            title: 'Contact Us',
            address: '123 University Ave, City, State 12345',
            phone: 'Phone: (123) 456-7890',
            email: 'Email: info@university.edu'
        },
        social: {
            title: 'Follow Us',
            facebook: 'Facebook',
            twitter: 'Twitter',
            instagram: 'Instagram'
        },
        copyright: '© 2024 University Name. All rights reserved.',
        styles: {
            bgColor: '#ffffff',
            textColor: '#333333',
            linkColor: '#333333',
            linkHoverColor: '#4A90E2'
        }
    }
};

document.addEventListener('DOMContentLoaded', function() {
    // Asset button click handlers
    const assetButtons = document.querySelectorAll('.asset-btn');
    assetButtons.forEach(button => {
        button.addEventListener('click', async () => {
            const assetType = button.dataset.asset;
            
            // Disable button and show loading state
            button.disabled = true;
            const originalText = button.textContent;
            button.textContent = 'Loading...';
            
            try {
                const response = await fetch('asset_manager.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=load_asset&asset=${encodeURIComponent(assetType)}`
                });

                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                if (data.success && data.html && data.css) {
                    // Generate unique ID for the asset
                    const assetId = `asset_${Date.now()}`;
                    
                    // Add to state
                    state.assets[assetId] = {
                        type: assetType,
                        html: data.html,
                        css: data.css,
                        properties: extractProperties(data.html)
                    };
                    
                    // Update preview
                    updatePreview();
                    
                    // Show properties panel
                    showProperties(assetId);
                    
                    // Save state
                    saveState();
                } else {
                    throw new Error(data.error || 'Failed to load asset');
                }
            } catch (error) {
                console.error('Error loading asset:', error);
                alert(`Failed to load asset: ${error.message}`);
            } finally {
                // Reset button state
                button.disabled = false;
                button.textContent = originalText;
            }
        });
    });

    // Save preview button
    const saveButton = document.getElementById('savePreview');
    if (saveButton) {
        saveButton.addEventListener('click', () => {
            saveState();
            alert('Changes saved successfully!');
        });
    }

    // Extract editable properties from HTML
    function extractProperties(html) {
        const properties = {};
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        
        // Find all elements with data-editable attribute
        doc.querySelectorAll('[data-editable]').forEach(element => {
            const key = element.dataset.editable;
            const type = element.dataset.type || 'text';
            properties[key] = {
                type: type,
                value: element.textContent,
                selector: `[data-editable="${key}"]`
            };
        });

        // Find all images with data-editable attribute
        doc.querySelectorAll('img[data-editable]').forEach(element => {
            const key = element.dataset.editable;
            properties[key] = {
                type: 'image',
                value: element.src,
                selector: `img[data-editable="${key}"]`
            };
        });

        return properties;
    }

    // Show properties panel for an asset
    function showProperties(assetId) {
        const propertiesPanel = document.getElementById('assetProperties');
        const propertiesContent = propertiesPanel.querySelector('.properties-content');
        const asset = state.assets[assetId];
        
        if (!asset) return;

        // Clear existing properties
        propertiesContent.innerHTML = '';
        
        // Create temporary state for unsaved changes
        const tempState = {
            properties: JSON.parse(JSON.stringify(asset.properties)),
            styles: asset.styles ? JSON.parse(JSON.stringify(asset.styles)) : {}
        };
        
        // Add properties based on type
        Object.entries(asset.properties).forEach(([key, prop]) => {
            let propertyElement;
            
            switch (prop.type) {
                case 'text':
                    propertyElement = createTextProperty(key, prop, tempState);
                    break;
                case 'image':
                    propertyElement = createImageProperty(key, prop, tempState);
                    break;
                case 'color':
                    propertyElement = createColorProperty(key, prop, tempState);
                    break;
                case 'font':
                    propertyElement = createFontProperty(key, prop, tempState);
                    break;
            }
            
            if (propertyElement) {
                propertiesContent.appendChild(propertyElement);
            }
        });

        // Add color properties section
        const colorSection = document.createElement('div');
        colorSection.className = 'property-section';
        colorSection.innerHTML = '<h4>Colors</h4>';
        
        const colorGroup = document.createElement('div');
        colorGroup.className = 'property-group';
        colorGroup.innerHTML = `
            <label class="property-label">Colors</label>
            <div class="color-inputs">
                <div class="color-input">
                    <label>Background Color</label>
                    <input type="color" class="property-input" value="${tempState.styles.bgColor || '#ffffff'}">
                </div>
                <div class="color-input">
                    <label>Text Color</label>
                    <input type="color" class="property-input" value="${tempState.styles.textColor || '#333333'}">
                </div>
                <div class="color-input">
                    <label>Border Color</label>
                    <input type="color" class="property-input" value="${tempState.styles.borderColor || '#e0e0e0'}">
                </div>
                <div class="color-input">
                    <label>Accent Color</label>
                    <input type="color" class="property-input" value="${tempState.styles.accentColor || '#4A90E2'}">
                </div>
            </div>
        `;

        const colorInputs = colorGroup.querySelectorAll('input[type="color"]');
        colorInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                const colorType = e.target.parentElement.querySelector('label').textContent.toLowerCase().replace(/\s+/g, '');
                tempState.styles[colorType] = e.target.value;
            });
        });

        colorSection.appendChild(colorGroup);
        propertiesContent.appendChild(colorSection);

        // Add save button
        const saveButton = document.createElement('button');
        saveButton.className = 'btn-primary save-properties-btn';
        saveButton.textContent = 'Save Changes';
        saveButton.addEventListener('click', () => {
            // Update the actual state with temporary changes
            state.assets[assetId].properties = tempState.properties;
            state.assets[assetId].styles = tempState.styles;
            
            // Update preview
            updatePreview();
            
            // Save state
            saveState().then(() => {
                const notification = document.createElement('div');
                notification.className = 'save-notification';
                notification.textContent = 'Changes saved';
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 2000);
            });
        });
        propertiesContent.appendChild(saveButton);

        // Show the panel
        propertiesPanel.style.display = 'block';
    }

    // Create text property input
    function createTextProperty(key, prop, tempState) {
        const template = document.getElementById('textProperty');
        const element = template.content.cloneNode(true);
        
        const label = element.querySelector('.property-label');
        label.textContent = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        
        const input = element.querySelector('.property-input');
        input.value = prop.value;
        
        input.addEventListener('input', (e) => {
            tempState.properties[key].value = e.target.value;
        });
        
        return element;
    }

    // Create image property input
    function createImageProperty(key, prop, tempState) {
        const template = document.getElementById('imageProperty');
        const element = template.content.cloneNode(true);
        
        const label = element.querySelector('.property-label');
        label.textContent = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        
        const input = element.querySelector('.property-input');
        const preview = element.querySelector('.image-preview');
        
        if (prop.value) {
            const img = document.createElement('img');
            img.src = prop.value;
            preview.appendChild(img);
        }
        
        input.addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (file) {
                preview.innerHTML = '<div class="loading">Uploading...</div>';
                
                try {
                    const formData = new FormData();
                    formData.append('action', 'upload_image');
                    formData.append('image', file);
                    
                    const response = await fetch('asset_manager.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    if (!response.ok) throw new Error('Upload failed');
                    
                    const data = await response.json();
                    if (data.success) {
                        tempState.properties[key].value = data.url;
                        preview.innerHTML = `<img src="${data.url}">`;
                    } else {
                        throw new Error(data.error || 'Upload failed');
                    }
                } catch (error) {
                    console.error('Error uploading image:', error);
                    preview.innerHTML = '<div class="error">Upload failed</div>';
                    setTimeout(() => {
                        preview.innerHTML = prop.value ? `<img src="${prop.value}">` : '';
                    }, 2000);
                }
            }
        });
        
        return element;
    }

    // Create color property input
    function createColorProperty(key, prop, tempState) {
        const template = document.getElementById('colorProperty');
        const element = template.content.cloneNode(true);
        
        const label = element.querySelector('.property-label');
        label.textContent = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        
        const input = element.querySelector('.property-input');
        input.value = prop.value;
        
        input.addEventListener('input', (e) => {
            tempState.properties[key].value = e.target.value;
        });
        
        return element;
    }

    // Create font property input
    function createFontProperty(key, prop, tempState) {
        const template = document.getElementById('fontProperty');
        const element = template.content.cloneNode(true);
        
        const label = element.querySelector('.property-label');
        label.textContent = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        
        const select = element.querySelector('.property-input');
        select.value = prop.value;
        
        select.addEventListener('change', (e) => {
            tempState.properties[key].value = e.target.value;
        });
        
        return element;
    }

    // Update asset property
    function updateAssetProperty(assetId, key, value) {
        if (state.assets[assetId]) {
            // Update the property value
            state.assets[assetId].properties[key].value = value;
            
            // Update the preview immediately
            const preview = document.getElementById('preview');
            const assetElement = preview.querySelector(`[data-asset-id="${assetId}"]`);
            
            if (assetElement) {
                const element = assetElement.querySelector(state.assets[assetId].properties[key].selector);
                if (element) {
                    if (state.assets[assetId].properties[key].type === 'image') {
                        element.src = value;
                    } else {
                        element.textContent = value;
                    }
                }
            }
            
            // Save state to server
            saveState().then(() => {
                // Show a small notification
                const notification = document.createElement('div');
                notification.className = 'save-notification';
                notification.textContent = 'Changes saved';
                document.body.appendChild(notification);
                
                // Remove notification after 2 seconds
                setTimeout(() => {
                    notification.remove();
                }, 2000);
            });
        }
    }

    // Update preview
    function updatePreview() {
        const preview = document.getElementById('preview');
        if (!preview) return;

        // Clear existing content
        preview.innerHTML = '';

        // Add header
        const headerTemplate = document.getElementById('headerTemplate');
        const header = headerTemplate.content.cloneNode(true);
        
        // Update header content and styles
        const headerElement = header.querySelector('.site-header');
        if (headerElement) {
            headerElement.style.backgroundColor = state.header.styles.bgColor;
            headerElement.style.color = state.header.styles.textColor;
        }
        
        const headerLogo = header.querySelector('[data-editable="header_logo"]');
        const headerTitle = header.querySelector('[data-editable="header_title"]');
        const navLinks = header.querySelectorAll('[data-editable^="nav_"]');
        
        if (headerLogo) headerLogo.src = state.header.logo;
        if (headerTitle) {
            headerTitle.textContent = state.header.title;
            headerTitle.style.color = state.header.styles.textColor;
        }
        
        navLinks.forEach(link => {
            const key = link.dataset.editable.replace('nav_', '');
            if (state.header.nav[key]) {
                link.textContent = state.header.nav[key];
                link.style.color = state.header.styles.navColor;
                link.addEventListener('mouseover', () => {
                    link.style.color = state.header.styles.navHoverColor;
                });
                link.addEventListener('mouseout', () => {
                    link.style.color = state.header.styles.navColor;
                });
            }
        });
        
        preview.appendChild(header);

        // Create main content container
        const mainContent = document.createElement('main');
        mainContent.className = 'main-content';

        if (Object.keys(state.assets).length > 0) {
            // Create style element for all CSS
            const style = document.createElement('style');
            style.textContent = Object.values(state.assets).map(asset => asset.css).join('\n');
            mainContent.appendChild(style);

            // Add all assets
            Object.entries(state.assets).forEach(([assetId, asset]) => {
                const container = document.createElement('div');
                container.className = 'asset';
                container.dataset.assetId = assetId;
                
                // Add asset HTML
                container.innerHTML = asset.html;
                
                // Add controls
                const controls = document.createElement('div');
                controls.className = 'asset-controls';
                controls.innerHTML = `
                    <div class="drag-handle" draggable="true" title="Drag to reorder"></div>
                    <button class="edit-btn" title="Edit">✎</button>
                    <button class="delete-btn" title="Delete">×</button>
                `;
                container.appendChild(controls);
                
                // Add event listeners
                const dragHandle = controls.querySelector('.drag-handle');
                dragHandle.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text/plain', assetId);
                    container.classList.add('dragging');
                });

                dragHandle.addEventListener('dragend', () => {
                    container.classList.remove('dragging');
                });
                
                controls.querySelector('.edit-btn').addEventListener('click', () => {
                    showProperties(assetId);
                });
                
                controls.querySelector('.delete-btn').addEventListener('click', () => {
                    if (confirm('Are you sure you want to delete this asset?')) {
                        delete state.assets[assetId];
                        updatePreview();
                        saveState();
                        const propertiesPanel = document.getElementById('assetProperties');
                        if (propertiesPanel) {
                            propertiesPanel.style.display = 'none';
                        }
                    }
                });
                
                // Apply properties
                Object.entries(asset.properties).forEach(([key, prop]) => {
                    const element = container.querySelector(prop.selector);
                    if (element) {
                        if (prop.type === 'image') {
                            element.src = prop.value;
                        } else {
                            element.textContent = prop.value;
                        }
                    }
                });
                
                mainContent.appendChild(container);
            });
        } else {
            mainContent.innerHTML = '<p class="placeholder">Add assets from the right panel to start building your page.</p>';
        }
        
        preview.appendChild(mainContent);

        // Add footer
        const footerTemplate = document.getElementById('footerTemplate');
        const footer = footerTemplate.content.cloneNode(true);
        
        // Update footer content and styles
        const footerElement = footer.querySelector('.site-footer');
        if (footerElement) {
            footerElement.style.backgroundColor = state.footer.styles.bgColor;
            footerElement.style.color = state.footer.styles.textColor;
        }
        
        const footerElements = footer.querySelectorAll('[data-editable]');
        footerElements.forEach(element => {
            const key = element.dataset.editable;
            const [section, field] = key.split('_');
            
            if (state.footer[section] && state.footer[section][field]) {
                element.textContent = state.footer[section][field];
                element.style.color = state.footer.styles.textColor;
            }
        });

        // Update footer links
        const footerLinks = footer.querySelectorAll('a');
        footerLinks.forEach(link => {
            link.style.color = state.footer.styles.linkColor;
            link.addEventListener('mouseover', () => {
                link.style.color = state.footer.styles.linkHoverColor;
            });
            link.addEventListener('mouseout', () => {
                link.style.color = state.footer.styles.linkColor;
            });
        });
        
        preview.appendChild(footer);
    }

    // Save state to server
    async function saveState() {
        try {
            const response = await fetch('asset_manager.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=save_state&state=${encodeURIComponent(JSON.stringify(state))}`
            });

            if (!response.ok) {
                throw new Error('Failed to save changes');
            }

            const data = await response.json();
            if (!data.success) {
                throw new Error(data.error || 'Failed to save changes');
            }

            return true;
        } catch (error) {
            console.error('Error saving state:', error);
            alert('Failed to save changes. Please try again.');
            return false;
        }
    }

    // Add CSS for notifications
    const style = document.createElement('style');
    style.textContent = `
        .save-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            z-index: 1000;
            animation: fadeInOut 2s ease-in-out;
        }

        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--text-color);
        }

        .error {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #dc3545;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(20px); }
            10% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-20px); }
        }
    `;
    document.head.appendChild(style);

    // Initialize preview
    updatePreview();

    // Add header/footer edit button to the preview header
    const previewHeader = document.querySelector('.preview-header');
    if (previewHeader) {
        const editHeaderBtn = document.createElement('button');
        editHeaderBtn.className = 'btn-primary';
        editHeaderBtn.textContent = 'Edit Header/Footer';
        editHeaderBtn.addEventListener('click', () => {
            showHeaderFooterProperties();
        });
        previewHeader.appendChild(editHeaderBtn);
    }

    // Add close button functionality
    const closeButton = document.querySelector('.close-properties');
    if (closeButton) {
        closeButton.addEventListener('click', () => {
            const propertiesPanel = document.getElementById('assetProperties');
            if (propertiesPanel) {
                propertiesPanel.style.display = 'none';
            }
        });
    }

    // Initialize drag and drop functionality
    initializeDragAndDrop();
});

// Show header/footer properties
function showHeaderFooterProperties() {
    const propertiesPanel = document.getElementById('assetProperties');
    const propertiesContent = propertiesPanel.querySelector('.properties-content');
    
    // Clear existing properties
    propertiesContent.innerHTML = '';
    
    // Create temporary state for unsaved changes
    const tempHeaderState = JSON.parse(JSON.stringify(state.header));
    const tempFooterState = JSON.parse(JSON.stringify(state.footer));
    
    // Add header properties
    const headerSection = document.createElement('div');
    headerSection.className = 'property-section';
    headerSection.innerHTML = '<h4>Header Properties</h4>';
    
    // Header Colors
    const headerColorsGroup = document.createElement('div');
    headerColorsGroup.className = 'property-group';
    headerColorsGroup.innerHTML = `
        <label class="property-label">Header Colors</label>
        <div class="color-inputs">
            <div class="color-input">
                <label>Background Color</label>
                <input type="color" class="property-input" value="${tempHeaderState.styles.bgColor}">
            </div>
            <div class="color-input">
                <label>Text Color</label>
                <input type="color" class="property-input" value="${tempHeaderState.styles.textColor}">
            </div>
            <div class="color-input">
                <label>Navigation Color</label>
                <input type="color" class="property-input" value="${tempHeaderState.styles.navColor}">
            </div>
            <div class="color-input">
                <label>Navigation Hover</label>
                <input type="color" class="property-input" value="${tempHeaderState.styles.navHoverColor}">
            </div>
        </div>
    `;

    const headerColorInputs = headerColorsGroup.querySelectorAll('input[type="color"]');
    headerColorInputs.forEach(input => {
        input.addEventListener('input', (e) => {
            const colorType = e.target.parentElement.querySelector('label').textContent.toLowerCase().replace(/\s+/g, '');
            tempHeaderState.styles[colorType] = e.target.value;
        });
    });
    
    headerSection.appendChild(headerColorsGroup);
    
    // Logo
    const logoGroup = document.createElement('div');
    logoGroup.className = 'property-group';
    logoGroup.innerHTML = `
        <label class="property-label">Logo</label>
        <input type="file" class="property-input" accept="image/*">
        <div class="image-preview"></div>
    `;
    
    const logoInput = logoGroup.querySelector('input');
    const logoPreview = logoGroup.querySelector('.image-preview');
    
    if (tempHeaderState.logo) {
        const img = document.createElement('img');
        img.src = tempHeaderState.logo;
        logoPreview.appendChild(img);
    }
    
    logoInput.addEventListener('change', async (e) => {
        const file = e.target.files[0];
        if (file) {
            logoPreview.innerHTML = '<div class="loading">Uploading...</div>';
            
            try {
                const formData = new FormData();
                formData.append('action', 'upload_image');
                formData.append('image', file);
                
                const response = await fetch('asset_manager.php', {
                    method: 'POST',
                    body: formData
                });
                
                if (!response.ok) throw new Error('Upload failed');
                
                const data = await response.json();
                if (data.success) {
                    tempHeaderState.logo = data.url;
                    logoPreview.innerHTML = `<img src="${data.url}">`;
                } else {
                    throw new Error(data.error || 'Upload failed');
                }
            } catch (error) {
                console.error('Error uploading logo:', error);
                logoPreview.innerHTML = '<div class="error">Upload failed</div>';
            }
        }
    });
    
    headerSection.appendChild(logoGroup);
    
    // Title
    const titleGroup = document.createElement('div');
    titleGroup.className = 'property-group';
    titleGroup.innerHTML = `
        <label class="property-label">Site Title</label>
        <input type="text" class="property-input" value="${tempHeaderState.title}">
    `;
    
    titleGroup.querySelector('input').addEventListener('input', (e) => {
        tempHeaderState.title = e.target.value;
    });
    
    headerSection.appendChild(titleGroup);
    
    // Navigation
    Object.entries(tempHeaderState.nav).forEach(([key, value]) => {
        const navGroup = document.createElement('div');
        navGroup.className = 'property-group';
        navGroup.innerHTML = `
            <label class="property-label">${key.charAt(0).toUpperCase() + key.slice(1)} Link</label>
            <input type="text" class="property-input" value="${value}">
        `;
        
        navGroup.querySelector('input').addEventListener('input', (e) => {
            tempHeaderState.nav[key] = e.target.value;
        });
        
        headerSection.appendChild(navGroup);
    });
    
    propertiesContent.appendChild(headerSection);
    
    // Add footer properties
    const footerSection = document.createElement('div');
    footerSection.className = 'property-section';
    footerSection.innerHTML = '<h4>Footer Properties</h4>';
    
    // Footer Colors
    const footerColorsGroup = document.createElement('div');
    footerColorsGroup.className = 'property-group';
    footerColorsGroup.innerHTML = `
        <label class="property-label">Footer Colors</label>
        <div class="color-inputs">
            <div class="color-input">
                <label>Background Color</label>
                <input type="color" class="property-input" value="${tempFooterState.styles.bgColor}">
            </div>
            <div class="color-input">
                <label>Text Color</label>
                <input type="color" class="property-input" value="${tempFooterState.styles.textColor}">
            </div>
            <div class="color-input">
                <label>Link Color</label>
                <input type="color" class="property-input" value="${tempFooterState.styles.linkColor}">
            </div>
            <div class="color-input">
                <label>Link Hover</label>
                <input type="color" class="property-input" value="${tempFooterState.styles.linkHoverColor}">
            </div>
        </div>
    `;

    const footerColorInputs = footerColorsGroup.querySelectorAll('input[type="color"]');
    footerColorInputs.forEach(input => {
        input.addEventListener('input', (e) => {
            const colorType = e.target.parentElement.querySelector('label').textContent.toLowerCase().replace(/\s+/g, '');
            tempFooterState.styles[colorType] = e.target.value;
        });
    });
    
    footerSection.appendChild(footerColorsGroup);
    
    // Contact Information
    Object.entries(tempFooterState.contact).forEach(([key, value]) => {
        const contactGroup = document.createElement('div');
        contactGroup.className = 'property-group';
        contactGroup.innerHTML = `
            <label class="property-label">${key.charAt(0).toUpperCase() + key.slice(1)}</label>
            <input type="text" class="property-input" value="${value}">
        `;
        
        contactGroup.querySelector('input').addEventListener('input', (e) => {
            tempFooterState.contact[key] = e.target.value;
        });
        
        footerSection.appendChild(contactGroup);
    });
    
    // Social Links
    Object.entries(tempFooterState.social).forEach(([key, value]) => {
        const socialGroup = document.createElement('div');
        socialGroup.className = 'property-group';
        socialGroup.innerHTML = `
            <label class="property-label">${key.charAt(0).toUpperCase() + key.slice(1)}</label>
            <input type="text" class="property-input" value="${value}">
        `;
        
        socialGroup.querySelector('input').addEventListener('input', (e) => {
            tempFooterState.social[key] = e.target.value;
        });
        
        footerSection.appendChild(socialGroup);
    });
    
    // Copyright
    const copyrightGroup = document.createElement('div');
    copyrightGroup.className = 'property-group';
    copyrightGroup.innerHTML = `
        <label class="property-label">Copyright Text</label>
        <input type="text" class="property-input" value="${tempFooterState.copyright}">
    `;
    
    copyrightGroup.querySelector('input').addEventListener('input', (e) => {
        tempFooterState.copyright = e.target.value;
    });
    
    footerSection.appendChild(copyrightGroup);
    propertiesContent.appendChild(footerSection);

    // Add save button
    const saveButton = document.createElement('button');
    saveButton.className = 'btn-primary save-properties-btn';
    saveButton.textContent = 'Save Changes';
    saveButton.addEventListener('click', () => {
        // Update the actual state with temporary changes
        state.header = tempHeaderState;
        state.footer = tempFooterState;
        updatePreview();
        saveState().then(() => {
            const notification = document.createElement('div');
            notification.className = 'save-notification';
            notification.textContent = 'Changes saved';
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 2000);
        });
    });
    propertiesContent.appendChild(saveButton);
    
    // Show the panel
    propertiesPanel.style.display = 'block';
}

function initializeDragAndDrop() {
    const previewContainer = document.querySelector('.preview-container');
    const assets = previewContainer.querySelectorAll('.asset-preview');

    assets.forEach(asset => {
        // Add drag handle
        const dragHandle = document.createElement('div');
        dragHandle.className = 'drag-handle';
        asset.insertBefore(dragHandle, asset.firstChild);
        
        // Make only the drag handle draggable
        dragHandle.setAttribute('draggable', 'true');
        
        dragHandle.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/plain', asset.id);
            asset.classList.add('dragging');
        });

        dragHandle.addEventListener('dragend', () => {
            asset.classList.remove('dragging');
        });
    });

    previewContainer.addEventListener('dragover', (e) => {
        e.preventDefault();
        const draggingAsset = previewContainer.querySelector('.dragging');
        if (!draggingAsset) return;
        
        const siblings = [...previewContainer.querySelectorAll('.asset-preview:not(.dragging)')];
        
        const nextSibling = siblings.find(sibling => {
            const box = sibling.getBoundingClientRect();
            const offset = e.clientY - box.top - box.height / 2;
            return offset < 0;
        });

        previewContainer.insertBefore(draggingAsset, nextSibling);
    });

    previewContainer.addEventListener('drop', (e) => {
        e.preventDefault();
        saveAssetOrder();
    });
}

function saveAssetOrder() {
    const previewContainer = document.querySelector('.preview-container');
    const assets = previewContainer.querySelectorAll('.asset-preview');
    const order = Array.from(assets).map(asset => asset.id);
    
    // Update the state with new order
    state.assets = order.map(id => {
        return state.assets.find(asset => asset.id === id);
    });
    
    // Save to localStorage
    localStorage.setItem('cmsState', JSON.stringify(state));
}

// Update addAssetToPreview function
function addAssetToPreview(asset) {
    const previewContainer = document.querySelector('.preview-container');
    const assetElement = document.createElement('div');
    assetElement.className = 'asset-preview';
    assetElement.id = asset.id;
    
    // Add drag handle
    const dragHandle = document.createElement('div');
    dragHandle.className = 'drag-handle';
    assetElement.appendChild(dragHandle);
    
    // Add asset content
    assetElement.innerHTML += asset.html;
    
    // Make only the drag handle draggable
    dragHandle.setAttribute('draggable', 'true');
    
    dragHandle.addEventListener('dragstart', (e) => {
        e.dataTransfer.setData('text/plain', assetElement.id);
        assetElement.classList.add('dragging');
    });

    dragHandle.addEventListener('dragend', () => {
        assetElement.classList.remove('dragging');
    });
    
    previewContainer.appendChild(assetElement);
}

// Add to the existing initialize function
function initialize() {
    // ... existing code ...
    
    // Initialize drag and drop for existing assets
    initializeDragAndDrop();
} 