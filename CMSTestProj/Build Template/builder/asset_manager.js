// Initialize state from PHP
let state = window.assetState || {
    assets: [],
    styles: [],
    currentPage: 'home', // Add current page tracking
    pages: {
        home: { title: 'Home', assets: {} },
        about: { title: 'About', assets: {} },
        admissions: { title: 'Admissions', assets: {} },
        contact: { title: 'Contact', assets: {} }
    },
    header: {
        logo: 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="200" height="50" viewBox="0 0 200 50"%3E%3Crect width="200" height="50" fill="%23f0f0f0"/%3E%3Ctext x="50%25" y="50%25" dominant-baseline="middle" text-anchor="middle" font-family="Arial" font-size="16" fill="%23999"%3EUniversity Logo%3C/text%3E%3C/svg%3E',
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

// Function to update preview with current state
function updatePreview() {
    try {
        console.log('Updating preview with current state');
        const preview = document.getElementById('preview');
        if (!preview) {
            console.error('Preview element not found');
            return;
        }

        // Clear preview content except header and footer
        while (preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }

        // Add header if it exists in state
        if (state.header) {
            const headerTemplate = document.getElementById('headerTemplate');
            if (headerTemplate) {
                const header = document.importNode(headerTemplate.content, true);
                
                // Apply state to header elements
                const siteLogo = header.querySelector('.site-logo');
                if (siteLogo && state.header.logo) {
                    siteLogo.src = state.header.logo;
                }
                
                const siteTitle = header.querySelector('.site-title');
                if (siteTitle && state.header.title) {
                    siteTitle.textContent = state.header.title;
                }
                
                const navLinks = header.querySelectorAll('.main-nav a');
                if (navLinks.length && state.header.nav) {
                    const navKeys = Object.keys(state.header.nav);
                    for (let i = 0; i < Math.min(navLinks.length, navKeys.length); i++) {
                        navLinks[i].textContent = state.header.nav[navKeys[i]];
                        navLinks[i].setAttribute('data-page-target', navKeys[i]);
                    }
                }
                
                // Apply header styles
                const headerElement = header.querySelector('.site-header');
                if (headerElement && state.header.styles) {
                    headerElement.style.backgroundColor = state.header.styles.bgColor || '';
                    headerElement.style.color = state.header.styles.textColor || '';
                    
                    const navItems = header.querySelectorAll('.main-nav a');
                    navItems.forEach(item => {
                        item.style.color = state.header.styles.navColor || '';
                    });
                }
                
                preview.appendChild(header);
            }
        }

        // Add assets to preview
        if (state.assets) {
            // Sort assets by position if they have position property
            const sortedAssets = Object.entries(state.assets).sort((a, b) => {
                const posA = a[1].position || 0;
                const posB = b[1].position || 0;
                return posA - posB;
            });
            
            for (const [assetId, asset] of sortedAssets) {
                addAssetToPreview(asset, assetId);
            }
        }

        // Add footer if it exists in state
        if (state.footer) {
            const footerTemplate = document.getElementById('footerTemplate');
            if (footerTemplate) {
                const footer = document.importNode(footerTemplate.content, true);
                
                // Apply state to footer elements
                const contactTitle = footer.querySelector('[data-editable="footer_contact_title"]');
                if (contactTitle && state.footer.contact?.title) {
                    contactTitle.textContent = state.footer.contact.title;
                }
                
                const address = footer.querySelector('[data-editable="footer_address"]');
                if (address && state.footer.contact?.address) {
                    address.textContent = state.footer.contact.address;
                }
                
                const phone = footer.querySelector('[data-editable="footer_phone"]');
                if (phone && state.footer.contact?.phone) {
                    phone.textContent = state.footer.contact.phone;
                }
                
                const email = footer.querySelector('[data-editable="footer_email"]');
                if (email && state.footer.contact?.email) {
                    email.textContent = state.footer.contact.email;
                }
                
                const socialTitle = footer.querySelector('[data-editable="footer_social_title"]');
                if (socialTitle && state.footer.social?.title) {
                    socialTitle.textContent = state.footer.social.title;
                }
                
                const socialLinks = footer.querySelectorAll('.social-links a');
                if (socialLinks.length && state.footer.social) {
                    const socialKeys = ['facebook', 'twitter', 'instagram'];
                    for (let i = 0; i < Math.min(socialLinks.length, socialKeys.length); i++) {
                        if (state.footer.social[socialKeys[i]]) {
                            socialLinks[i].textContent = state.footer.social[socialKeys[i]];
                        }
                    }
                }
                
                const copyright = footer.querySelector('[data-editable="footer_copyright"]');
                if (copyright && state.footer.copyright) {
                    copyright.textContent = state.footer.copyright;
                }
                
                // Apply footer styles
                const footerElement = footer.querySelector('.site-footer');
                if (footerElement && state.footer.styles) {
                    footerElement.style.backgroundColor = state.footer.styles.bgColor || '';
                    footerElement.style.color = state.footer.styles.textColor || '';
                    
                    const links = footer.querySelectorAll('a');
                    links.forEach(link => {
                        link.style.color = state.footer.styles.linkColor || '';
                    });
                }
                
                preview.appendChild(footer);
            }
        }
        
        console.log('Preview updated successfully');
    } catch (error) {
        console.error('Error updating preview:', error);
    }
}

// Track if assets should be saved to page-specific storage
let savingToPage = true;

// Track if there are unsaved changes
let hasUnsavedChanges = false;
let lastSaveTime = Date.now();
let saveTimeout = null;
let currentPageId = '';

// Function to add asset to preview
function addAssetToPreview(asset, assetId) {
    const preview = document.getElementById('preview');
    if (!preview) {
        console.error('Preview element not found when adding asset');
        return;
    }
    
    console.log('Adding asset to preview:', assetId, asset.type);
    
    // Calculate position for new asset (if not already set)
    if (!asset.position) {
        // Count existing assets to determine next position
        const existingAssets = Object.values(state.assets || {});
        const maxPosition = existingAssets.reduce((max, a) => 
            Math.max(max, a.position || 0), 0);
        asset.position = maxPosition + 1;
        console.log('Assigned position', asset.position, 'to new asset');
    }
    
    try {
        // Create asset container
        const container = document.createElement('div');
        container.className = 'asset';
        container.dataset.assetId = assetId;
        container.dataset.position = asset.position;
        
        // Add asset HTML
        container.innerHTML = asset.html;
        
        // Apply global styles to asset if available
        if (state.globalStyles) {
            const headings = container.querySelectorAll('h1, h2, h3, h4, h5, h6');
            headings.forEach(heading => {
                heading.style.fontFamily = state.globalStyles.fontFamily || 'inherit';
                heading.style.color = state.globalStyles.primaryColor || 'inherit';
            });
            
            const paragraphs = container.querySelectorAll('p');
            paragraphs.forEach(p => {
                p.style.fontFamily = state.globalStyles.fontFamily || 'inherit';
                p.style.color = state.globalStyles.secondaryColor || 'inherit';
            });
            
            const buttons = container.querySelectorAll('button, .btn');
            buttons.forEach(button => {
                button.style.backgroundColor = state.globalStyles.primaryColor || '#4A90E2';
                button.style.color = state.globalStyles.backgroundColor || '#ffffff';
                button.style.fontFamily = state.globalStyles.fontFamily || 'inherit';
            });
        }
        
        // Add position number and edit controls
        const controls = document.createElement('div');
        controls.className = 'asset-controls';
        controls.innerHTML = `
            <div class="position-indicator" title="Position">${asset.position || 1}</div>
            <button class="edit-btn" title="Edit">✎</button>
            <button class="delete-btn" title="Delete">×</button>
        `;
        container.appendChild(controls);
        
        // Add event listeners for edit and delete buttons
        controls.querySelector('.edit-btn').addEventListener('click', () => {
            console.log('Edit button clicked for asset:', assetId);
            showProperties(assetId);
        });
        
        controls.querySelector('.delete-btn').addEventListener('click', () => {
            console.log('Delete button clicked for asset:', assetId);
            if (confirm('Are you sure you want to delete this asset?')) {
                delete state.assets[assetId];
                updatePreview();
                saveState();
                closeProperties();
            }
        });
        
        // Apply any properties if available
        if (asset.properties) {
            console.log('Applying properties to asset elements');
            Object.entries(asset.properties).forEach(([key, prop]) => {
                const element = container.querySelector(prop.selector);
                if (element) {
                    if (prop.type === 'image') {
                        element.src = prop.value || '';
                    } else if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                        element.value = prop.value || '';
                    } else {
                        element.textContent = prop.value || '';
                    }
                }
            });
        }
        
        preview.appendChild(container);
        console.log('Asset added to preview successfully');
    } catch (error) {
        console.error('Error adding asset to preview:', error);
    }
}

// Get the page_id from URL
function getPageIdFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('page_id') || '';
}

