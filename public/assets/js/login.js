const submitLink = document.querySelector('#submit-form');
const loginForm = document.querySelector('#login-form');

submitLink.addEventListener('click', (e) => {
    e.preventDefault();
    loginForm.submit();
});

document.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault();
        loginForm.submit();
    }
});

const popup = document.querySelector(".popup")
const popupBtn = document.querySelector(".popup--btn");
popupBtn.addEventListener('click', (e)=> {
    e.preventDefault();
    popup.classList.toggle('hidden')
})