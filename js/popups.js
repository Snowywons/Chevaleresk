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
        let popupId = idItem + "_popupConfirmationContainer";
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
                        UpdateStoreContentOnFilter("'AR','AM','PO','RS'", alias, sender);
                        UpdateTotalShoppingCartContent();
                        break;
                    case "inventory" :
                        UpdateStoreContentOnFilter(GetFiltersString(), alias, sender);
                        break;
                    case "administration" :
                        UpdateManagerContent();
                        break;
                }
            },
            () => {
            });
    });
}

//Permet de mettre à jour tous les événements (click) liés aux boutons de confirmation de modification de quantité
function UpdateAllPopupQuantityConfirmButtons() {
    AddClickEventFor("popupQuantityConfirmButton", (item) => {
        let idItem = item.id.split("_")[0];
        let alias = item.id.split("_")[1];
        let sender = item.id.split("_")[2];
        let popupId = idItem + "_popupConfirmationContainer";
        let quantity = parseInt(document.getElementById(idItem + "_itemQuantity").value);
        ClosePopup(popupId);

        if (quantity >= 1) {
            let request = "submit=quantityConfirm" + "&idItem=" + idItem + "&quantity=" + quantity + "&alias=" + alias + "&sender=" + sender;
            ServerRequest("POST", "../server/httpRequestHandler.php", request,
                (requete) => {
                    NotifyWithPopup(requete.responseText);
                    switch (sender) {
                        case "store" :
                            UpdateStoreContentOnFilter(GetFiltersString(), alias, sender);
                            break;
                        case "shopping-cart" :
                            UpdateStoreContentOnFilter("'AR','AM','PO','RS'", alias, sender);
                            UpdateTotalShoppingCartContent();
                            break;
                        case "inventory" :
                            UpdateStoreContentOnFilter(GetFiltersString(), alias, sender);
                            break;
                        case "administration" :
                            UpdateManagerContent();
                            break;
                    }
                },
                () => {
                });
        } else {
        NotifyWithPopup("Quantité invalide");
    }
    });
}


//Permet de mettre à jour tous les événements (click) liés aux boutons de fermeture de popups
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
