document.addEventListener('DOMContentLoaded', () => {
  const palettes = document.querySelectorAll('.palette');
  const preview = document.querySelector('.preview-container');
  const btn = document.querySelector('.learn-more');
  const txt = document.querySelectorAll('.pv-text');

  if (!palettes.length) {
    console.log('No palettes found on this page.');
    return;
  }

  palettes.forEach(palette => {
    palette.style.pointerEvents = 'auto';

    palette.addEventListener('click', () => {
      console.log('Palette clicked!');

      document.querySelectorAll('.palette.selected').forEach(p => {
        p.classList.remove('selected');
      });

      palette.classList.add('selected');

      const colors = Array.from(palette.querySelectorAll('.palette-color'))
        .map(colorDiv => getComputedStyle(colorDiv).backgroundColor);

      const [primary, secondary, accent] = colors;

      if (preview) preview.style.backgroundColor = primary;
      if (btn) {
        btn.style.backgroundColor = secondary;
        btn.style.color = accent;
		
      }	

      txt.forEach(el => {
        el.style.color = accent;
      });
    });
  });
});
