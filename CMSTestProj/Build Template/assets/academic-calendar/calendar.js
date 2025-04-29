document.querySelectorAll('.calendar-date').forEach(button => {
    button.addEventListener('click', () => {
      const event = button.parentElement;
      event.classList.toggle('active');
    });
  });
  