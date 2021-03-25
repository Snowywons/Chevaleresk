function UpdateAllShoppingCartButtons() {
//Bouton Diminuer
    let removeItemButtons = document.querySelectorAll(".removeItem");
    removeItemButtons.forEach((item) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            removeItem(item);
        })
    });

//Bouton Ajouter
    let addItemButtons = document.querySelectorAll(".addItem");
    addItemButtons.forEach((item) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            addItem(item);
        })
    });
}

function UpdateAllAddToShoppingCartButtons() {
    let addToShoppingCartButtons = document.querySelectorAll(".addToShoppingCart");
    let itemQuantityInputs = document.querySelectorAll(".itemQuantity");
    addToShoppingCartButtons.forEach((item) => {
        item.addEventListener("click", (e) => {

            let array = Array.prototype.slice.call(itemQuantityInputs);
            let idItem = item.id.split('_')[0];
            let concatId = idItem + "_itemQuantity";
            let itemQuantityInput = array.find(element => element.id === concatId);
            let quantity = itemQuantityInput.value;

            if (quantity > 0) {

                let requete = new XMLHttpRequest();
                //OUVERTURE de la requête AJAX de type POST
                requete.open('POST', "../store/storeUpdate.php", true);
                //Construction du header
                requete.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                //ENVOIS de la requête
                requete.send("submit=" + "addToShoppingCart" + "&idItem=" + idItem + "&quantity=" + quantity);

                //Selon l'état de la requête
                requete.onreadystatechange = function () {
                    switch (requete.readyState) {
                        // 0 requête non initialisée
                        // 1 connexion au serveur établie
                        // 2 requête reçue
                        // 3 requête en cours de traitement
                        case 4: // 4 requête terminée et réponse reçue
                            if (requete.responseText.trim() !== '') {

                                //Si le joueur ne s'est pas authentifié
                                if (requete.responseText === "notLogged")
                                    window.location.href = "../session/login.php";
                            }
                            break;
                    }
                };
            }
        })
    });
}

function addItem(from) {
    let itemQuantityInput = getItemQuantityInput(from);
    if (itemQuantityInput) {
        let count = parseInt(itemQuantityInput.value);
        if (!count) count = 0;
        itemQuantityInput.value = count === 0 ? 1 : ++count;
    }
}

function removeItem(from) {
    let itemQuantityInput = getItemQuantityInput(from);
    if (itemQuantityInput) {
        let count = parseInt(itemQuantityInput.value);
        if (itemQuantityInput.value > 0)
            itemQuantityInput.value = --count;
    }
}

function getItemQuantityInput(from) {
    let itemQuantityInputs = document.querySelectorAll(".itemQuantity");
    let array = Array.prototype.slice.call(itemQuantityInputs);
    let troncId = from.id.split('_')[0];
    let formatId = troncId + "_itemQuantity";
    let itemQuantityInput = array.find(element => element.id === formatId);
    if (itemQuantityInput)
        return itemQuantityInput;
    return null;
}

UpdateAllShoppingCartButtons();
UpdateAllAddToShoppingCartButtons();