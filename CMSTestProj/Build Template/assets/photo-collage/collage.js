// Optional: Add interactivity, if desired
document.addEventListener('DOMContentLoaded', () => {
    const images = document.querySelectorAll('.collage-image');
  
    images.forEach((image) => {
      image.addEventListener('mouseover', () => {
        image.style.opacity = '0.7';
      });
  
      image.addEventListener('mouseout', () => {
        image.style.opacity = '1';
      });
    });
  });
  