//Bouton Inventaire
let adminInventoryButtons = document.querySelectorAll(".adminInventoryButton");
adminInventoryButtons.forEach((item)=> {
    item.addEventListener("click", (e)=> {
        let troncId = item.id.split('_')[0];
        redirect("./inventory.php?idPlayer=" + troncId);
    });
});

//Bouton Modifier
let adminModifyButtons = document.querySelectorAll(".adminModifyButton");
adminModifyButtons.forEach((item)=> {
    item.addEventListener("click", (e)=> {
        let troncId = item.id.split('_')[0];
        redirect("./modify-profile.php?idPlayer=" + troncId);
    });
});

//Bouton Supprimer
let adminDeleteButtons = document.querySelectorAll(".adminDeleteButton");
adminDeleteButtons.forEach((item)=> {
    item.addEventListener("click", (e)=> {
        let troncId = item.id.split('_')[0];
        redirect("./delete-profile.php?idPlayer=" + troncId);
    });
});