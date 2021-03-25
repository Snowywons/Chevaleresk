function RemoveStoreContainer() {
    document.querySelectorAll(".storeContainer")[0].remove();
}

function SetStoreContainer(records) {
    let storePosition = document.getElementById("storeReference");
    storePosition.insertAdjacentHTML( 'beforeend', records );
    UpdateAllPopups();
    UpdateAllItemPreviewButtons();
    UpdateAllAddToShoppingCartButtons();
    UpdateAllAddRemoveItemButtons();
}

function UpdateStoreContentOnFilter(sender, filtersStr) {
    let request = "submit=setFilters" + "&sender=" + sender + "&filters=" + filtersStr;
    ServerRequest("POST", "../store/storeUpdate", request,
        (requete) => {
            let records = JSON.parse(requete.responseText);
            RemoveStoreContainer();
            SetStoreContainer(records);
        },
        () => {}, false);
}