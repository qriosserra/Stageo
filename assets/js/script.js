

document.addEventListener('DOMContentLoaded', function () {
    var dropdownElementList = [].slice.call(document.querySelectorAll('[data-dropdown-toggle]'));

    dropdownElementList.forEach(function (dropdownToggle) {
      dropdownToggle.addEventListener('click', function (event) {
        // Prevent the default behaviour and stop propagation
        event.preventDefault();
        event.stopPropagation();

        // Find the dropdown content
        var dropdownContent = document.getElementById(dropdownToggle.getAttribute('data-dropdown-toggle'));

        // Toggle the 'hidden' class
        dropdownContent.classList.toggle('hidden');
      });
    });

    // Clicking outside the dropdown to close it
    document.addEventListener('click', function (event) {
      dropdownElementList.forEach(function (dropdownToggle) {
        var dropdownContent = document.getElementById(dropdownToggle.getAttribute('data-dropdown-toggle'));

        // If clicked outside and dropdown is not hidden, then hide it
        if (!dropdownContent.classList.contains('hidden')) {
          dropdownContent.classList.add('hidden');
        }
      });
    });
    var flashMessages = document.querySelectorAll('.flash-messages-container');
    function hideFlashMessage(message) {
        message.classList.add('!hidden');
        console.log("dans la fonction")
    }
    console.log("dans le listeneur");
    flashMessages.forEach(function(message) {
        setTimeout(function() {
            console.log("dans le minuteur");hideFlashMessage(message); }, 3000);
    });


    function setupDropdown(dropdownButtonId, dropdownContentId) {
        const dropdownButton = document.getElementById(dropdownButtonId);
        const dropdownContent = document.getElementById(dropdownContentId);

        dropdownButton.addEventListener('click', function (e) {
            if (window.innerWidth < 768) {
                e.preventDefault();

                // Par exemple: window.location.href = 'votre_lien_cible';
            }
        });

        dropdownButton.addEventListener('mouseenter', function () {
            if (window.innerWidth >= 768) {
                dropdownContent.classList.add('active');
            }
        });

        dropdownButton.addEventListener('mouseleave', function () {
            if (window.innerWidth >= 768) {
                setTimeout(() => {
                    if (!dropdownContent.matches(':hover')) {
                        dropdownContent.classList.remove('active');
                    }
                }, 10);
            }
        });
        dropdownContent.addEventListener('mouseenter', function () {
            dropdownContent.classList.add('active');
        });

        dropdownContent.addEventListener('mouseleave', function () {
            dropdownContent.classList.remove('active');
        });
    }

    setupDropdown('dropdownOffres', 'dropdownContentOffres');
    setupDropdown('dropdownButtonEntreprise', 'dropdownContentEntreprise');
    setupDropdown('dropdownButtonMission', 'dropdownContentMission');
});
const toggleButton = document.querySelector('[data-collapse-toggle="navbar-use"]');
const navbar = document.getElementById('navbar-use');
toggleButton.addEventListener('click', function () {
    navbar.classList.toggle('hidden');
});
function toggleContent(id) {

    const contents = document.querySelectorAll('.toggleable-content');
    const isContentCurrentlyHidden = document.getElementById(id).classList.contains('hiddene');

    contents.forEach(content => {
        content.classList.add('hiddene');
    });

    if (isContentCurrentlyHidden) {
        document.getElementById(id).classList.remove('hiddene');
    }
}

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

function redirectToLink(checkboxId, actionValue) {
    var checkbox = document.getElementById(checkboxId);
    if (checkbox.checked) {
        window.location.href = actionValue;
    }
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