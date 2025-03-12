document.addEventListener("DOMContentLoaded", function () {
    const searchBtn = document.getElementById("search-btn");
    const searchBar = document.getElementById("search-bar");

    searchBtn.addEventListener("click", function () {
        if (searchBar.style.display === "none" || searchBar.style.display === "") {
            searchBar.style.display = "block";
        } else {
            searchBar.style.display = "none";
        }
    });
});

// Pop-up functions
window.showPopup = function (message) {
    document.getElementById("popup-message").innerText = message;
    document.getElementById("popup").style.display = "block";
    document.getElementById("overlay").style.display = "block";
};

window.closePopup = function () {
    document.getElementById("popup").style.display = "none";
    document.getElementById("overlay").style.display = "none";
};