// Function to show error messages
function showError(message) {
    const preview = document.getElementById('preview');
    if (preview && !preview.querySelector('.error-message')) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.innerHTML = `
            <div style="background-color: #ffebee; color: #c62828; padding: 15px; margin: 20px; border-radius: 4px; border-left: 4px solid #c62828;">
                <strong>Error:</strong> ${message}
                <button onclick="this.parentNode.remove()" style="float: right; background: none; border: none; color: #c62828; cursor: pointer; font-weight: bold;">×</button>
            </div>
        `;
        preview.insertAdjacentElement('afterbegin', errorDiv);
    }
}

// Function to show notifications
function showNotification(message, type = 'info') {
    // Create notification container if it doesn't exist
    let notificationContainer = document.querySelector('.notification-container');
    if (!notificationContainer) {
        notificationContainer = document.createElement('div');
        notificationContainer.className = 'notification-container';
        document.body.appendChild(notificationContainer);
    }
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = 'notification ' + type;
    notification.textContent = message;
    
    // Add to container
    notificationContainer.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Function to mark changes as unsaved
function markAsUnsaved() {
    hasUnsavedChanges = true;
    
    // Clear any existing save timeout
    if (saveTimeout) {
        clearTimeout(saveTimeout);
    }
    
    // Set a visual indicator that changes are unsaved
    const saveButton = document.getElementById('savePreview');
    if (saveButton) {
        saveButton.classList.add('unsaved');
        saveButton.textContent = 'Save Changes*';
    }
    
    // Set auto-save timeout (every 30 seconds)
    saveTimeout = setTimeout(() => {
        if (hasUnsavedChanges) {
            saveState();
        }
    }, 30000);
}

// Function to load user assets from the database
async function loadUserAssets() {
    try {
        console.log('Loading user assets from database');
        
        // Get page_id from URL parameter
        currentPageId = getPageIdFromUrl();
        if (!currentPageId) {
            console.warn('No page_id found in URL, using default page');
            currentPageId = 'homepage';
        }
        
        console.log('Loading assets for page_id:', currentPageId);
        
        // Show loading message in preview
        const preview = document.getElementById('preview');
        if (preview) {
            preview.innerHTML = '<div class="loading" style="text-align: center; padding: 50px; font-size: 16px;">Loading your assets...</div>';
        }
        
        const response = await fetch('asset_manager.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=load_user_assets&page_id=${encodeURIComponent(currentPageId)}`
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Load user assets response:', data);
        
        if (data.success && data.state) {
            // Update state with loaded data
            state = data.state;
            console.log('State updated from database:', state);
            
            // Update the preview with the loaded assets
            updatePreview();
            
            // Show success message
            showNotification('Assets loaded successfully');
        } else {
            console.error('Failed to load assets:', data.error || 'Unknown error');
            showError('Failed to load assets: ' + (data.error || 'Unknown error'));
            
            // Still update preview with default state
            updatePreview();
        }
    } catch (error) {
        console.error('Error loading user assets:', error);
        showError('Error loading assets: ' + error.message);
        
        // Continue with session state if there's an error loading from DB
        updatePreview();
    }
}

// Function to cleanup unsaved data from database
async function cleanupUnsavedData() {
    try {
        // Only attempt cleanup if the last save was more than 10 seconds ago
        // This prevents cleanup during normal save operations
        if (Date.now() - lastSaveTime > 10000) {
            console.log('Cleaning up unsaved data...');
            
            const pageId = currentPageId || getPageIdFromUrl() || 'homepage';
            
            // Call cleanup endpoint
            await fetch('asset_manager.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=cleanup_unsaved&page_id=${encodeURIComponent(pageId)}&last_save=${lastSaveTime}`
            });
            
            console.log('Cleanup request sent');
        }
    } catch (error) {
        console.error('Error during cleanup:', error);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM content loaded - setting up event handlers');
    
    // Add CSS for notifications
    const style = document.createElement('style');
    style.textContent = `
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 300px;
        }
        .notification {
            background: white;
            border-left: 4px solid #4A90E2;
            padding: 12px;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slide-in 0.3s ease;
        }
        .notification.closing {
            animation: slide-out 0.3s ease forwards;
        }
        .notification.success {
            border-left-color: #4CAF50;
        }
        .notification.error {
            border-left-color: #F44336;
        }
        .notification-content {
            margin-right: 8px;
        }
        .notification-close {
            background: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
            padding: 0 4px;
        }
        @keyframes slide-in {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slide-out {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
    
    // Load user assets from database
    loadUserAssets();
    
    // Setup window unload warning for unsaved changes
    window.addEventListener('beforeunload', function(e) {
        // If there are unsaved changes, show a warning
        if (hasUnsavedChanges) {
            // Attempt to cleanup unsaved data
            cleanupUnsavedData();
            
            // Standard message (browsers will show their own message)
            const message = 'You have unsaved changes that will be lost if you leave this page.';
            e.returnValue = message;
            return message;
        }
    });
    
    // Save button click handler
    const saveButton = document.getElementById('savePreview');
    if (saveButton) {
        saveButton.addEventListener('click', function() {
            saveState();
        });
    }
    
    // Ensure page tabs work - failsafe direct navigation
    function setupPageTabNavigation() {
        console.log('Setting up page tab navigation');
        const pageTabs = document.querySelectorAll('.page-tab');
        console.log('Found page tabs:', pageTabs.length);
        
        // Add a backup click handler in case the href doesn't work
        pageTabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                const pageKey = this.getAttribute('data-page');
                if (pageKey) {
                    console.log('Page tab clicked for:', pageKey);
                    
                    // Navigate directly to the page with the correct parameter
                    window.location.href = '?page=' + pageKey;
                    
                    // Prevent default to avoid double navigation
                    e.preventDefault();
                    return false;
                }
            });
        });
    }
    
    // Setup page tab navigation
    setTimeout(setupPageTabNavigation, 100); // Small delay to ensure DOM is ready
    
    // Setup tab navigation
    function setupNavigation() {
        const navLinks = document.querySelectorAll('.main-nav .nav-link');
        console.log('Found navigation links:', navLinks.length);
        
        navLinks.forEach(link => {
            const pageTarget = link.getAttribute('data-page-target');
            console.log('Setting up navigation for:', pageTarget);
            
            // Remove any existing listeners and set up new ones
            const newLink = link.cloneNode(true);
            if (link.parentNode) {
                link.parentNode.replaceChild(newLink, link);
                
                newLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Navigation clicked for page:', pageTarget);
                    switchPage(pageTarget);
                    return false;
                });
            }
        });
    }
    
    // Setup initial navigation
    setTimeout(setupNavigation, 500); // Short delay to ensure DOM is ready
    
    // Re-attach navigation after each preview update
    const originalUpdatePreview = updatePreview;
    updatePreview = function() {
        originalUpdatePreview.apply(this, arguments);
        setTimeout(setupNavigation, 100);
    };
    
    // Asset button click handlers
    const assetButtons = document.querySelectorAll('.asset-btn');
    console.log('Found asset buttons:', assetButtons.length);
    
    assetButtons.forEach(button => {
        button.addEventListener('click', async () => {
            console.log('Asset button clicked:', button.textContent.trim());
            const assetType = button.dataset.asset;
            
            // Disable button and show loading state
            button.disabled = true;
            const originalText = button.textContent;
            button.textContent = 'Loading...';
            
            try {
                console.log('Loading asset:', assetType);
                const response = await fetch('asset_manager.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=load_asset&asset=${encodeURIComponent(assetType)}`
                });

                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                console.log('Asset response received:', data);
                
                if (data.success && data.html && data.css) {
                    // Generate unique ID for the asset
                    const assetId = `asset_${Date.now()}`;
                    console.log('Generated asset ID:', assetId);
                    
                    // Continue with the rest of your asset processing...
                    // ...
                    
                    // Extract asset properties for configuration
                    const properties = extractProperties(data.html);
                    console.log('Extracted properties:', properties);
                    
                    // Create asset in state
                    state.assets[assetId] = {
                        type: assetType,
                        html: data.html,
                        css: data.css,
                        config: {},
                        properties: properties
                    };
                    
                    // Initialize config with default values
                    for (const key in properties) {
                        if (properties[key].default) {
                            state.assets[assetId].config[key] = properties[key].default;
                        }
                    }
                    
                    // Add asset to preview
                    addAssetToPreview(state.assets[assetId], assetId);
                    
                    // Show asset properties panel
                    showProperties(assetId);
                    
                    // Mark the state as unsaved
                    markAsUnsaved();
                    
                    // Show success notification
                    showNotification(`Added ${assetType.replace(/-/g, ' ')} to page`, 'success');
                } else {
                    console.error('Failed to load asset:', data.error || 'Unknown error');
                    showNotification(`Failed to load ${assetType}: ${data.error || 'Unknown error'}`, 'error');
                }
            } catch (error) {
                console.error('Error loading asset:', error);
                showNotification(`Error loading asset: ${error.message}`, 'error');
            } finally {
                // Re-enable button
                button.disabled = false;
                button.textContent = originalText;
            }
        });
    });
    
    // Handler for Edit Header & Footer button
    const editHeaderFooterBtn = document.getElementById('editHeaderFooter');
    if (editHeaderFooterBtn) {
        editHeaderFooterBtn.addEventListener('click', showHeaderFooterProperties);
    }
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
    const tempPagesState = JSON.parse(JSON.stringify(state.pages));
    
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
    
    // Add page properties section
    const pagesSection = document.createElement('div');
    pagesSection.className = 'property-section';
    pagesSection.innerHTML = '<h4>Page Titles</h4><p class="section-description">Edit the titles for each page of your website</p>';
    
    // Create inputs for each page title
    Object.entries(tempPagesState).forEach(([pageKey, pageData]) => {
        const pageGroup = document.createElement('div');
        pageGroup.className = 'property-group';
        pageGroup.innerHTML = `
            <label class="property-label">${pageKey.charAt(0).toUpperCase() + pageKey.slice(1)} Page Title</label>
            <input type="text" class="property-input" data-page-key="${pageKey}" value="${pageData.title || pageKey}">
        `;
        
        // Update temporary state when input changes
        pageGroup.querySelector('input').addEventListener('input', (e) => {
            const pageKey = e.target.dataset.pageKey;
            tempPagesState[pageKey].title = e.target.value;
        });
        
        pagesSection.appendChild(pageGroup);
    });
    
    propertiesContent.appendChild(pagesSection);
    
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
    saveButton.className = 'save-properties-btn';
    saveButton.textContent = 'Save Changes';
    saveButton.addEventListener('click', async () => {
        try {
            console.log('Saving header/footer/page changes...'); // Debug log
            
            // Update the actual state with temporary changes
            state.header = tempHeaderState;
            state.footer = tempFooterState;
            state.pages = tempPagesState;
            
            console.log('Updated state:', state); // Debug log
            
            // Update preview directly
            updatePreview();
            
            // Save state to server directly
            const response = await fetch('asset_manager.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=save_state&page_id=${encodeURIComponent(currentPageId)}&state=${encodeURIComponent(JSON.stringify(state))}`
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            if (!data.success) {
                throw new Error(data.error || 'Failed to save changes');
            }

            // Show success notification
            const notification = document.createElement('div');
            notification.className = 'save-notification';
            notification.textContent = 'Changes saved';
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 2000);
            
            // Close properties panel
            closeProperties();
        } catch (error) {
            console.error('Error saving header/footer changes:', error);
            alert(`Failed to save changes: ${error.message}`);
        }
    });
    propertiesContent.appendChild(saveButton);
    
    // Show the panel
    propertiesPanel.classList.add('active');
}

