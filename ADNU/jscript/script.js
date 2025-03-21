document.addEventListener("DOMContentLoaded", function () {
    const searchBtn = document.getElementById("search-btn");
    const searchBar = document.getElementById("search-bar");

    searchBtn.addEventListener("click", function () {
        searchBar.style.display = (searchBar.style.display === "none" || searchBar.style.display === "") ? "block" : "none";
    });
});

// modal
window.showPopup = function (message) {
    document.getElementById("popup-message").innerText = message;
    document.getElementById("popup").style.display = "block";
    document.getElementById("overlay").style.display = "block";
};

window.closePopup = function () {
    document.getElementById("popup").style.display = "none";
    document.getElementById("overlay").style.display = "none";
};

// mobile tap
document.addEventListener("DOMContentLoaded", function () {
    let dropdown = document.querySelector(".dropdown > a");
    dropdown.addEventListener("click", function (e) {
        e.preventDefault();
        let menu = this.nextElementSibling;
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    });
});

// hero and settings
document.addEventListener("DOMContentLoaded", function () {
    const settingsBtn = document.getElementById("settings-btn");
    const settingsPanel = document.getElementById("settings-panel");
    const closeSettings = document.getElementById("close-settings");
    const saveSettings = document.getElementById("save-settings");
    const resetSettings = document.getElementById("reset-settings");

   
    const heroSection = document.querySelector(".hero");
    let heroTitleElem = document.getElementById("hero-title");
    let heroTextElem = document.getElementById("hero-text");

   
    const heroBgInput = document.getElementById("hero-bg");
    const leftBgInput = document.getElementById("left-bg");
    const rightBgInput = document.getElementById("right-bg");

    const leftContent = document.querySelector(".leftContent");
    const leftTitleInput = document.getElementById("left-title");
    const leftTextInput = document.getElementById("left-text");

   
    const heroUpload = document.getElementById("hero-upload");
    const previewImage = document.getElementById("preview-image");
    const heroSlideSelect = document.getElementById("hero-slide-select");


    let heroSlides = JSON.parse(localStorage.getItem("heroSlides")) || [
        { image: "imgs/herodefaultimg1.png", title: "Welcome to Our Site", text: "Discover new opportunities with us." },
        { image: "imgs/herodefaultimg2.png", title: "Your Future Starts Here", text: "Explore endless possibilities." }
    ];

    let currentHeroIndex = 0;

    
    settingsBtn.addEventListener("click", () => settingsPanel.classList.add("open"));
    closeSettings.addEventListener("click", () => settingsPanel.classList.remove("open"));

   
    function loadSettings() {
        heroSlides = JSON.parse(localStorage.getItem("heroSlides")) || heroSlides;

        
        heroSlideSelect.innerHTML = "";
        heroSlides.forEach((slide, index) => {
            let option = document.createElement("option");
            option.value = index;
            option.textContent = `Slide ${index + 1}`;
            heroSlideSelect.appendChild(option);
        });

      
        updateSlideInputs(0);

       
        heroBgInput.value = localStorage.getItem("heroBg") || "#003366";
        leftBgInput.value = localStorage.getItem("leftBg") || "#ffffff";
        rightBgInput.value = localStorage.getItem("rightBg") || "#f4f4f4";

      
        heroSection.style.backgroundColor = heroBgInput.value;
        leftContent.style.backgroundColor = leftBgInput.value;
        document.querySelector(".rightContent").style.backgroundColor = rightBgInput.value;

      
        leftContent.querySelector("h2").textContent = localStorage.getItem("leftTitle") || "Welcome to Ateneo de Naga University Admissions";
        leftContent.querySelector("p").textContent = localStorage.getItem("leftText") || "The College Admissions and Aid Office (CAAO) is a student service office performing academic support functions...";
    }

    
    function updateSlideInputs(index) {
        leftTitleInput.value = localStorage.getItem("leftTitle") || leftContent.querySelector("h2").textContent;
        leftTextInput.value = localStorage.getItem("leftText") || leftContent.querySelector("p").textContent;

        document.getElementById("hero-title").value = heroSlides[index].title;
        document.getElementById("hero-text").value = heroSlides[index].text;
    }

    
    heroSlideSelect.addEventListener("change", function () {
        updateSlideInputs(heroSlideSelect.value);
    });

  
    function changeHeroImage() {
        if (heroSlides.length > 0) {
            heroSection.style.backgroundImage = `url(${heroSlides[currentHeroIndex].image})`;
            heroTitleElem.textContent = heroSlides[currentHeroIndex].title;
            heroTextElem.textContent = heroSlides[currentHeroIndex].text;
            currentHeroIndex = (currentHeroIndex + 1) % heroSlides.length;
        }
    }

   
heroUpload.addEventListener("change", function () {
    const file = heroUpload.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
           
            heroSlides.push({
                image: e.target.result,
                title: "New Slide",
                text: "Enter text here"
            });

           
            localStorage.setItem("heroSlides", JSON.stringify(heroSlides));

       
            loadSettings();
        };
        reader.readAsDataURL(file);
    }
});


    saveSettings.addEventListener("click", function () {
        let selectedIndex = heroSlideSelect.value;
        heroSlides[selectedIndex].title = document.getElementById("hero-title").value;
        heroSlides[selectedIndex].text = document.getElementById("hero-text").value;

     
        if (previewImage.src) {
            heroSlides[selectedIndex].image = previewImage.src;
        }

   
        localStorage.setItem("heroBg", heroBgInput.value);
        localStorage.setItem("leftBg", leftBgInput.value);
        localStorage.setItem("rightBg", rightBgInput.value);

      
        localStorage.setItem("leftTitle", leftTitleInput.value);
        localStorage.setItem("leftText", leftTextInput.value);

       
        localStorage.setItem("heroSlides", JSON.stringify(heroSlides));

   
        heroTitleElem.textContent = heroSlides[selectedIndex].title;
        heroTextElem.textContent = heroSlides[selectedIndex].text;
        heroSection.style.backgroundImage = `url(${heroSlides[selectedIndex].image})`;

     
        heroSection.style.backgroundColor = heroBgInput.value;
        leftContent.style.backgroundColor = leftBgInput.value;
        document.querySelector(".rightContent").style.backgroundColor = rightBgInput.value;

        
        leftContent.querySelector("h2").textContent = leftTitleInput.value;
        leftContent.querySelector("p").textContent = leftTextInput.value;

        settingsPanel.classList.remove("open");
        loadSettings();
    });

   
    resetSettings.addEventListener("click", function () {
        if (confirm("Are you sure you want to reset everything?")) {
            localStorage.clear();
            location.reload();
        }
    });

  
    setInterval(changeHeroImage, 3000);
    loadSettings();
    changeHeroImage();
});
