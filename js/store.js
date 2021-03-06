//Demande de mise à jour du contenu du store selon un envoyeur (store, inventory, evaluations)
function UpdateStoreContentOnFilter(filtersStr, alias, sender, idItem = "") {
    let request = "submit=setFilters" + "&filters=" + filtersStr +
        "&alias=" + alias + "&sender=" + sender + "&idItem=" + idItem;
    ServerRequest("POST", "../server/httpRequestHandler.php", request,
        (requete) => {
            switch (sender) {
                case "store":
                case "inventory":
                    RemoveOldContainers("storeContainer");
                    InsertHtmlTo(JSON.parse(requete.responseText), "storeReference");
                    break;
                case "evaluations":
                    if (idItem === "") { //Évaluations petits frames
                        RemoveOldContainers("evaluationsContainer");
                        InsertHtmlTo(JSON.parse(requete.responseText), "evaluationsReference");
                    } else { //Évaluations des joueurs
                        RemoveOldContainers("playerEvaluationContainer");
                        InsertHtmlTo(JSON.parse(requete.responseText), "playerEvaluationContainerReference");
                        UpdateAllStarbar(); //I know... I know...
                    }
                    break;
            }
        }, () => {
        }, false);
}

//Demande de création d'un popup de modification de quantité
function UpdateQuantity(id) {
    let targetAlias = GetUrlParamVal("alias");
    let sender = GetPageName();
    let quantity = document.getElementById(id + "_quantity").value;
    let request = "submit=createUpdateQuantityPopup" + "&idItem=" + id + "&quantity=" + quantity +
        "&alias=" + targetAlias + "&sender=" + sender;
    ServerRequest("POST", "../server/httpRequestHandler.php", request,
        (requete) => {
            CloseAllPopups();
            CloseNotifier();
            InsertHtmlTo(JSON.parse(requete.responseText), "popupReference");
        }, () => {
        });
}

function UpdateQuantityConfirm(idItem, alias, sender) {
    let quantity = document.getElementById(idItem + "_itemQuantity").value;
    if (quantity >= 1) {
        let request = "submit=updateQuantityConfirm" + "&idItem=" + idItem + "&quantity=" + quantity + "&alias=" + alias + "&sender=" + sender;
        ServerRequest("POST", "../server/httpRequestHandler.php", request,
            (requete) => {
                NotifyWithPopup(requete.responseText);
                switch (sender) {
                    case "store": //Inutilisé pour l'instant
                        break;
                    case "shopping-cart" :
                        UpdateShoppingCartContent();
                        UpdateTotalShoppingCartContent();
                        break;
                    case "inventory" : //Inutilisé pour l'instant
                        break;
                }
            },
            () => {
            });
    } else {
        NotifyWithPopup("Quantité invalide");
    }
}

//Demande de création d'un popup de suppression d'item
function DeleteItem(id, alias = null) {
    let targetAlias = alias == null ? GetUrlParamVal("alias") : alias;
    let sender = GetPageName();
    let request = "submit=createDeleteItemPopup" + "&idItem=" + id + "&alias=" + targetAlias + "&sender=" + sender;
    ServerRequest("POST", "../server/httpRequestHandler.php", request,
        (requete) => {
            CloseAllPopups();
            CloseNotifier();
            InsertHtmlTo(JSON.parse(requete.responseText), "popupReference");
        }, () => {
        });
}

function DeleteItemConfirm(idItem, alias, sender) {
    let request = "submit=deleteItemConfirm" + "&idItem=" + idItem + "&alias=" + alias + "&sender=" + sender;
    ServerRequest("POST", "../server/httpRequestHandler.php", request,
        (requete) => {
            NotifyWithPopup(requete.responseText);
            switch (sender) {
                case "store" :
                    UpdateStoreContentOnFilter(GetFiltersString(), alias, sender);
                    break;
                case "shopping-cart" :
                    UpdateShoppingCartContent();
                    UpdateTotalShoppingCartContent();
                    break;
                case "evaluations" :
                    UpdateEvaluationContent();
                    break;
            }
        },
        () => {
        });
}

//Demande d'ajout d'item dans le panier du joueur
function AddItemToCart(id) {
    let itemQuantityInput = document.getElementById(GetSiblingContainerId(id, "itemQuantity"));
    let quantity = itemQuantityInput.value;

    if (quantity > 0) {
        let request = "submit=addItemShoppingCart" + "&idItem=" + id + "&quantity=" + quantity;
        ServerRequest("POST", "../server/httpRequestHandler.php", request,
            (requete) => {
                NotifyWithPopup(requete.responseText);
                itemQuantityInput.value = 1;
            }, () => {
            });
    } else {
        NotifyWithPopup("Quantité invalide");
        itemQuantityInput.value = 1;
    }
}

//Ajout +1 à la quantité d'item
function AddItem(id) {
    let itemQuantityInput = document.getElementById(GetSiblingContainerId(id, "itemQuantity"));
    if (itemQuantityInput) {
        let count = parseInt(itemQuantityInput.value);
        if (!count) count = 0;
        itemQuantityInput.value = ++count;
    }
}

//Retrait -1 à la quantité d'item
function RemoveItem(id) {
    let itemQuantityInput = document.getElementById(GetSiblingContainerId(id, "itemQuantity"));
    if (itemQuantityInput) {
        let count = parseInt(itemQuantityInput.value);
        if (itemQuantityInput.value > 0)
            itemQuantityInput.value = --count;
    }
}