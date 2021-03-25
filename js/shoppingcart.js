//Permet de payer le contenu du panier du joueur connecté
let payButton = document.getElementById("payButton");
if (payButton)
    payButton.addEventListener("click", () => {
        ServerRequest("POST", "../store/storeUpdate", "submit=payShoppingCart",
            (requete) =>
            {
                NotifyWithPopup(requete.responseText);
                UpdateStoreContentOnFilter(GetPageName(), GetFiltersString());
            }, ()=> {});
    });

//Permet de mettre à jour tous les événements (click) liés aux boutons addItem et removeItem du store et du panier
function UpdateAllAddRemoveItemButtons() {
    //Bouton Diminuer
    let removeItemButtons = document.querySelectorAll(".removeItem");
    removeItemButtons.forEach((item) => {
        if (item.getAttribute('listener') !== 'true') {
            item.addEventListener("click", (e) => {
                e.preventDefault();
                RemoveItem(item);
            });
            item.setAttribute('listener', 'true');
        }
    });

    //Bouton Ajouter
    let addItemButtons = document.querySelectorAll(".addItem");
    addItemButtons.forEach((item) => {
        if (item.getAttribute('listener') !== 'true') {
            item.addEventListener("click", (e) => {
                e.preventDefault();
                AddItem(item);
            });
            item.setAttribute('listener', 'true');
        }
    });

    //Bouton Supprimer
    let deleteConfirmButtons = document.querySelectorAll(".deleteConfirmButton");
    deleteConfirmButtons.forEach((item) => {
        if (item.getAttribute('listener') !== 'true') {
            item.addEventListener("click", (e) => {
                e.preventDefault();
                let idItem = item.id.split("_")[0];
                let popupId = idItem + "_itemDeleteConfirmationContainer";
                ClosePopup(popupId);

                let request = "submit=deleteFromShoppingCart" + "&idItem=" + idItem;
                ServerRequest("POST", "../store/storeUpdate.php", request,
                    (requete) => {
                        NotifyWithPopup(requete.responseText);
                        UpdateStoreContentOnFilter(GetPageName(), GetFiltersString());
                    },
                    () => {});
            });
            item.setAttribute('listener', 'true');
        }
    });
}

function UpdateAllAddToShoppingCartButtons() {
    let addToShoppingCartButtons = document.querySelectorAll(".addToShoppingCart");
    let itemQuantityInputs = document.querySelectorAll(".itemQuantity");
    addToShoppingCartButtons.forEach((item) => {
        if (item.getAttribute('listener') !== 'true') {
            item.addEventListener("click", (e) => {

                let array = Array.prototype.slice.call(itemQuantityInputs);
                let idItem = item.id.split('_')[0];
                let concatId = idItem + "_itemQuantity";
                let itemQuantityInput = array.find(element => element.id === concatId);
                let quantity = itemQuantityInput.value;

                if (quantity > 0) {

                    let request = "submit=" + "addToShoppingCart" + "&idItem=" + idItem + "&quantity=" + quantity;
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
            item.setAttribute('listener', 'true');
        }
    });
}

function AddItem(from) {
    let itemQuantityInput = GetItemQuantityInput(from);
    if (itemQuantityInput) {
        let count = parseInt(itemQuantityInput.value);
        if (!count) count = 0;
        itemQuantityInput.value = count === 0 ? 1 : ++count;
    }
}

function RemoveItem(from) {
    let itemQuantityInput = GetItemQuantityInput(from);
    if (itemQuantityInput) {
        let count = parseInt(itemQuantityInput.value);
        if (itemQuantityInput.value > 0)
            itemQuantityInput.value = --count;
    }
}

function GetItemQuantityInput(from) {
    let itemQuantityInputs = document.querySelectorAll(".itemQuantity");
    let array = Array.prototype.slice.call(itemQuantityInputs);
    let troncId = from.id.split('_')[0];
    let formatId = troncId + "_itemQuantity";
    let itemQuantityInput = array.find(element => element.id === formatId);
    if (itemQuantityInput)
        return itemQuantityInput;
    return null;
}

//Exécution des fonctions à l'ouverture
UpdateAllAddRemoveItemButtons();
UpdateAllAddToShoppingCartButtons();