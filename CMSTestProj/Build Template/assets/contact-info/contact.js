document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    const formSuccess = document.getElementById('formSuccess');
  
    // Form submission handler
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
  
      // Simulate a successful form submission (You can replace with real form submission)
      setTimeout(() => {
        // Show success message
        formSuccess.style.display = 'block';
  
        // Reset form fields after successful submission
        contactForm.reset();
      }, 500);
    });
  });
  