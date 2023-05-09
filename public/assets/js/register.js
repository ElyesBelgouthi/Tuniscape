const submitLink = document.querySelector("#submit-form");
const registrationForm = document.querySelector("#registration-form");

submitLink.addEventListener("click", (e) => {
  e.preventDefault();
  registrationForm.submit();
});
