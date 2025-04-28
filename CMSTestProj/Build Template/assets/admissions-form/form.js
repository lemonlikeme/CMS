document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('admissionsForm');
  
    form.addEventListener('submit', (e) => {
      e.preventDefault(); // prevent page reload
  
      // Get form data
      const formData = new FormData(form);
      const data = Object.fromEntries(formData.entries());
  
      console.log('Form submitted:', data);
  
      // Placeholder: show a simple thank you (you can replace with real sending later)
      alert('Thank you for your application! We will contact you soon.');
  
      form.reset(); // clear the form
    });
  });
  