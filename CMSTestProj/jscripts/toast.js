document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".sign-up-container form");
  
    if (!form) return;
  
    form.addEventListener("submit", async function (e) {
      e.preventDefault();
  
      const name = this.querySelector('input[placeholder="Name"]').value;
      const email = this.querySelector('input[placeholder="Email"]').value;
      const password = this.querySelector('input[placeholder="Password"]').value;
  
      const formData = new FormData();
      formData.append("name", name);
      formData.append("email", email);
      formData.append("password", password);
  
      try {
        const res = await fetch("db/register.php", {
          method: "POST",
          body: formData,
        });
  
        const result = await res.text();

        if (res.ok && result === "success") {
          showToast("Account created successfully!");
          this.reset();
        } else if (result === "Email already exists"){
            showToast("Email already exists. Please use a different one.");
        } else {
          showToast("Failed to create account.");
        }
      } catch (error) {
        showToast("An error occurred.");
      }
    });
});
  
  function showToast(message) {
    const toast = document.createElement("div");
    toast.textContent = message;
    toast.style.position = "fixed";
    toast.style.bottom = "30px";
    toast.style.left = "50%";
    toast.style.transform = "translateX(-50%)";
    toast.style.background = "#333";
    toast.style.color = "#fff";
    toast.style.padding = "12px 20px";
    toast.style.borderRadius = "8px";
    toast.style.boxShadow = "0 2px 10px rgba(0,0,0,0.3)";
    toast.style.zIndex = 9999;
    toast.style.opacity = "0";
    toast.style.transition = "opacity 0.5s ease";
  
    document.body.appendChild(toast);
  
    requestAnimationFrame(() => {
      toast.style.opacity = "1";
    });
  
    setTimeout(() => {
      toast.style.opacity = "0";
      toast.addEventListener("transitionend", () => toast.remove());
    }, 3000);
  }

document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.querySelector(".sign-in-container form");
    const modal = document.getElementById("authModal");
    const closeBtn = modal.querySelector(".close");
    const loginBtn = document.getElementById("loginBtn");

    if (!loginForm) return;
    

    loginForm.addEventListener("submit", async function (e) {
      e.preventDefault();
  
      const email = this.querySelector('input[placeholder="Email"]').value;
      const password = this.querySelector('input[placeholder="Password"]').value;
  
      const formData = new FormData();
      formData.append("email", email);
      formData.append("password", password);
  
      try {
        const res = await fetch("db/login.php", {
          method: "POST",
          body: formData,
        });
  
        const result = await res.text();
  
        if (res.ok && result === "success") {
            showToast("Logged in successfully!");

            this.reset();
            
            modal.style.display = "none";

            if (loginBtn) {
                loginBtn.textContent = "Logout";
                loginBtn.id = "logoutBtn";
                loginBtn.href = "#";
      
                
                loginBtn.addEventListener("click", function (e) {
                  e.preventDefault();
                  handleLogout();
                });
            }
        } else if (result === "Invalid credentials") {
          showToast("Incorrect email or password.");
        } else {
          showToast("Login failed.");
        }
      } catch (error) {
        showToast("An error occurred.");
      }
    });

    function handleLogout() {
        showToast("Logged out.");
        const logoutBtn = document.getElementById("logoutBtn");
        if (logoutBtn) {
        logoutBtn.textContent = "Log In";
        logoutBtn.id = "loginBtn";
        logoutBtn.href = "#";
        }
    }
});


  
  