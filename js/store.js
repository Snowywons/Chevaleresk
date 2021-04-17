//Permet de mettre à jour le contenu du store selon un envoyeur (store, shopping-cart)
function UpdateStoreContentOnFilter(filtersStr, alias, sender) {
    let request = "submit=setFilters" + "&filters=" + filtersStr + "&alias=" + alias + "" + "&sender=" + sender;
    ServerRequest("POST", "../server/httpRequestHandler.php", request,
        (requete) => {
            RemoveOldContainers("storeContainer");
            InsertHtmlTo(JSON.parse(requete.responseText), "storeReference");
        }, () => {
        }, false);
}


//Permet de mettre à jour tous les événements (click) liés aux boutons de sauvegarde de quantité du panier
function SaveItemQuantity(id) {
    let itemQuantityInput = document.getElementById(GetSiblingContainerId(id, "itemQuantity"));
    let quantity = itemQuantityInput.value;
    let targetAlias = GetUrlParamVal("alias");
    let sender = GetPageName();

    if (quantity > 0) {
        let request = "submit=modifyItemQuantity" + "&idItem=" + id + "&quantity=" + quantity +
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
}


//Permet de mettre à jour tous les événements (click) liés aux boutons de modification de quantité
function UpdateQuantity(id) {
        let targetAlias = GetUrlParamVal("alias");
        let sender = GetPageName();
        let quantity = document.getElementById(id + "_quantity").value;
        let request = "submit=createQuantityContainer" + "&idItem=" + id + "&quantity=" + quantity +
            "&alias=" + targetAlias + "&sender=" + sender;
        ServerRequest("POST", "../server/httpRequestHandler.php", request,
            (requete) => {
                CloseAllPopups();
                CloseNotifier();
                RemoveOldContainers("quantityContainer");
                InsertHtmlTo(JSON.parse(requete.responseText), "popupContentReference");
                UpdateAllPopupQuantityConfirmButtons();
            }, () => {
            });
}

//Permet de mettre à jour tous les événements (click) liés aux boutons de suppression d'item
function CreateDeletePopup(id) {
    let targetAlias = GetUrlParamVal("alias");
    let sender = GetPageName();
    let request = "submit=createDeleteContainer" + "&idItem=" + id + "&alias=" + targetAlias + "&sender=" + sender;
    ServerRequest("POST", "../server/httpRequestHandler.php", request,
        (requete) => {
            CloseAllPopups();
            CloseNotifier();
            RemoveOldContainers("itemDeleteConfirmationContainer");
            InsertHtmlTo(JSON.parse(requete.responseText), "popupContentReference");
        }, () => {
        });
}


//Permet de mettre à jour tous les événements (click) liés aux boutons d'ajout d'items au panier
function AddItemToCart(id) {
    let itemQuantityInput = document.getElementById(GetSiblingContainerId(id, "itemQuantity"));
    let quantity = itemQuantityInput.value;

    if (quantity > 0) {
        let request = "submit=addItemShoppingCart" + "&idItem=" + id + "&quantity=" + quantity;
        ServerRequest("POST", "../server/httpRequestHandler.php", request,
            (requete) => {
                if (requete.responseText === "notLogged") {
                    NotifyWithPopup("Vous devez être connecté pour ajouter un item au panier");
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
}

function AddItem(id) {
    let itemQuantityInput = document.getElementById(GetSiblingContainerId(id, "itemQuantity"));
    if (itemQuantityInput) {
        let count = parseInt(itemQuantityInput.value);
        if (!count) count = 0;
        itemQuantityInput.value = ++count;
    }
}

function RemoveItem(id) {
    let itemQuantityInput = document.getElementById(GetSiblingContainerId(id, "itemQuantity"));
    if (itemQuantityInput) {
        let count = parseInt(itemQuantityInput.value);
        if (itemQuantityInput.value > 0)
            itemQuantityInput.value = --count;
    }
}