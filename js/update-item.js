function UpdateItem() {
    event.preventDefault();

    let itemId = document.getElementById("idItem");
    let previousCodeType = document.getElementById("previousCodeType");
    let codePhoto = document.getElementById("codePhoto");
    let name = document.getElementById("name");
    let previousName = document.getElementById("previousName");
    let types = document.getElementById("types");
    let quantity = document.getElementById("quantity");
    let price = document.getElementById("price");
    let efficiency = document.getElementById("efficiency");
    let genders = document.getElementById("genders");
    let weaponDescription = document.getElementById("weaponDescription");
    let materials = document.getElementById("materials");
    let weight = document.getElementById("weight");
    let sizes = document.getElementById("sizes");
    let effect = document.getElementById("effect");
    let duration = document.getElementById("duration");
    let ressourceDescription = document.getElementById("ressourceDescription");
    let nameValidation =  document.getElementById("nameValidation");

    if (validateItemForm(false)) {
        NotifyWithPopup("Traitement en cours.", true);

        nameValidation.innerText = "";

        let data = new FormData();
        data.append('submit', 'updateItemDataBase');
        data.append('idItem', itemId.value);
        data.append('previousCodeType', previousCodeType.value);
        data.append('name', name.value);
        data.append('previousName', previousName.value);
        data.append('type', types.value);
        data.append('quantity', quantity.value);
        data.append('price', price.value);
        data.append('codePhoto', codePhoto.value);

        switch (types.value) {
            case "AE" : //Arme
                data.append('efficiency', efficiency.value);
                data.append('gender', genders.value);
                data.append('description', weaponDescription.value);
                break;
            case "AM" : //Armure
                data.append('material', materials.value);
                data.append('weight', weight.value);
                data.append('size', sizes.value);
                break;
            case "PO" : //Potion
                data.append('effect', effect.value);
                data.append('duration', duration.value);
                break;
            case "RS" :
                data.append('description', ressourceDescription.value);
                break;
        }

        let input = document.getElementById("ImageUploader");
        let file = input.files[0];
        if (file !== undefined)
            data.append('ImageUploader', file);

        let requete = new XMLHttpRequest();
        requete.open('POST', "../server/httpRequestHandler.php", true);
        requete.send(data);
        requete.onreadystatechange = function () {
            if (requete.readyState === 4) {
                CloseNotifier();

                switch (requete.status) {
                    case 200:
                        NotifyWithPopup(requete.responseText, false, "../store/store.php");
                        break;
                    case 400:
                        CloseOverlay();
                        CloseNotifier();
                        nameValidation.innerText = requete.responseText;
                        updateValidation(name, false);
                        break;
                }
            }
        }
    }
}