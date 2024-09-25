// scroll
window.addEventListener('scroll', () => {
    document.querySelector('nav').classList.toggle('window-scroll', window.scrollY > 0);
})

// hover heh
const button = document.querySelector('.signup__submit');

button.addEventListener('mouseover', () => {
    button.value = "JOIN BAH!";
});

button.addEventListener('mouseout', () => {
    button.value = "Sign Up";
});

//credential style
const login_btn = document.getElementById('login-btn');
const signup_btn = document.getElementById('signup-btn');

const login_form = document.querySelector('.login__container');
const signup_form = document.querySelector('.signup__container');

function login() {
    login_form.style.left = "0";
    signup_form.style.left = "30rem";
}

function signup() {
    login_form.style.left = "-30rem";
    signup_form.style.left = "0";
}