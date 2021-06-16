import { Modal } from 'bootstrap/dist/js/bootstrap.bundle';

const loginForm = document.querySelector('.login-button');
loginForm.addEventListener('click', (event) => {
    event.preventDefault();
    const route = '/login';
    fetch(route)
        .then((response) => response.text)
        .then((html) => {
        });
});