// We no longer need the initializeDragAndDrop function since we're using numbered positions

function saveAssetOrder() {
    // Make sure each asset has a position
    Object.entries(state.assets).forEach(([id, asset], index) => {
        if (!asset.position) {
            asset.position = index + 1;
        }
    });
    
    // Save the state
    saveState();
}

// Update the closeProperties function
function closeProperties() {
    const propertiesPanel = document.getElementById('assetProperties');
    if (propertiesPanel) {
        propertiesPanel.classList.remove('active');
    }
}

// Function to show asset properties panel
function showProperties(assetId) {
    const asset = state.assets[assetId];
    if (!asset) {
        console.error('Asset not found:', assetId);
        return;
    }
    
    const propertiesPanel = document.getElementById('assetProperties');
    const propertiesContent = propertiesPanel.querySelector('.properties-content');
    
    // Clear existing properties
    propertiesContent.innerHTML = '';
    
    // Create properties UI based on asset type and properties
    if (asset.properties) {
        Object.entries(asset.properties).forEach(([key, prop]) => {
            // Skip if property has no selector or type
            if (!prop.selector || !prop.type) return;
            
            let propTemplate;
            switch (prop.type) {
                case 'text':
                    propTemplate = document.getElementById('textProperty');
                    break;
                case 'image':
                    propTemplate = document.getElementById('imageProperty');
                    break;
                case 'color':
                    propTemplate = document.getElementById('colorProperty');
                    break;
                case 'font':
                    propTemplate = document.getElementById('fontProperty');
                    break;
                default:
                    propTemplate = document.getElementById('textProperty');
            }
            
            if (propTemplate) {
                const propElement = document.importNode(propTemplate.content, true);
                const label = propElement.querySelector('.property-label');
                const input = propElement.querySelector('.property-input');
                
                // Set property name as label
                label.textContent = key.charAt(0).toUpperCase() + key.slice(1).replace(/_/g, ' ');
                
                // Set current value
                if (prop.type === 'image') {
                    const preview = propElement.querySelector('.image-preview');
                    if (preview && prop.value) {
                        const img = document.createElement('img');
                        img.src = prop.value;
                        preview.appendChild(img);
                    }
                } else {
                    input.value = prop.value || '';
                }
                
                // Add change listener
                input.addEventListener('change', async (e) => {
                    if (prop.type === 'image' && e.target.files && e.target.files[0]) {
                        const file = e.target.files[0];
                        const preview = propElement.querySelector('.image-preview');
                        
                        // Simple image upload handling
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            prop.value = e.target.result;
                            
                            // Update preview
                            preview.innerHTML = '';
                            const img = document.createElement('img');
                            img.src = prop.value;
                            preview.appendChild(img);
                            
                            // Update asset in preview
                            updatePreview();
                        };
                        reader.readAsDataURL(file);
                    } else {
                        prop.value = e.target.value;
                        updatePreview();
                    }
                    
                    // Mark as unsaved
                    if (typeof markAsUnsaved === 'function') {
                        markAsUnsaved();
                    }
                });
                
                propertiesContent.appendChild(propElement);
            }
        });
    } else {
        propertiesContent.innerHTML = '<p>No properties available for this asset.</p>';
    }
    
    // Add save button
    const saveButton = document.createElement('button');
    saveButton.className = 'save-properties-btn';
    saveButton.textContent = 'Save Changes';
    saveButton.addEventListener('click', () => {
        saveState();
        closeProperties();
    });
    propertiesContent.appendChild(saveButton);
    
    // Show the properties panel
    propertiesPanel.classList.add('active');
}

