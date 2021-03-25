function RemoveStoreContainer() {
    document.querySelectorAll(".storeContainer")[0].remove();
}

function SetStoreContainer(records) {
    let storePosition = document.getElementById("storeReference");
    storePosition.insertAdjacentHTML( 'beforeend', records );
    UpdateAllPopups();
    UpdateAllItemPreviewButtons();
    UpdateAllAddToShoppingCartButtons();
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
                                console.log(requete.responseText);
                            }
                            break;
                    }
                };
            }
        })
    });
}

UpdateAllAddToShoppingCartButtons();