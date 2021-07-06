/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';

const bootstrap = require('bootstrap');

window.addEventListener('load', (event) => {
    if (document.querySelector('.error')) {
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    }
});

const enterSite = document.getElementById('enter-site');
enterSite.addEventListener('click', (event) => {
    event.preventDefault();
    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    loginModal.show();
});

AOS.init();
