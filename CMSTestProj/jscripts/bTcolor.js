document.addEventListener('DOMContentLoaded', function() {
  const palettes = document.querySelectorAll('.palette');
  
  palettes.forEach(palette => {
    palette.addEventListener('click', function() {
      // Remove selected class from all palettes
      palettes.forEach(p => p.classList.remove('selected'));
      
      // Add selected class to clicked palette
      this.classList.add('selected');
      
      const colors = this.querySelectorAll('.palette-color');
      const previewMain = document.querySelector('.preview-main');
      const button = document.querySelector('.learn-more');
      const headingText = document.querySelector('.preview-text h2');
      const paragraphText = document.querySelector('.preview-text p');
      
      // Apply first color to card background
      if (colors[0]) {
        previewMain.style.backgroundColor = colors[0].style.backgroundColor;
      }
      
      // Apply second color to button background only, keeping text white
      if (colors[1]) {
        const buttonColor = colors[1].style.backgroundColor;
        button.style.cssText = `
          background-color: ${buttonColor} !important;
          color: #ffffff !important;
          text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
        `;
      }
      
      // Apply third color to heading and paragraph text only
      if (colors[2]) {
        if (headingText) {
          headingText.style.color = colors[2].style.backgroundColor;
        }
        if (paragraphText) {
          paragraphText.style.color = colors[2].style.backgroundColor;
        }
      }
    });
  });

  // Set initial button text to white
  const button = document.querySelector('.learn-more');
  if (button) {
    button.style.cssText = `
      color: #ffffff !important;
      text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
    `;
  }
});

// Helper function to determine if a color is dark
function isColorDark(color) {
  // Convert color to RGB
  const rgb = color.match(/\d+/g);
  if (!rgb) return false;
  
  // Calculate relative luminance
  const r = parseInt(rgb[0]) / 255;
  const g = parseInt(rgb[1]) / 255;
  const b = parseInt(rgb[2]) / 255;
  
  const luminance = 0.299 * r + 0.587 * g + 0.114 * b;
  return luminance < 0.5;
}
