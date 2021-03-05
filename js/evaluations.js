//Bouton Voir les évaluation pour un item sélectionné (Popup)
let showEvaluationsButtons = document.querySelectorAll(".showEvaluations");
showEvaluationsButtons.forEach((item)=> {
    item.addEventListener("click", ()=> {
        document.location.href = "../evaluations/evaluations.php?idItem=" + item.id.split('_')[0];
    })
});

//Bouton Voir la liste des items évalués
let evaluationsListButtons = document.querySelectorAll(".evaluationsListButton");
evaluationsListButtons.forEach((item)=> {
    item.addEventListener("click", ()=> {
        document.location.href = "evaluations.php";
    })
});

//Conteneur/Bouton Voir une évaluation (Frame)
let itemEvaluationPreviewContainers = document.querySelectorAll(".itemEvaluationPreviewContainer");
itemEvaluationPreviewContainers.forEach((item)=> {
    item.addEventListener("click", ()=> {
        document.location.href = "./evaluations.php?idItem=" + item.id.split('_')[0];
    })
});
