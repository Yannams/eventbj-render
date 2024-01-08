import './bootstrap';

const circles = document.querySelectorAll(".circle"),
progressBar = document.querySelector(".indicator"),
buttons = document.querySelectorAll("button");

let currentStep = 0;

const updateSteps = (e) => {

    currentStep=e.target.id === "next" ? ++currentStep : --currentStep;
    
    circles.forEach((circle,index) =>{
        circle.classList[`${index < currentStep ? "add" : "remove"}`]("active");
    });

    progressBar.style.width = `${((currentStep - 1)/(circles.length -1))*100}%`;

  


    document.querySelectorAll('.form-step').forEach(step => {
        step.style.display = 'none';
    });

    // Afficher la div de l'étape actuelle
    const currentStepDiv = document.querySelector(`.form-step[data-step="${currentStep}"]`);
    if (currentStepDiv) {
        currentStepDiv.style.display = 'block';
    }

    if (currentStep === circles.length) {
        buttons[1].disabled = true;
    } else if (currentStep === 1) {    
        buttons[0].disabled = true;
    }else{
        buttons.forEach((button) => (button.disabled = false));
    }

    if (currentStep < circles.length) {
        const formId = `#form-step-${currentStep}`;
        const formData = $(formId).serialize();

        $.ajax({
            type: 'POST',
            url: $(formId).attr('action'),
            data: formData,
            success: function (response) {
                // Traite la réponse du serveur si nécessaire
                console.log(response);
            },
            error: function (error) {
                // Gère les erreurs
                console.error(error);
            }
        });
    }
};
buttons.forEach((button) => {
    button.addEventListener("click", updateSteps);
});


document.addEventListener("DOMContentLoaded", function () {
    // Appelle la fonction au chargement de la page
    updateSteps({
        target: {
            id: "next" // Choisis "next" ou "prev" selon l'étape initiale souhaitée
        }
    });
});
