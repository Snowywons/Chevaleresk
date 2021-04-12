AddClickEventFor("addItemStoreContainer", () => window.location.href = "../store/add-item.php");

//Permet de mettre à jour le contenu du store selon un envoyeur (store, shopping-cart)
function UpdateStoreContentOnFilter(filtersStr, alias, sender) {
    let request = "submit=setFilters" + "&filters=" + filtersStr + "&alias=" + alias + "" + "&sender=" + sender;
    ServerRequest("POST", "../server/httpRequestHandler.php", request,
        (requete) => {
            RemoveOldContainers("storeContainer");
            InsertHtmlTo(JSON.parse(requete.responseText), "storeReference");

            UpdateAllItemPreviewContainer();
            UpdateAllAdminItemButtonsContainers();
            UpdateAllModifyButtons();
            UpdateAllQuantityButtons();
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
    AddClickEventFor("saveButton", (item) => {
        let idItem = GetSplitedId(item.id, '_');
        let itemQuantityInput = document.getElementById(GetSiblingContainerId(item.id, "itemQuantity"));
        let quantity = itemQuantityInput.value;
        let targetAlias = GetUrlParamVal("alias");
        let sender = GetPageName();

        if (quantity > 0) {
            let request = "submit=modifyItemQuantity" + "&idItem=" + idItem + "&quantity=" + quantity +
                "&alias=" + targetAlias + "&sender=" + sender;
            ServerRequest("POST", "../server/httpRequestHandler.php", request,
                (requete) => {
                    NotifyWithPopup(requete.responseText);
                    switch (sender) {
                        case "store" :
                            break;
                        case "shopping-cart" :
                            UpdateTotalShoppingCartContent();
                            break;
                        case "inventory" :
                            break;
                    }
                }, () => {
                });
        } else {
            NotifyWithPopup("Quantité invalide");
        }
    });
}

//Permet de mettre à jour tous les événements (click) liés aux boutons d'inventaire
function UpdateAllBagButtons() {
    AddClickEventFor("bagButton", (item) => {
        let sender = GetPageName();
        let idItem = GetSplitedId(item.id, '_');
        switch (sender) {
            case "administration" :
                window.location.href = "../profile/inventory.php?alias=" + idItem;
                break;
        }
    })
}

//Permet de mettre à jour tous les événements (click) liés aux boutons de modification d'item
function UpdateAllModifyButtons() {
    AddClickEventFor("modifyButton", (item) => {
        let sender = GetPageName();
        let idItem = GetSplitedId(item.id, '_');
        switch (sender) {
            case "store" :
                window.location.href = "../store/modify-item.php?idItem=" + idItem;
                break;
            case "administration" :
                window.location.href = "../profile/modify-profile.php?alias=" + idItem;
                break;
        }
    })
}

//Permet de mettre à jour tous les événements (click) liés aux boutons de modification de quantité
function UpdateAllQuantityButtons() {
    AddClickEventFor("quantityButton", (item) => {
        let idItem = GetSplitedId(item.id, '_');
        let targetAlias = GetUrlParamVal("alias");
        let sender = GetPageName();
        let quantity = document.getElementById(idItem + "_quantity").value;
        let request = "submit=createQuantityContainer" + "&idItem=" + idItem + "&quantity=" + quantity +
            "&alias=" + targetAlias + "&sender=" + sender;
        ServerRequest("POST", "../server/httpRequestHandler.php", request,
            (requete) => {
                CloseAllPopups();
                CloseNotifier();
                RemoveOldContainers("quantityContainer");
                InsertHtmlTo(JSON.parse(requete.responseText), "popupContentReference");
                UpdateAllPopupExitButtons();
                UpdateAllPopupQuantityConfirmButtons();
                UpdateAllPopupCancelButtons();
                UpdateAllAddItemButtons();
                UpdateAllRemoveItemButtons();
            }, () => {
            });
    });
}

//Permet de mettre à jour tous les événements (click) liés aux boutons de suppression d'item
function UpdateAllDeleteButtons() {
    AddClickEventFor("deleteButton", (item) => {
        let idItem = GetSplitedId(item.id, '_');
        let targetAlias = GetUrlParamVal("alias");
        let sender = GetPageName();
        let request = "submit=createDeleteContainer" + "&idItem=" + idItem + "&alias=" + targetAlias + "&sender=" + sender;
        ServerRequest("POST", "../server/httpRequestHandler.php", request,
            (requete) => {
                CloseAllPopups();
                CloseNotifier();
                RemoveOldContainers("itemDeleteConfirmationContainer");
                InsertHtmlTo(JSON.parse(requete.responseText), "popupContentReference");
                UpdateAllPopupExitButtons();
                UpdateAllPopupDeleteConfirmButtons();
                UpdateAllPopupCancelButtons();
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
            ServerRequest("POST", "../server/httpRequestHandler.php", request,
                (requete) => {
                    if (requete.responseText === "notLogged") {
                        NotifyWithPopup("Vous devez être connecté pour ajouter un item au panier");
                        //window.location.href = "../session/login.php";
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
UpdateAllBagButtons();
UpdateAllModifyButtons();
UpdateAllQuantityButtons();
UpdateAllDeleteButtons();
UpdateAllAddItemShoppingCartButtons();
UpdateAllAddItemButtons();
UpdateAllRemoveItemButtons();