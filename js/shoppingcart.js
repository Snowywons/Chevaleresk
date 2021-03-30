//Permet de mettre à jour le contenu du total dans le panier
function UpdateTotalShoppingCartContent() {
    ServerRequest("POST", "../server/httpRequestHandler.php", "submit=calculateShoppingCart",
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
        ServerRequest("POST", "../server/httpRequestHandler.php", "submit=payShoppingCart",
            (requete) => {
                NotifyWithPopup(requete.responseText);
                UpdateStoreContentOnFilter(GetFiltersString(), "", GetPageName());
                UpdateTotalShoppingCartContent();
            }, () => {
            });
    });
}

//Exécution des fonctions à l'ouverture
UpdateAllPayButtons();
