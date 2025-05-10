document.addEventListener("DOMContentLoaded", () => {
  console.log('DOM Content Loaded - Starting initialization');

  // Font selection functionality
  const fontOptions = document.querySelectorAll('.font-option');
  const fontForm = document.getElementById('fontForm');
  const selectedFontInput = document.getElementById('selectedFont');
  const previewCard = document.querySelector('.preview-card');
  const previewText = previewCard?.querySelector('.preview-text');

  console.log('Font elements found:', {
    fontOptions: fontOptions.length,
    fontForm: !!fontForm,
    selectedFontInput: !!selectedFontInput,
    previewCard: !!previewCard,
    previewText: !!previewText
  });

  if (fontOptions.length > 0) {
    console.log('Initializing font selection');
    
    // Store selected font
    let selectedFont = '';

    fontOptions.forEach(option => {
      option.addEventListener('click', function() {
        console.log('Font option clicked');
        
        // Remove selected class from all options
        fontOptions.forEach(opt => opt.classList.remove('selected'));
        // Add selected class to clicked option
        this.classList.add('selected');
        
        // Get the font name and class
        const fontName = this.querySelector('.font-name').textContent;
        const fontClass = this.getAttribute('data-font');
        selectedFont = fontName;
        
        console.log('Selected font:', fontName, 'Class:', fontClass);

        // Update preview card font
        if (previewCard && previewText) {
          // Remove all font classes from preview text
          previewText.classList.remove(
            'font-helvetica', 'font-roboto', 'font-opensans',
            'font-georgia', 'font-times', 'font-garamond',
            'font-playfair', 'font-montserrat', 'font-poppins'
          );
          
          // Add the selected font class
          previewText.classList.add(`font-${fontClass}`);
          
          // Store the font
          if (selectedFontInput) {
            selectedFontInput.value = fontName;
          }
        }
      });
    });

    // Handle form submission
    const fontNextBtn = document.querySelector('.button-next');
    if (fontNextBtn) {
      fontNextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        
        if (!selectedFont) {
          alert('Please select a font before proceeding.');
          return;
        }

        // Submit the form
        if (fontForm) {
          fontForm.submit();
        }
      });
    }
  }

  // Color palette selection functionality
  const palettes = document.querySelectorAll('.palette');
  const colorForm = document.getElementById('colorForm');
  const selectedColorInput = document.getElementById('selectedColor');
  const colorNextBtn = document.querySelector('.button-next');

  if (palettes.length > 0 && colorForm && selectedColorInput) {
    console.log('Initializing color palette selection');
    
    // Store selected colors
    let selectedColors = [];

    palettes.forEach(palette => {
      palette.addEventListener('click', function() {
        // Remove selected class from all palettes
        palettes.forEach(p => p.classList.remove('selected'));
        // Add selected class to clicked palette
        this.classList.add('selected');
        
        // Get the colors from the selected palette
        selectedColors = Array.from(this.querySelectorAll('.palette-color'))
          .map(color => color.style.background);
        
        // Store the colors
        selectedColorInput.value = JSON.stringify(selectedColors);
        console.log('Selected colors:', selectedColors);
      });
    });

    // Handle form submission
    if (colorNextBtn) {
      colorNextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        
        if (selectedColors.length === 0) {
          alert('Please select a color palette before proceeding.');
          return;
        }

        // Submit the form
        colorForm.submit();
      });
    }
  }

  // Progress bar functionality
  const steps = document.querySelectorAll(".progress-bar .step");
  const nextBtn = document.querySelector(".button-next");
  const prevBtn = document.querySelector(".button-back");

  let currentStep = Array.from(steps).findIndex(step =>
    step.classList.contains("active")
  );

  function updateSteps(newIndex) {
    steps.forEach((step, i) => {
      step.classList.remove("active");
      step.classList.remove("done");
  
      if (i < newIndex) {
        step.classList.add("done");
        step.style.setProperty('--origin', 'left');
      } else if (i === newIndex) {
        step.classList.add("active");
        const goingForward = newIndex > currentStep;
        step.style.setProperty('--origin', goingForward ? 'left' : 'right');
      }
    });
  
    currentStep = newIndex;
  }  

  if (nextBtn) {
    nextBtn.addEventListener("click", (e) => {
      e.preventDefault();
      if (currentStep < steps.length - 1) {
        updateSteps(currentStep + 1);
      }
      setTimeout(() => {
        window.location.href = nextBtn.closest('form').getAttribute("action");
      }, 400);
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener("click", (e) => {
      e.preventDefault();
      if (currentStep > 0) {
        updateSteps(currentStep - 1);
      }
      setTimeout(() => {
        window.location.href = prevBtn.closest('form').getAttribute("action");
      }, 400);
    });
  }

  // Carousel functionality
  const selectedSections = [];
  let currentIndex = 0;

  const container = document.getElementById('carousel-container');
  const carouselPrevBtn = document.getElementById('carousel-prev');
  const carouselNextBtn = document.getElementById('carousel-next');
  const titleSpan = document.getElementById('carousel-title');
  const checkboxes = document.querySelectorAll('.page-option input[type="checkbox"]');

  // Debug element finding
  console.log('Debug - Elements found:', {
    container: container ? 'Found' : 'Not found',
    containerId: container ? container.id : 'N/A',
    containerClasses: container ? container.className : 'N/A',
    prevBtn: carouselPrevBtn ? 'Found' : 'Not found',
    nextBtn: carouselNextBtn ? 'Found' : 'Not found',
    titleSpan: titleSpan ? 'Found' : 'Not found',
    checkboxesCount: checkboxes.length,
    bodyClass: document.body.className
  });

  // Elements
  const previewContent = document.getElementById('preview-content');
  const pageCounter = document.getElementById('page-counter');
  const prevButton = document.getElementById('prev-page');
  const nextButton = document.getElementById('next-page');

  // State
  let selectedPages = [];

  // Page features
  const pageFeatures = {
    about: ['Company Overview', 'Team Members', 'Mission & Values', 'History'],
    contact: ['Contact Form', 'Location Map', 'Business Hours', 'Social Links'],
    shop: ['Product Grid', 'Shopping Cart', 'Secure Checkout', 'Order Tracking'],
    services: ['Service List', 'Pricing Table', 'Booking System', 'FAQ Section'],
    appointments: ['Calendar View', 'Time Slots', 'Online Booking', 'Reminders'],
    course: ['Course Catalog', 'Learning Modules', 'Progress Tracking', 'Certificates']
  };

  // Show default state
  function showDefaultState() {
    console.log('Showing default state');
    if (!previewContent) {
      console.error('Preview content element not found');
      return;
    }
    previewContent.innerHTML = `
      <div class="default-preview">
        <h3>Welcome to Page Selection</h3>
        <p>Select the pages you want to include in your website from the options on the right.</p>
        <div class="preview-grid">
          <div class="preview-item">
            <img src="images/about.jpg" alt="About">
            <span>About</span>
          </div>
          <div class="preview-item">
            <img src="images/contact.jpg" alt="Contact">
            <span>Contact</span>
          </div>
          <div class="preview-item">
            <img src="images/shop.jpg" alt="Shop">
            <span>Shop</span>
          </div>
        </div>
      </div>
    `;
    if (pageCounter) {
      pageCounter.textContent = 'Select a page';
    }
    if (prevButton) prevButton.disabled = true;
    if (nextButton) nextButton.disabled = true;
  }

  // Create preview card
  function createPreviewCard(page) {
    console.log('Creating preview card for:', page);
    const features = pageFeatures[page.toLowerCase()] || [];
    return `
      <div class="preview-card">
        <img src="images/${page.toLowerCase()}.jpg" alt="${page} Preview">
        <div class="preview-card-content">
          <h3>${page} Page</h3>
          <p>This is your ${page.toLowerCase()} page. It will include all the essential features and content needed for a professional ${page.toLowerCase()} page.</p>
          <div class="preview-features">
            <h4>Page Features</h4>
            <ul class="feature-list">
              ${features.map(feature => `<li>${feature}</li>`).join('')}
            </ul>
          </div>
        </div>
      </div>
    `;
  }

  // Update preview
  function updatePreview() {
    console.log('Updating preview:', { selectedPages, currentIndex });
    
    if (!previewContent) {
      console.error('Preview content element not found in updatePreview');
      return;
    }

    if (selectedPages.length === 0) {
      showDefaultState();
      return;
    }

    // Update counter
    if (pageCounter) {
      pageCounter.textContent = `Page ${currentIndex + 1} of ${selectedPages.length}`;
    }

    // Update navigation buttons
    if (prevButton) prevButton.disabled = currentIndex === 0;
    if (nextButton) nextButton.disabled = currentIndex === selectedPages.length - 1;

    // Show current page preview
    const currentPage = selectedPages[currentIndex];
    console.log('Setting preview content for page:', currentPage);
    previewContent.innerHTML = createPreviewCard(currentPage);
  }

  // Event Listeners
  checkboxes.forEach(checkbox => {
    console.log('Adding event listener to checkbox:', checkbox.value);
    checkbox.addEventListener('change', () => {
      const page = checkbox.value;
      console.log('Checkbox changed:', { page, checked: checkbox.checked });
      
      if (checkbox.checked) {
        if (!selectedPages.includes(page)) {
          selectedPages.push(page);
          // If this is the first selection, set currentIndex to 0
          if (selectedPages.length === 1) {
            currentIndex = 0;
          }
        }
      } else {
        const index = selectedPages.indexOf(page);
        if (index > -1) {
          selectedPages.splice(index, 1);
          // Adjust currentIndex if needed
          if (currentIndex >= selectedPages.length) {
            currentIndex = Math.max(0, selectedPages.length - 1);
          }
        }
      }

      console.log('Updated selected pages:', selectedPages);
      updatePreview();
    });
  });

  // Navigation button event listeners
  if (prevButton) {
    prevButton.addEventListener('click', () => {
      console.log('Previous button clicked');
      if (currentIndex > 0) {
        currentIndex--;
        updatePreview();
      }
    });
  }

  if (nextButton) {
    nextButton.addEventListener('click', () => {
      console.log('Next button clicked');
      if (currentIndex < selectedPages.length - 1) {
        currentIndex++;
        updatePreview();
      }
    });
  }

  // Initialize
  showDefaultState();
});

function changeFont(fontName) {
  document.querySelectorAll('.font').forEach(el => el.classList.remove('selected'));
  const fonts = document.querySelectorAll('.font-preview');
  fonts.forEach(preview => {
    if (preview.textContent === fontName || preview.style.fontFamily.includes(fontName)) {
      preview.parentElement.classList.add('selected');
    }
  });

  // Apply font (update your preview area or app logic here)
  document.querySelector('.canvas-preview')?.style.fontFamily = fontName;
}

