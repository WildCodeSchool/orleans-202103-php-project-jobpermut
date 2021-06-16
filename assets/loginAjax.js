import { Modal } from 'bootstrap/dist/js/bootstrap.bundle.js';

//const myModal = new Modal(document.getElementById('loginModal'));
//myModal.show();
const loginForm = document.querySelector('.login-button');
loginForm.addEventListener('click', (event) => {
    event.preventDefault();
    const route = '/login';
    fetch(route)
    .then((response) => response.text)
    .then((html) => {
        var parser = new DOMParser();
        var doc = parser.parseFromString(html, 'text/html');
        console.log(doc)
    })
});
