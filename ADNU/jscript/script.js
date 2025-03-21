document.addEventListener("DOMContentLoaded", function () {
    const searchBtn = document.getElementById("search-btn");
    const searchBar = document.getElementById("search-bar");

    searchBtn.addEventListener("click", function () {
        searchBar.style.display = (searchBar.style.display === "none" || searchBar.style.display === "") ? "block" : "none";
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

// Mobile tap dropdown
document.addEventListener("DOMContentLoaded", function () {
    let dropdown = document.querySelector(".dropdown > a");
    dropdown.addEventListener("click", function (e) {
        e.preventDefault();
        let menu = this.nextElementSibling;
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    });
});

// Hero Slideshow & Settings
document.addEventListener("DOMContentLoaded", function () {
    const settingsBtn = document.getElementById("settings-btn");
    const settingsPanel = document.getElementById("settings-panel");
    const closeSettings = document.getElementById("close-settings");
    const saveSettings = document.getElementById("save-settings");
    const resetSettings = document.getElementById("reset-settings");

    // ✅ Hero Section Elements
    const heroSection = document.querySelector(".hero");
    let heroTitleElem = document.getElementById("hero-title");
    let heroTextElem = document.getElementById("hero-text");

    // ✅ Background Color Inputs
    const heroBgInput = document.getElementById("hero-bg");
    const leftBgInput = document.getElementById("left-bg");
    const rightBgInput = document.getElementById("right-bg");

    // ✅ Left Content Elements
    const leftContent = document.querySelector(".leftContent");
    const leftTitleInput = document.getElementById("left-title");
    const leftTextInput = document.getElementById("left-text");

    // ✅ Hero Slide Editing
    const heroUpload = document.getElementById("hero-upload");
    const previewImage = document.getElementById("preview-image");
    const heroSlideSelect = document.getElementById("hero-slide-select");

    // ✅ Load Slides from Local Storage
    let heroSlides = JSON.parse(localStorage.getItem("heroSlides")) || [
        { image: "imgs/herodefaultimg1.png", title: "Welcome to Our Site", text: "Discover new opportunities with us." },
        { image: "imgs/herodefaultimg2.png", title: "Your Future Starts Here", text: "Explore endless possibilities." }
    ];

    let currentHeroIndex = 0;

    // ✅ Open & Close Settings Panel
    settingsBtn.addEventListener("click", () => settingsPanel.classList.add("open"));
    closeSettings.addEventListener("click", () => settingsPanel.classList.remove("open"));

    // ✅ Load Settings into Inputs
    function loadSettings() {
        heroSlides = JSON.parse(localStorage.getItem("heroSlides")) || heroSlides;

        // ✅ Populate Hero Slide Dropdown
        heroSlideSelect.innerHTML = "";
        heroSlides.forEach((slide, index) => {
            let option = document.createElement("option");
            option.value = index;
            option.textContent = `Slide ${index + 1}`;
            heroSlideSelect.appendChild(option);
        });

        // ✅ Load First Slide
        updateSlideInputs(0);

        // ✅ Load Background Colors
        heroBgInput.value = localStorage.getItem("heroBg") || "#003366";
        leftBgInput.value = localStorage.getItem("leftBg") || "#ffffff";
        rightBgInput.value = localStorage.getItem("rightBg") || "#f4f4f4";

        // ✅ Apply Background Colors
        heroSection.style.backgroundColor = heroBgInput.value;
        leftContent.style.backgroundColor = leftBgInput.value;
        document.querySelector(".rightContent").style.backgroundColor = rightBgInput.value;

        // ✅ Load Left Content
        leftContent.querySelector("h2").textContent = localStorage.getItem("leftTitle") || "Welcome to Ateneo de Naga University Admissions";
        leftContent.querySelector("p").textContent = localStorage.getItem("leftText") || "The College Admissions and Aid Office (CAAO) is a student service office performing academic support functions...";
    }

    // ✅ Update Input Fields for a Selected Slide
    function updateSlideInputs(index) {
        leftTitleInput.value = localStorage.getItem("leftTitle") || leftContent.querySelector("h2").textContent;
        leftTextInput.value = localStorage.getItem("leftText") || leftContent.querySelector("p").textContent;

        document.getElementById("hero-title").value = heroSlides[index].title;
        document.getElementById("hero-text").value = heroSlides[index].text;
    }

    // ✅ Listen for Slide Selection Changes
    heroSlideSelect.addEventListener("change", function () {
        updateSlideInputs(heroSlideSelect.value);
    });

    // ✅ Change Hero Image Automatically
    function changeHeroImage() {
        if (heroSlides.length > 0) {
            heroSection.style.backgroundImage = `url(${heroSlides[currentHeroIndex].image})`;
            heroTitleElem.textContent = heroSlides[currentHeroIndex].title;
            heroTextElem.textContent = heroSlides[currentHeroIndex].text;
            currentHeroIndex = (currentHeroIndex + 1) % heroSlides.length;
        }
    }

    // ✅ Handle Image Upload
    // Handle adding a new image to the slideshow
heroUpload.addEventListener("change", function () {
    const file = heroUpload.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            // ✅ Add the new image as a new slide
            heroSlides.push({
                image: e.target.result,
                title: "New Slide",
                text: "Enter text here"
            });

            // ✅ Save updated slides to localStorage
            localStorage.setItem("heroSlides", JSON.stringify(heroSlides));

            // ✅ Refresh the dropdown so new slide appears in settings
            loadSettings();
        };
        reader.readAsDataURL(file);
    }
});


    // ✅ Save Settings
    saveSettings.addEventListener("click", function () {
        let selectedIndex = heroSlideSelect.value;
        heroSlides[selectedIndex].title = document.getElementById("hero-title").value;
        heroSlides[selectedIndex].text = document.getElementById("hero-text").value;

        // ✅ Save hero image from uploaded file
        if (previewImage.src) {
            heroSlides[selectedIndex].image = previewImage.src;
        }

        // ✅ Save Background Colors
        localStorage.setItem("heroBg", heroBgInput.value);
        localStorage.setItem("leftBg", leftBgInput.value);
        localStorage.setItem("rightBg", rightBgInput.value);

        // ✅ Save Left Content
        localStorage.setItem("leftTitle", leftTitleInput.value);
        localStorage.setItem("leftText", leftTextInput.value);

        // ✅ Save Hero Slides
        localStorage.setItem("heroSlides", JSON.stringify(heroSlides));

        // ✅ Update Hero Section Immediately
        heroTitleElem.textContent = heroSlides[selectedIndex].title;
        heroTextElem.textContent = heroSlides[selectedIndex].text;
        heroSection.style.backgroundImage = `url(${heroSlides[selectedIndex].image})`;

        // ✅ Apply Background Colors
        heroSection.style.backgroundColor = heroBgInput.value;
        leftContent.style.backgroundColor = leftBgInput.value;
        document.querySelector(".rightContent").style.backgroundColor = rightBgInput.value;

        // ✅ Update Left Content
        leftContent.querySelector("h2").textContent = leftTitleInput.value;
        leftContent.querySelector("p").textContent = leftTextInput.value;

        settingsPanel.classList.remove("open");
        loadSettings();
    });

    // ✅ Reset All Settings
    resetSettings.addEventListener("click", function () {
        if (confirm("Are you sure you want to reset everything?")) {
            localStorage.clear();
            location.reload();
        }
    });

    // ✅ Start Hero Slideshow
    setInterval(changeHeroImage, 3000);
    loadSettings();
    changeHeroImage();
});
