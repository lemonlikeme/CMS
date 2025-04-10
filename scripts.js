function scrollToTop() {
    window.scrollTo({ top:0, behavior: 'smooth' });
}

const loginBtn = document.getElementById('loginBtn');
const closeBtn = document.querySelector('.close');
const modal = document.getElementById('authModal');
const container = document.getElementById('authContainer');

const slideToSignup = document.getElementById('slideToSignup');
const slideToLogin = document.getElementById('slideToLogin');

loginBtn.addEventListener('click', () => {
  modal.style.display = 'flex';
  container.classList.remove('right-panel-active');
});

closeBtn.addEventListener('click', () => {
  modal.style.display = 'none';
});

slideToSignup.addEventListener('click', () => {
  container.classList.add('right-panel-active');
});

slideToLogin.addEventListener('click', () => {
  container.classList.remove('right-panel-active');
});

window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
});
  