// Extract properties from HTML template
function extractProperties(html) {
    const properties = {};
    const tempContainer = document.createElement('div');
    tempContainer.innerHTML = html;
    
    const editableElements = tempContainer.querySelectorAll('[data-editable]');
    editableElements.forEach(el => {
        const name = el.dataset.editable;
        const type = el.dataset.type || 'text';
        let value = '';
        
        if (type === 'image' && el.tagName === 'IMG') {
            value = el.src;
        } else if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
            value = el.value;
        } else {
            value = el.textContent.trim();
        }
        
        properties[name] = {
            type,
            selector: `[data-editable="${name}"]`,
            value,
            default: value
        };
    });
    
    return properties;
}

// Add this function to handle photo gallery properties
function showPhotoGalleryProperties(assetId) {
    const propertiesPanel = document.getElementById('assetProperties');
    const propertiesContent = propertiesPanel.querySelector('.properties-content');
    
    // Clear existing properties
    propertiesContent.innerHTML = '';
    
    // Get the asset from state
    const asset = state.assets.find(a => a.id === assetId);
    if (!asset) {
        console.error('Asset not found:', assetId);
        return;
    }
    
    // Create temporary state for unsaved changes
    const tempState = {
        title: asset.properties?.title?.value || 'Photo Gallery',
        photos: {}
    };
    
    // Initialize photos from asset properties
    for (let i = 1; i <= 4; i++) {
        tempState.photos[`photo${i}`] = {
            url: asset.properties[`photo${i}`]?.value || '',
            caption: asset.properties[`caption${i}`]?.value || ''
        };
    }
    
    // Add title property
    const titleGroup = document.createElement('div');
    titleGroup.className = 'property-group';
    titleGroup.innerHTML = `
        <label>Gallery Title</label>
        <input type="text" class="property-input" value="${tempState.title}" 
               data-property="title">
    `;
    propertiesContent.appendChild(titleGroup);
    
    // Add photo properties
    for (let i = 1; i <= 4; i++) {
        const photoGroup = document.createElement('div');
        photoGroup.className = 'property-group';
        photoGroup.innerHTML = `
            <label>Photo ${i}</label>
            <input type="file" class="property-input" accept="image/*" data-property="photo${i}">
            <div class="image-preview"></div>
            <label>Caption ${i}</label>
            <input type="text" class="property-input" value="${tempState.photos[`photo${i}`].caption}" 
                   data-property="caption${i}">
        `;
        
        // Add image preview
        const imagePreview = photoGroup.querySelector('.image-preview');
        if (tempState.photos[`photo${i}`].url) {
            const img = document.createElement('img');
            img.src = tempState.photos[`photo${i}`].url;
            imagePreview.appendChild(img);
        }
        
        // Handle image upload
        const imageInput = photoGroup.querySelector('input[type="file"]');
        imageInput.addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (file) {
                imagePreview.innerHTML = '<div class="loading">Uploading...</div>';
                
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
                        tempState.photos[`photo${i}`].url = data.url;
                        imagePreview.innerHTML = `<img src="${data.url}">`;
                        console.log('Photo uploaded successfully:', data.url);
                        
                        // Update asset properties
                        if (!asset.properties[`photo${i}`]) {
                            asset.properties[`photo${i}`] = { type: 'image', value: '' };
                        }
                        asset.properties[`photo${i}`].value = data.url;
                        
                        // Update preview
                        updatePreview();
                    } else {
                        throw new Error(data.error || 'Upload failed');
                    }
                } catch (error) {
                    console.error('Error uploading photo:', error);
                    imagePreview.innerHTML = '<div class="error">Upload failed</div>';
                }
            }
        });
        
        // Handle caption changes
        const captionInput = photoGroup.querySelector('input[type="text"]');
        captionInput.addEventListener('input', (e) => {
            tempState.photos[`photo${i}`].caption = e.target.value;
            
            // Update asset properties
            if (!asset.properties[`caption${i}`]) {
                asset.properties[`caption${i}`] = { type: 'text', value: '' };
            }
            asset.properties[`caption${i}`].value = e.target.value;
            
            // Update preview
            updatePreview();
        });
        
        propertiesContent.appendChild(photoGroup);
    }
    
    // Add save button
    const saveButton = document.createElement('button');
    saveButton.className = 'save-properties-btn';
    saveButton.textContent = 'Save Changes';
    saveButton.addEventListener('click', async () => {
        try {
            console.log('Saving photo gallery changes...');
            
            // Update title in asset properties
            if (!asset.properties.title) {
                asset.properties.title = { type: 'text', value: '' };
            }
            asset.properties.title.value = tempState.title;
            
            // Save state to server
            const response = await fetch('asset_manager.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=save_state&page_id=${encodeURIComponent(currentPageId)}&state=${encodeURIComponent(JSON.stringify(state))}`
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            if (!data.success) {
                throw new Error(data.error || 'Failed to save changes');
            }

            // Show success notification
            const notification = document.createElement('div');
            notification.className = 'save-notification';
            notification.textContent = 'Changes saved';
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 2000);
            
            // Close properties panel
            closeProperties();
            
            // Force preview update
            updatePreview();
        } catch (error) {
            console.error('Error saving photo gallery changes:', error);
            alert(`Failed to save changes: ${error.message}`);
        }
    });
    propertiesContent.appendChild(saveButton);
    
    // Show the panel
    propertiesPanel.classList.add('active');
}

