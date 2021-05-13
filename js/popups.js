//Récupération des différents conteneurs
let itemDetailsContainers = document.querySelectorAll(".popupContainer.itemDetailsContainer");
let notificationContainer = document.getElementById("notificationContainer");
let notificationExitButton = document.getElementById("notificationExitButton");
let notificationConfirmationButtonsContainer = document.getElementById("confirmationButtonsContainer");
let notificationMessageContainer = document.getElementById("notificationMessageContainer");

let overlay = document.getElementById("overlay");
if (overlay) overlay.addEventListener("click", () => { CloseAllPopups(); CloseNotifier(); CloseOverlay(); });

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
}

//Permet de fermer tous les popups
function CloseAllPopups() {
    RemoveOldContainers("popupConfirmationContainer");
    for(const popup of document.querySelectorAll('.popupContainer')) {
        popup.classList.remove("active");
    }
}

//Permet d'afficher un message à l'usager sous forme d'un popup
function NotifyWithPopup(text, buttonHidden = false, redirect) {
    if (notificationContainer) notificationContainer.classList.add("active");
    if (notificationMessageContainer) notificationMessageContainer.innerHTML = text;
    if (overlay) overlay.classList.add("active");
    if (buttonHidden)
        notificationConfirmationButtonsContainer.classList.add("hidden");
    if (redirect) {
        overlay.addEventListener("click", () => window.location.href = redirect);
        notificationExitButton.addEventListener("click", () => window.location.href = redirect);
        notificationConfirmationButtonsContainer.addEventListener("click", () => window.location.href = redirect);
    }
}

//Permet de fermer le popup de notification
function CloseNotifier() {
    if (notificationContainer)
        notificationContainer.classList.remove("active");
    if (notificationConfirmationButtonsContainer)
        notificationConfirmationButtonsContainer.classList.remove("hidden");
}

function CloseOverlay() {
    if (overlay) overlay.classList.remove("active");
}
