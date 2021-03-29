//Récupération des différents conteneurs
let itemDetailsContainers = document.querySelectorAll(".popupContainer.itemDetailsContainer");
let notificationContainer = document.getElementById("notificationContainer");
let notificationMessageContainer = document.getElementById("notificationMessageContainer");

let overlay = document.getElementById("overlay");
if (overlay) overlay.addEventListener("click", () => CloseAllPopups());

//Permet de mettre à jour tous les événements (click) liés aux boutons de confirmation de suppression des popups
function UpdateAllPopupDeleteConfirmButtons() {
    AddClickEventFor("popupDeleteConfirmButton", (item) => {
        let idItem = item.id.split("_")[0];
        let alias = item.id.split("_")[1];
        let sender = item.id.split("_")[2];
        let popupId = idItem + "_itemDeleteConfirmationContainer";
        ClosePopup(popupId);

        let request = "submit=deleteConfirm" + "&idItem=" + idItem + "&alias=" + alias + "&sender=" + sender;
        ServerRequest("POST", "../server/httpRequestHandler.php", request,
            (requete) => {
                NotifyWithPopup(requete.responseText);
                switch (sender) {
                    case "store" :
                        UpdateStoreContentOnFilter(GetFiltersString(), alias, sender);
                        break;
                    case "shopping-cart" :
                        UpdateStoreContentOnFilter(GetFiltersString(), alias, sender);
                        UpdateTotalShoppingCartContent();
                        break;
                    case "inventory" :
                        UpdateStoreContentOnFilter(GetFiltersString(), alias, sender);
                        break;
                    case "administration" :
                        UpdateManagerContent();
                        UpdateAllModifyButtons();
                        break;
                }
            },
            () => {
            });
    });
}

//Permet de mettre à jour tous les événements (click) liés aux boutons d'annulation de suppression des popups
function UpdateAllPopupDeleteCancelButtons() {
    AddClickEventFor("popupCancelConfirmButton", (item) => {
        let popupId = GetSiblingContainerId(item.id, "itemDeleteConfirmationContainer");
        ClosePopup(popupId);
    });
}

//Permet de mettre à jour tous les événements (click) liés aux boutons de fermeture de popups
function UpdateAllPopupExitButtons() {
    AddClickEventFor("popupExitButton", (item) => {
        let siblingContainerId = GetParentNode(item, 1, "popupContainer").id;
        CloseNotifier();
        ClosePopup(siblingContainerId);
    });
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
    RemoveOldContainers("itemDeleteConfirmationContainer");
    itemDetailsContainers.forEach((item) => item.classList.remove("active"));
    if (notificationContainer) notificationContainer.classList.remove("active");
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

//Exécution des fonctions à l'ouverture
UpdateAllPopupExitButtons();