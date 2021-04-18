//Demande de mise à jour du contenu du total dans le panier
function UpdateTotalShoppingCartContent() {
    let targetAlias = GetUrlParamVal("alias");
    let request = "submit=calculateShoppingCart" + "&alias=" + targetAlias;
    ServerRequest("POST", "../server/httpRequestHandler.php", request,
        (requete) => {
            RemoveOldContainers("shoppingCartTotalContainer");
            InsertHtmlTo(JSON.parse(requete.responseText), "shoppingCartTotalReference");
        },
        () => {
        }, false);
}

//Demande de paiement du panier du joueur
function PayCart() {
    ServerRequest("POST", "../server/httpRequestHandler.php", "submit=payShoppingCart",
        (requete) => {
            NotifyWithPopup(requete.responseText);
            UpdateStoreContentOnFilter("'AR','AM','PO','RS'", "", GetPageName());
            UpdateTotalShoppingCartContent();
        }, () => {
        });
}

