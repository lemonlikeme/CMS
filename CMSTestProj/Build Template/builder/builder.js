const canvas = document.getElementById('canvas');
const buttons = document.querySelectorAll('.asset-grid button');

const assetFileMap = {
  "academic-calendar": { html: "calendar.html", css: "calendar.css" },
  "admissions-form": { html: "form.html", css: "form.css" },
  "campus-life": { html: "campus-life.html", css: "campus-life.css" },
  "campus-map": { html: "map.html", css: "map.css" },
  "contact-info": { html: "contact.html", css: "contact.css" },
  "faq": { html: "faq.html", css: "faq.css" },
  "news-event": { html: "news.html", css: "news.css" },
  "photo-collage": { html: "collage.html", css: "collage.css" },
  "programs-listing": { html: "programs.html", css: "programs.css" },
  "social-media": { html: "social-media.html", css: "social-media.css" }, 
  "university-history": { html: "history.html", css: "history.css" }
};

const loadedCSS = new Set();

buttons.forEach(button => {
  button.addEventListener('click', async () => {
    const assetFolder = button.getAttribute('data-asset');
    const asset = assetFileMap[assetFolder];

    if (!asset) {
      console.error(`No mapping found for asset: ${assetFolder}`);
      return;
    }

    const { html, css } = asset;

    try {
      // Load HTML
      const response = await fetch(`../assets/${assetFolder}/${html}`);
      if (!response.ok) throw new Error('HTML fetch failed');

      const htmlContent = await response.text();

      const wrapper = document.createElement('div');
      wrapper.innerHTML = htmlContent;
      wrapper.style.marginBottom = '2rem';
      canvas.appendChild(wrapper);

      // Remove placeholder
      const placeholder = canvas.querySelector('.placeholder');
      if (placeholder) placeholder.remove();

      // Load CSS if not already loaded
      if (!loadedCSS.has(css)) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = `../assets/${assetFolder}/${css}`;
        document.head.appendChild(link);
        loadedCSS.add(css);
      }
    } catch (error) {
      console.error(`Failed to load asset from ${assetFolder}:`, error);
    }
  });
});

const tabs = document.querySelectorAll('.tab');
const panels = document.querySelectorAll('.panel-content');

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    // Remove active state from all tabs
    tabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');

    const target = tab.getAttribute('data-tab');
    panels.forEach(panel => {
      if (panel.id === `panel-${target}`) {
        panel.classList.remove('hidden');
      } else {
        panel.classList.add('hidden');
      }
    });
  });
});
