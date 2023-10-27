const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener('click', () =>{
    container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener('click', () =>{
    container.classList.remove("sign-up-mode");
});
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission for now

    var formData = new FormData(this);

    fetch("../php/login.php", {
        method: "POST",
        body: formData,
    })
    .then(response => {
        if (response.status === 200) {
            // Password is correct, you can handle the redirection here
            window.location.href = "../index.html"; // Redirect to a success page
        } else if (response.status === 403) {
            showPasswordError();
        }
    })
    .catch(error => {
        console.error(error);
    });
});

function showPasswordError() {
    var passwordErrorElement = document.getElementById("passwordError");
    passwordErrorElement.style.display = "block";
}
