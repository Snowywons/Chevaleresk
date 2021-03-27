//Permet de mettre à jour le contenu du store selon un envoyeur (store, shopping-cart)
function UpdateStoreContentOnFilter(sender, filtersStr) {
    let request = "submit=setFilters" + "&sender=" + sender + "&filters=" + filtersStr;
    ServerRequest("POST", "../store/storeUpdate", request,
        (requete) => {
            RemoveOldContainers("storeContainer");
            InsertHtmlTo(JSON.parse(requete.responseText), "storeReference");

            UpdateAllItemPreviewContainer();
            UpdateAllAdminItemButtonsContainers();
            UpdateAllDeleteButtons();

            UpdateAllAddItemShoppingCartButtons();
            UpdateAllAddItemButtons();
            UpdateAllRemoveItemButtons();
            UpdateAllSaveItemQuantityButtons();
        }, () => {
        }, false);
}

//Les conteneurs de classe (itemPreviewContainer) permettent d'ouvrir un popup de détails d'item
function UpdateAllItemPreviewContainer() {
    AddClickEventFor("itemPreviewContainer", (item) => {
        let siblingContainerId = GetSiblingContainerId(item.id, "itemDetailsContainer");
        OpenPopup(siblingContainerId);
    });
}

//Permet de mettre à jour tous les événements (click) liés aux
//conteneurs des boutons modifier et supprimer (réservés aux administrateurs) présents dans les conteneurs itemPreviewContainer
function UpdateAllAdminItemButtonsContainers() {
    AddClickEventFor("adminButtonsContainer", (item, event) => event.stopPropagation());
}

//Permet de mettre à jour tous les événements (click) liés aux boutons de sauvegarde de quantité du panier
function UpdateAllSaveItemQuantityButtons() {
    AddClickEventFor("saveButton", (item) =>
    {
        let sender = GetPageName();
        let idItem = GetSplitedId(item.id, '_');
        let itemQuantityInput = document.getElementById(GetSiblingContainerId(item.id, "itemQuantity"));
        let quantity = itemQuantityInput.value;

        if (quantity > 0) {
            let request = "submit=modifyItemQuantity" + "&sender=" + sender +
                "&idItem=" + idItem + "&quantity=" + quantity;
            ServerRequest("POST", "../store/storeUpdate", request,
                (requete) => {
                    NotifyWithPopup(requete.responseText);
                    UpdateTotalShoppingCartContent();
                }, () => {
                });
        } else {
            NotifyWithPopup("Quantité invalide");
        }
    });
}

//Permet de mettre à jour tous les événements (click) liés aux boutons de suppression d'item
function UpdateAllDeleteButtons() {
    AddClickEventFor("deleteButton", (item) => {
        let sender = GetPageName();
        let idItem = GetSplitedId(item.id, '_');
        let request = "submit=createDeleteConfirmContainer" + "&sender=" + sender + "&idItem=" + idItem;
        ServerRequest("POST", "../store/storeUpdate", request,
            (requete) => {
                CloseNotifier();
                RemoveOldContainers("itemDeleteConfirmationContainer");
                InsertHtmlTo(JSON.parse(requete.responseText), "deleteConfirmReference");
                UpdateAllPopupExitButtons();
                UpdateAllPopupDeleteConfirmButtons();
                UpdateAllPopupDeleteCancelButtons();
            }, () => {
            });
    });
}

//Permet de mettre à jour tous les événements (click) liés aux boutons d'ajout d'items au panier
function UpdateAllAddItemShoppingCartButtons() {
    AddClickEventFor("addToShoppingCart", (item) => {
        let idItem = GetSplitedId(item.id, '_');
        let itemQuantityInput = document.getElementById(GetSiblingContainerId(item.id, "itemQuantity"));
        let quantity = itemQuantityInput.value;

        if (quantity > 0) {
            let request = "submit=addItemShoppingCart" + "&idItem=" + idItem + "&quantity=" + quantity;
            ServerRequest("POST", "../store/storeUpdate", request,
                (requete) => {
                    if (requete.responseText === "notLogged") {
                        window.location.href = "../session/login.php";
                    } else {
                        NotifyWithPopup(requete.responseText);
                        itemQuantityInput.value = 1;
                    }
                }, () => {
                });
        } else {
            NotifyWithPopup("Quantité invalide");
            itemQuantityInput.value = 1;
        }
    });
}

//Permet de mettre à jour tous les événements (click) liés aux boutons d'ajout de quantité du store et du panier
function UpdateAllAddItemButtons() {
    AddClickEventFor("addItem", (item) => AddItem(item));
}

//Permet de mettre à jour tous les événements (click) liés aux boutons de diminution de quantité du store et du panier
function UpdateAllRemoveItemButtons() {
    AddClickEventFor("removeItem", (item) => RemoveItem(item));
}

function AddItem(item) {
    let itemQuantityInput = document.getElementById(GetSiblingContainerId(item.id, "itemQuantity"));
    if (itemQuantityInput) {
        let count = parseInt(itemQuantityInput.value);
        if (!count) count = 0;
        itemQuantityInput.value = ++count;
    }
}

function RemoveItem(item) {
    let itemQuantityInput = document.getElementById(GetSiblingContainerId(item.id, "itemQuantity"));
    if (itemQuantityInput) {
        let count = parseInt(itemQuantityInput.value);
        if (itemQuantityInput.value > 0)
            itemQuantityInput.value = --count;
    }
}

//Exécution des fonctions à l'ouverture (l'ordre est important)
UpdateAllItemPreviewContainer();
UpdateAllAdminItemButtonsContainers();
UpdateAllSaveItemQuantityButtons();
UpdateAllDeleteButtons();
UpdateAllAddItemShoppingCartButtons();
UpdateAllAddItemButtons();
UpdateAllRemoveItemButtons();