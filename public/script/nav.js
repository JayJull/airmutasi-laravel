const nav = document.querySelector('header>nav');
const account = document.querySelector('header>#account');
const navOpener = document.querySelector('header>button');

function toggleNav() {
    nav.classList.toggle('hidden');
    nav.classList.toggle('flex');
    account.classList.toggle('hidden');
    account.classList.toggle('flex');
    navOpener.innerHTML = nav.classList.contains('hidden') ? '☰' : '✖';
}
navOpener.addEventListener('click', toggleNav);