function openAssetEditor(assetType) {
    switch (assetType) {
        case 'hero':
            // Logic to load the hero asset editor
            loadHeroAssetEditor(); // You would define this function to handle the hero asset
            break;
        // Add cases for other asset types as needed
        default:
            console.error('Unknown asset type:', assetType);
    }
}

function showIntroVideoProperties(assetId) {
    const propertiesPanel = document.getElementById('assetProperties');
    const propertiesContent = propertiesPanel.querySelector('.properties-content');
    
    // Clear existing properties
    propertiesContent.innerHTML = '';

    // Get the asset from the state
    const asset = state.assets[assetId];
    if (!asset) {
        console.error('Asset not found:', assetId);
        return;
    }

    // Create video upload property group
    const videoGroup = document.createElement('div');
    videoGroup.className = 'property-group';
    videoGroup.innerHTML = `
        <label class="property-label">Upload Video</label>
        <input type="file" class="property-input" accept="video/mp4">
        <div class="video-preview"></div>
    `;

    const videoInput = videoGroup.querySelector('input[type="file"]');
    const videoPreview = videoGroup.querySelector('.video-preview');

    // Load existing video URL if available
    if (asset.properties.video_url) {
        const videoElement = document.createElement('video');
        videoElement.src = asset.properties.video_url;
        videoElement.controls = true;
        videoPreview.appendChild(videoElement);
    }

    videoInput.addEventListener('change', async (e) => {
        const file = e.target.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('action', 'upload_video');
            formData.append('video', file);

            try {
                const response = await fetch('asset_manager.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) throw new Error('Upload failed');

                const data = await response.json();
                if (data.success) {
                    // Update asset properties with the new video URL
                    asset.properties.video_url = data.url;
                    videoPreview.innerHTML = `<video src="${data.url}" controls></video>`;
                } else {
                    throw new Error(data.error || 'Upload failed');
                }
            } catch (error) {
                console.error('Error uploading video:', error);
                alert('Failed to upload video. Please try again.');
            }
        }
    });

    propertiesContent.appendChild(videoGroup);
}

