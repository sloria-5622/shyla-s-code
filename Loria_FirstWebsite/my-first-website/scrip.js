const button = document.getElementById("welcomeButton");
const message = document.getElementById("message");

button.addEventListener("click", function () {

    message.textContent =
        "Thanks for visiting my website! Have a great day! 😊";

    button.textContent = "Thank You!";
});
