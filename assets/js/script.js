function rippleEffect(event) {
    const button = event.currentTarget;
    const circle = document.createElement("span");
    const diameter = Math.max(button.offsetWidth, button.offsetHeight);
    const radius = diameter / 2;

    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
    circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
    circle.classList.add("ripple");

    const ripple = button.querySelector(".ripple");

    if (ripple) {
        ripple.remove();
    }
    button.appendChild(circle);
}

function setFormAction(action) {
    // Récupération du formulaire de manière naïve.
    let form = document.querySelector("form");
    form.action = action; // Changez l'action du formulaire en fonction du bouton cliqué
    // form.submit(); // Soumettez le formulaire
}

const buttons = document.querySelectorAll("[class*='button-']");
for (const button of buttons) {
    button.addEventListener("click", rippleEffect);
}

let profilePicture = document.querySelector("#profile-picture");
let profilePictureInput = document.querySelector("#profilePicture");

profilePictureInput.onchange = () => {
    profilePicture.src = URL.createObjectURL(profilePictureInput.files[0]);
}