// Reorder assets when position changes (for global assets)
function reorderAssets(assetId, oldPosition, newPosition) {
    // Adjust positions of other assets
    Object.entries(state.assets).forEach(([id, asset]) => {
        if (id === assetId) return; // Skip the asset we just updated
        
        if (oldPosition < newPosition) {
            // Moving down: decrease position of assets between old and new positions
            if (asset.position > oldPosition && asset.position <= newPosition) {
                asset.position -= 1;
            }
        } else if (oldPosition > newPosition) {
            // Moving up: increase position of assets between new and old positions
            if (asset.position >= newPosition && asset.position < oldPosition) {
                asset.position += 1;
            }
        }
    });
}

// Reorder assets within a specific page
function reorderPageAssets(pageKey, assetId, oldPosition, newPosition) {
    // Make sure the page exists in state
    if (!state.pages[pageKey]) {
        console.error(`Page ${pageKey} not found in state`);
        return;
    }
    
    // Make sure the page has assets
    if (!state.pages[pageKey].assets) {
        console.error(`Page ${pageKey} has no assets property`);
        return;
    }
    
    // Adjust positions of other assets in this page
    Object.entries(state.pages[pageKey].assets).forEach(([id, asset]) => {
        if (id === assetId) return; // Skip the asset we're moving
        
        if (oldPosition < newPosition) {
            // Moving down: decrease position of assets between old and new positions
            if (asset.position > oldPosition && asset.position <= newPosition) {
                asset.position -= 1;
            }
        } else if (oldPosition > newPosition) {
            // Moving up: increase position of assets between new and old positions
            if (asset.position >= newPosition && asset.position < oldPosition) {
                asset.position += 1;
            }
        }
    });
    
    console.log(`Reordered assets in page ${pageKey}. Asset ${assetId} moved from position ${oldPosition} to ${newPosition}`);
}

