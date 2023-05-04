const submitLink = document.querySelector('#submit-form');
const loginForm = document.querySelector('#login-form');

submitLink.addEventListener('click', (e) => {
    e.preventDefault();
    loginForm.submit();
});
