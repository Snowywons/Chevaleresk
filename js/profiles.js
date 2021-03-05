//Bouton Inventaire
let inventoryButtons = document.querySelectorAll(".inventoryButton");
inventoryButtons.forEach((item)=> {
    item.addEventListener("click", (e)=> {
        let troncId = item.id.split('_')[0];
        redirect("./inventory.php?idJoueur=" + troncId);
    });
});

//Bouton Modifier
let modifyButtons = document.querySelectorAll(".modifyButton");
modifyButtons.forEach((item)=> {
    item.addEventListener("click", (e)=> {
        let troncId = item.id.split('_')[0];
        redirect("./modify-profile.php?idJoueur=" + troncId);
    });
});

//Bouton Supprimer
let deleteButtons = document.querySelectorAll(".deleteButton");
deleteButtons.forEach((item)=> {
    item.addEventListener("click", (e)=> {
        let troncId = item.id.split('_')[0];
        redirect("./delete-profile.php?idJoueur=" + troncId);
    });
});