// Function to switch between pages
function switchPage(pageKey) {
    console.log('switchPage called with:', pageKey);
    
    if (!pageKey) {
        console.error('No page key provided to switchPage function');
        return;
    }
    
    if (!state.pages[pageKey]) {
        console.error(`Page "${pageKey}" does not exist in state`);
        return;
    }
    
    try {
        // Save current state before switching
        saveState();
        
        // Update current page
        state.currentPage = pageKey;
        
        // Update URL with page parameter (without reloading)
        const url = new URL(window.location.href);
        url.searchParams.set('page', pageKey);
        window.history.pushState({page: pageKey}, '', url);
        
        // Update preview with new page content
        updatePreview();
        
        // Close any open property panels
        closeProperties();
        
        // Update active tab in sidebar
        document.querySelectorAll('.page-tab').forEach(tab => {
            if (tab.getAttribute('data-page') === pageKey) {
                tab.classList.add('active');
            } else {
                tab.classList.remove('active');
            }
        });
        
        console.log(`Successfully switched to page: ${pageKey}`);
    } catch (error) {
        console.error('Error switching page:', error);
    }
}

// Force reload of asset categories via page reload with parameter
function reloadAssetCategories(pageKey) {
    // Check if we need to reload to update PHP-generated content
    const currentUrlPage = new URL(window.location.href).searchParams.get('page');
    
    // Only reload if this is the first time switching to a page or if explicitly requested
    if (currentUrlPage !== pageKey) {
        console.log('Reloading to update asset categories for:', pageKey);
        const url = new URL(window.location.href);
        url.searchParams.set('page', pageKey);
        window.location.href = url.toString();
    }
}

