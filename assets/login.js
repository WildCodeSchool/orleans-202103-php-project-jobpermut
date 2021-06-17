import { Modal } from 'bootstrap/dist/js/bootstrap.bundle';

/**
 * open modal after page loaded
 */
window.addEventListener('load', (event) => {
    if (document.querySelector('.error')) {
        const loginModal = new Modal(document.getElementById('loginModal'));
        loginModal.show();
    }
});
