//Permet de mettre à jour le contenu du total dans le panier
function UpdateTotalShoppingCartContent() {
    ServerRequest("POST", "../store/storeUpdate", "submit=calculateShoppingCart",
        (requete) => {
            RemoveOldContainers("shoppingCartTotalContainer");
            InsertHtmlTo(JSON.parse(requete.responseText), "shoppingCartTotalReference");
        },
        () => {
        }, false);
}

//Permet de mettre à jour tous les événements (click) liés aux boutons de paiement du panier
function UpdateAllPayButtons() {
    AddClickEventFor("payButton", () => {
        ServerRequest("POST", "../store/storeUpdate", "submit=payShoppingCart",
            (requete) => {
                NotifyWithPopup(requete.responseText);
                UpdateStoreContentOnFilter(GetPageName(), GetFiltersString());
                UpdateTotalShoppingCartContent();
            }, () => {
            });
    });
}

//Exécution des fonctions à l'ouverture
UpdateAllPayButtons();