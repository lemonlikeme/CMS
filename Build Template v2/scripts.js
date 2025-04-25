document.addEventListener("DOMContentLoaded", () => {
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
        step.style.setProperty('--origin', 'left'); // for NEXT
      } else if (i === newIndex) {
        step.classList.add("active");
        const goingForward = newIndex > currentStep;
        step.style.setProperty('--origin', goingForward ? 'left' : 'right'); // for animation direction
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
        window.location.href = nextBtn.getAttribute("href");
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
        window.location.href = prevBtn.getAttribute("href");
      }, 400);
    });
  }
});

const selectedSections = [];
let currentIndex = 0;

const container = document.getElementById('carousel-container');
const prevBtn = document.getElementById('carousel-prev');
const nextBtn = document.getElementById('carousel-next');

const sectionImages = {
  about: 'images/about.jpg',
  contact: 'images/contact.jpg',
  shop: 'images/shop.jpg',
  services: 'images/services.jpg',
  appointments: 'images/appointments.jpg',
  course: 'images/course.jpg'
};

document.querySelectorAll('.section-options input[type="checkbox"]').forEach((checkbox) => {
  checkbox.addEventListener('change', (e) => {
    const value = e.target.value;

    if (e.target.checked) {
      if (!selectedSections.includes(value)) selectedSections.push(value);
    } else {
      const index = selectedSections.indexOf(value);
      if (index > -1) selectedSections.splice(index, 1);
      if (currentIndex >= selectedSections.length) currentIndex = 0;
    }

    updateCarousel();
  });
});

const sectionDescriptions = {
  about: "Discover our story, values, and what drives us every day. We believe in transparency, community, and innovation. Learn about the journey that brought us here and the people behind the brand. Our mission is to create meaningful connections. Dive into our culture and vision for the future.",
  contact: "Have questions? We're here to help. Reach out via phone, email, or our contact form. Our team typically responds within 24 hours. Whether it's support or a quick hello, don't hesitate to connect. Your feedback matters and helps us grow.",
  shop: "Browse our curated collection of products tailored to your needs. From essentials to unique finds, we’ve got you covered. Enjoy a seamless shopping experience with secure checkout. Discover new arrivals every week. Satisfaction guaranteed with every purchase.",
  services: "Explore the variety of services we offer to support your goals. From consultations to hands-on support, we’re with you every step. Our team is made up of experts ready to assist. Flexible scheduling and customizable solutions. Let’s achieve something great together.",
  appointments: "Book a time that works for you using our online system. Our availability is updated in real-time. You'll receive confirmation and reminders automatically. We value your time and strive for punctuality. Let us know how we can make the process even smoother.",
  course: "Take your skills to the next level with our professional courses. Designed for learners at all levels. Each course includes video tutorials, downloadable resources, and assessments. Learn at your own pace with lifetime access. Start learning today and unlock new opportunities."
};

function updateCarousel() {
  container.innerHTML = '';

  if (selectedSections.length === 0) return;

  selectedSections.forEach((section, idx) => {
    const card = document.createElement('div');
    card.className = 'carousel-card';
    card.setAttribute('data-section', section.toLowerCase());

    const img = document.createElement('img');
    img.src = `./images/${section.toLowerCase()}.jpg`;
    img.alt = section;

    const title = document.createElement('p');
    title.textContent = section;
    title.className = 'card-title';

    const desc = document.createElement('p');
    desc.textContent = sectionDescriptions[section.toLowerCase()] || '';
    desc.className = 'card-description';

    card.appendChild(img);
    card.appendChild(title);
    card.appendChild(desc);

    card.style.display = idx === currentIndex ? 'block' : 'none';
    container.appendChild(card);
  });
}

window.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.carousel-card').forEach(card => {
    card.style.display = 'none';
  });
});

prevBtn.addEventListener('click', () => {
  if (selectedSections.length === 0) return;
  currentIndex = (currentIndex - 1 + selectedSections.length) % selectedSections.length;
  showCurrentCard();
});

nextBtn.addEventListener('click', () => {
  if (selectedSections.length === 0) return;
  currentIndex = (currentIndex + 1) % selectedSections.length;
  showCurrentCard();
});

function showCurrentCard() {
  const allCards = container.querySelectorAll('.carousel-card');
  allCards.forEach((card, i) => {
    card.style.display = i === currentIndex ? 'block' : 'none';
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const palettes = document.querySelectorAll('.palette');
  const preview = document.querySelector('.site-preview');
  const btn = document.querySelector('.learn-more');
  const socials = document.querySelectorAll('.social-box');

  palettes.forEach(palette => {
    palette.style.pointerEvents = 'auto'; // Ensure clickable

    palette.addEventListener('click', () => {
      // Remove previous selection
      document.querySelectorAll('.palette.selected').forEach(p => {
        p.classList.remove('selected');
      });

      // Mark current as selected
      palette.classList.add('selected');

      // Get palette colors
      const colors = Array.from(palette.querySelectorAll('.palette-color'))
        .map(colorDiv => getComputedStyle(colorDiv).backgroundColor);

      const [primary, secondary, accent] = colors;

      // Apply to preview
      if (preview) preview.style.backgroundColor = secondary;
      if (btn) {
        btn.style.backgroundColor = primary;
        btn.style.color = secondary;
      }
      socials.forEach(box => {
        box.style.backgroundColor = accent;
      });
    });
  });
});
  