// Check for page parameter in URL on load
function checkUrlForPageParam() {
    const url = new URL(window.location.href);
    const pageParam = url.searchParams.get('page');
    
    if (pageParam && state.pages[pageParam]) {
        console.log('Found page parameter in URL:', pageParam);
        // Set the current page without switching (no reload)
        state.currentPage = pageParam;
        
        // Update UI to reflect the current page
        document.querySelectorAll('.page-tab').forEach(tab => {
            if (tab.getAttribute('data-page') === pageParam) {
                tab.classList.add('active');
            } else {
                tab.classList.remove('active');
            }
        });
    }
}

// Run on page load
checkUrlForPageParam();

// Update asset categories based on current page
function updateAssetCategories(pageKey) {
    // This would be handled by PHP, but we can add a UI update here
    // to reflect the current page in case we need it for the JS side
    console.log(`Updating asset categories for page: ${pageKey}`);
}

// Function to save the current state to the database
async function saveState() {
    // Show saving indicator
    const saveButton = document.getElementById('savePreview');
    if (saveButton) {
        const originalText = saveButton.textContent;
        saveButton.textContent = 'Saving...';
        saveButton.disabled = true;
    }
    
    try {
        console.log('Saving state to database...');
        
        // Get page_id from URL parameter or use default
        const pageId = currentPageId || getPageIdFromUrl() || 'homepage';
        console.log('Saving state for page_id:', pageId);
        
        // Make a deep copy of the state to avoid reference issues
        const stateCopy = JSON.parse(JSON.stringify(state));
        
        const response = await fetch('asset_manager.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=save_state&state=${encodeURIComponent(JSON.stringify(stateCopy))}&page_id=${encodeURIComponent(pageId)}`
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Save response:', data);
        
        if (data.success) {
            // Update last save time
            lastSaveTime = Date.now();
            
            // Clear unsaved changes flag
            hasUnsavedChanges = false;
            
            // Update save button
            if (saveButton) {
                saveButton.classList.remove('unsaved');
                saveButton.textContent = 'Save Work';
            }
            
            console.log('State saved successfully');
            
            // Simple notification
            showNotification('Changes saved successfully', 'success');
        } else {
            throw new Error(data.error || 'Failed to save changes');
        }
    } catch (error) {
        console.error('Error saving state:', error);
        showNotification('Error saving changes: ' + error.message, 'error');
    } finally {
        // Reset save button state
        if (saveButton) {
            saveButton.textContent = 'Save Work';
            saveButton.disabled = false;
        }
    }
} 

 