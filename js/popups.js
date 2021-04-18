//Récupération des différents conteneurs
let itemDetailsContainers = document.querySelectorAll(".popupContainer.itemDetailsContainer");
let notificationContainer = document.getElementById("notificationContainer");
let notificationMessageContainer = document.getElementById("notificationMessageContainer");

let overlay = document.getElementById("overlay");
if (overlay) overlay.addEventListener("click", () => CloseAllPopups());

function ClosePopupAndNotifier(id) {
        CloseNotifier();
        ClosePopup(id);
}

//Permet d'ouvrir un popup selon son id
function OpenPopup(id) {
    let popupContainer = document.getElementById(id);
    if (popupContainer) popupContainer.classList.add("active");
    if (overlay) overlay.classList.add("active");
}

//Permet de fermer un popup selon son id
function ClosePopup(id) {
    let popupContainer = document.getElementById(id);
    if (popupContainer) popupContainer.classList.remove("active");
    if (overlay) overlay.classList.remove("active");
}

//Permet de fermer tous les popups
function CloseAllPopups() {
    RemoveOldContainers("popupConfirmationContainer");
    for(const popup of document.querySelectorAll('.popupContainer')) {
        popup.classList.remove("active");
    }
    if (overlay) overlay.classList.remove("active");
}

//Permet d'afficher un message à l'usager sous forme d'un popup
function NotifyWithPopup(text) {
    if (notificationContainer) notificationContainer.classList.add("active");
    if (notificationMessageContainer) notificationMessageContainer.innerHTML = text;
    if (overlay) overlay.classList.add("active");
}

//Permet de fermer le popup de notification
function CloseNotifier() {
    if (notificationContainer) notificationContainer.classList.remove("active");
    if (overlay) overlay.classList.add("active");
}
