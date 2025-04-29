document.addEventListener('DOMContentLoaded', () => {
  console.log('Programs section loaded!');

  const carousel = document.querySelector('.programs-carousel');
  const scrollbar = document.querySelector('.programs-scrollbar');
  const thumb = document.querySelector('.programs-scrollbar-thumb');

  const cards = document.querySelectorAll('.program-card');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, { threshold: 0.2 });

  cards.forEach(card => observer.observe(card));

  // Drag to scroll (cards)
  let isDown = false;
  let startX;
  let scrollLeft;

  carousel.addEventListener('mousedown', (e) => {
    isDown = true;
    carousel.classList.add('active');
    startX = e.pageX - carousel.offsetLeft;
    scrollLeft = carousel.scrollLeft;
  });

  carousel.addEventListener('mouseleave', () => {
    isDown = false;
    carousel.classList.remove('active');
  });

  carousel.addEventListener('mouseup', () => {
    isDown = false;
    carousel.classList.remove('active');
  });

  carousel.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - carousel.offsetLeft;
    const walk = (x - startX) * 2;
    carousel.scrollLeft = scrollLeft - walk;
  });

  // Move scrollbar thumb when carousel scrolls
  carousel.addEventListener('scroll', () => {
    const scrollPercent = carousel.scrollLeft / (carousel.scrollWidth - carousel.clientWidth);
    const thumbWidth = scrollbar.clientWidth * (carousel.clientWidth / carousel.scrollWidth);
    thumb.style.width = `${thumbWidth}px`;
    thumb.style.left = `${scrollPercent * (scrollbar.clientWidth - thumbWidth)}px`;
  });

  // Dragging the thumb to scroll
  let isThumbDown = false;
  let thumbStartX;
  let thumbStartLeft;

  thumb.addEventListener('mousedown', (e) => {
    e.preventDefault();
    isThumbDown = true;
    thumbStartX = e.clientX;
    thumbStartLeft = parseFloat(thumb.style.left) || 0;
  });

  document.addEventListener('mouseup', () => {
    isThumbDown = false;
  });

  document.addEventListener('mousemove', (e) => {
    if (!isThumbDown) return;
    e.preventDefault();
    const deltaX = e.clientX - thumbStartX;
    const newLeft = Math.min(Math.max(thumbStartLeft + deltaX, 0), scrollbar.clientWidth - thumb.clientWidth);
    thumb.style.left = `${newLeft}px`;

    const scrollRatio = newLeft / (scrollbar.clientWidth - thumb.clientWidth);
    carousel.scrollLeft = scrollRatio * (carousel.scrollWidth - carousel.clientWidth);
  });
});
