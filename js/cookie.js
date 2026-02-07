
const cookieBanner = document.getElementById('cookie-banner');
const acceptBtn = document.getElementById('accept-cookies');

// Verifica se já aceitou
if (!localStorage.getItem('cookiesAccepted')) {
cookieBanner.classList.remove('d-none');
}

// Aceitar cookies
acceptBtn.addEventListener('click', () => {
localStorage.setItem('cookiesAccepted', 'true');
cookieBanner.classList.add('d-none');
});

