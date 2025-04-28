document.addEventListener('DOMContentLoaded', () => {
    // Function to toggle the display of news details
    window.showDetails = (id) => {
      const newsDetails = document.getElementById(id);
      
      // Toggle the visibility of the news details
      if (newsDetails.style.display === "block") {
        newsDetails.style.display = "none";
      } else {
        newsDetails.style.display = "block";
      }
    };
  });
  