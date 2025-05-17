document.addEventListener("DOMContentLoaded", () => {
  console.log('Font selection script loaded');

  // Font selection functionality
  const fontOptions = document.querySelectorAll('.font-option');
  const fontForm = document.getElementById('font_input');
  const previewH2 = document.querySelector('.pv-text-h2');
  const previewP = document.querySelector('.pv-text-p');

  if (fontOptions.length > 0) {
    console.log('Initializing font selection');

    fontOptions.forEach(option => {
      option.addEventListener('click', function () {
        // Remove 'selected' class from all options
        fontOptions.forEach(opt => {
          opt.classList.remove('selected');
          opt.querySelector('input[type="radio"]').checked = false;
        });
        
        // Add 'selected' class to the clicked option and check its radio
        this.classList.add('selected');
        const radioButton = this.querySelector('input[type="radio"]');
        radioButton.checked = true;
        console.log('Selected font:', radioButton.value);

        // Get font class for preview
        const fontClass = this.getAttribute('data-font');

        // Update preview card font
        if (previewH2 && previewP) {
          previewH2.className = `pv-text-h2 font-${fontClass.toLowerCase().replace(/\s/g, '')}`;
          previewP.className = `pv-text-p font-${fontClass.toLowerCase().replace(/\s/g, '')}`;
        }
      });
    });

    // Handle form submission specifically for fonts
    const fontNextBtn = document.querySelector('.button-next');
    if (fontNextBtn && fontForm) {
      fontNextBtn.addEventListener('click', function(e) {
        console.log('Font next button clicked');
        
        // Check if any font is selected
        const selectedFont = fontForm.querySelector('input[name="selected_font"]:checked');
        
        if (!selectedFont) {
          console.log('No font selected');
          alert('Please select a font before proceeding.');
          e.stopPropagation(); // Stop event bubbling
          return false;
        } else {
          console.log('Font selected:', selectedFont.value);
          // Submit directly instead of going through scripts.js
          fontForm.submit();
          e.stopPropagation(); // Stop event from propagating to scripts.js handler
          return false;
        }
      }, true); // Use capture to intercept event before scripts.js
    }
  }
});