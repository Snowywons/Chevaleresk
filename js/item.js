//Conteneur des boutons Modifier et Supprimer
let adminItemButtonsContainers = document.querySelectorAll(".adminButtonsContainer");
adminItemButtonsContainers.forEach((item)=> {
    item.addEventListener("click", (e)=> {
        e.stopPropagation();
    });
});

//Bouton Modifier
let adminModifyButtons = document.querySelectorAll(".adminModifyButton");
adminModifyButtons.forEach((item)=> {
    item.addEventListener("click", (e)=> {
        let troncId = item.id.split('_')[0];
        redirect("./modify-item.php?idItem=" + troncId);
    });
});

//Bouton Supprimer
let adminDeleteButtons = document.querySelectorAll(".adminDeleteButton");
adminDeleteButtons.forEach((item)=> {
    item.addEventListener("click", (e)=> {
        let troncId = item.id.split('_')[0];
        redirect("./delete-item.php?idItem=" + troncId);
    });
});

//Conteneur/Bouton Ajouter
let adminAddItemContainers = document.querySelectorAll(".adminAddItemContainer");
adminAddItemContainers.forEach((item)=> {
    item.addEventListener("click", ()=> {
        redirect("./add-item.php");
    });
});