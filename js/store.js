function RemoveStoreContainer() {
    document.querySelectorAll(".storeContainer")[0].remove();
}

function SetStoreContainer(records) {
    let storePosition = document.getElementById("storeReference");
    storePosition.insertAdjacentHTML( 'beforeend', records );
    UpdateAllPopups();
    UpdateAllItemPreviewButtons();
    UpdateAllAddToShoppingCartButtons();
    UpdateAllShoppingCartButtons();
}