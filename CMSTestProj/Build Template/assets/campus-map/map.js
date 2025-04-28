// document.addEventListener('DOMContentLoaded', () => {
//     const markers = document.querySelectorAll('.map-marker');
//     const infoBox = document.getElementById('mapInfo');
  
//     markers.forEach(marker => {
//       marker.addEventListener('mouseenter', () => {
//         const locationName = marker.getAttribute('data-name');
//         infoBox.textContent = locationName;
//       });
  
//       marker.addEventListener('mouseleave', () => {
//         infoBox.textContent = 'Hover over a location to learn more!';
//       });
  
//       marker.addEventListener('click', () => {
//         alert(`You clicked on: ${marker.getAttribute('data-name')}`);
//       });
//     });
//   });
  