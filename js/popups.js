//Récupération des différents conteneurs
let itemDetailsContainers = document.querySelectorAll(".popupContainer.itemDetailsContainer");
let itemDeleteConfirmationContainers = document.querySelectorAll(".popupContainer.itemDeleteConfirmationContainer");
let notificationContainer = document.getElementById("notificationContainer");
let notificationMessageContainer = document.getElementById("notificationMessageContainer");

//Récupération de l'overlay
let overlay = document.getElementById("overlay");

//Permet de mettre à jour tous les événements (click) liés aux popups
function UpdateAllPopups() {
    //Overlay (l'écran noir derrière un popup)
    overlay.addEventListener("click", () => CloseAllPopups());

    //Les conteneurs de classe (itemPreviewContainer) permettent d'ouvrir un popup de détails d'item
    let itemPreviewContainers = document.querySelectorAll(".itemPreviewContainer");
    itemPreviewContainers.forEach((item) => {
        item.addEventListener("click", () => {
            let siblingContainerId = GetSiblingContainerId(item.id, "itemDetailsContainer");
            OpenPopup(siblingContainerId);
        })
    });

    //Les boutons de classe (deleteButton) permettent d'ouvrir un popup de confirmation de suppression
    let deleteButtons = document.querySelectorAll(".deleteButton");
    deleteButtons.forEach((item) => {
        item.addEventListener("click", () => {
            let siblingContainerId = GetSiblingContainerId(item.id, "itemDeleteConfirmationContainer");
            OpenPopup(siblingContainerId);
        })
    });

    //Les boutons de classe (popupExitButton) permettent de fermer tous les popups
    let itemDetailsContainerExitButtons = document.querySelectorAll(".popupExitButton");
    itemDetailsContainerExitButtons.forEach((item) => {
        item.addEventListener("click", () => {
            let siblingContainerId = GetParentNode(item, 1, "popupContainer").id;
            ClosePopup(siblingContainerId);
        })
    });
}

//Permet d'ouvrir un popup selon son id
function OpenPopup (id) {
    let popupContainer = document.getElementById(id);
    if (popupContainer) {
        popupContainer.classList.add("active");
        overlay.classList.add("active");
    }
}

//Permet de fermer un popup selon son id
function ClosePopup (id) {
    let popupContainer = document.getElementById(id);
    if (popupContainer) {
        popupContainer.classList.remove("active");
        overlay.classList.remove("active");
    }
}

//Permet de fermer tous les popups
function CloseAllPopups() {
    itemDetailsContainers.forEach((item) => item.classList.remove("active"));
    itemDeleteConfirmationContainers.forEach((item) => item.classList.remove("active"));
    notificationContainer.classList.remove("active");
    overlay.classList.remove("active");
}

//Permet d'afficher un message à l'usager sous forme d'un popup
function NotifyWithPopup(text) {
    notificationContainer.classList.add("active");
    notificationMessageContainer.innerText = text;
    overlay.classList.add("active");
}

//Permet de fermer le popup de notification
function CloseNotifier() {
    notificationContainer.classList.remove("active");
    overlay.classList.add("active");
}

//Exécution des fonctions à l'ouverture
UpdateAllPopups();