function changeFont(fontName) {
  const previewText = document.querySelector('.preview-text h2');
  const previewParagraph = document.querySelector('.preview-text p');
  
  previewText.style.fontFamily = fontName;
  previewParagraph.style.fontFamily = fontName;
}