function changeFont(fontName) {
  const previewText = document.querySelector('.pv-text h2');
  const previewParagraph = document.querySelector('.pv-text p');
  
  previewText.style.fontFamily = fontName;
  previewParagraph.style.fontFamily = fontName;
}