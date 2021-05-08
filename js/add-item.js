function AddItem() {
    event.preventDefault();

    let name = document.getElementById("name");
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

    if (validateAddItemForm()) {
        nameValidation.innerText = "";

        let data = new FormData();
        data.append('submit', 'addItemDataBase');
        data.append('name', name.value);
        data.append('type', types.value);
        data.append('quantity', quantity.value);
        data.append('price', price.value);

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
                    switch(requete.status) {
                        case 200:
                            NotifyWithPopup(`${quantity.value} ${name.value} ont été ajoutés au magasin.`, "../store/add-item");
                            break;
                        case 400:
                            nameValidation.innerText = requete.responseText;
                            updateValidation(name, false);
                            break;
                    }
                }
            }
    }
}

function ChangeTypeField() {
    let select = document.getElementById("types");

    let elems = document.querySelectorAll(".addItemInfosContainer");
    elems.forEach((item) => {
        if (!item.classList.contains("hidden"))
            item.classList.add("hidden");
    });

    let id = select.value + "_Informations";
    let elem = document.getElementById(id);
    elem.classList.remove("hidden");
}

function OpenImageUploader() {
    document.getElementById("ImageUploader").click();
}

function ChangeImagePreview() {
    let imagePreview = document.getElementById("UploadedImage");
    let input = document.getElementById("ImageUploader");

    validateImage();

    if (input.files[0] !== undefined) {
        let fileName = input.files[0].name;
        let ext = fileName.split('.').pop().toLowerCase();

        if ((ext !== "png") &&
            (ext !== "jpeg") &&
            (ext !== "jpg") &&
            (ext !== "bmp") &&
            (ext !== "gif")) {
            alert("Ce n'est pas un fichier d'image de format reconnu. Sélectionnez un autre fichier.");
        } else {
            let fReader = new FileReader();
            fReader.readAsDataURL(input.files[0]);
            fReader.onloadend = function (event) {
                imagePreview.src = event.target.result;
            }
        }
    } else {
        imagePreview.src = "../icons/DefaultIcon.png";
    }
}

function validateAddItemForm() {
    let formIsValid = true;
    let types = document.getElementById("types");

    formIsValid = !validateNameItem() ? false : formIsValid;
    formIsValid = !validateNotEmpty("types") ? false : formIsValid;
    formIsValid = !validateQuantity() ? false : formIsValid;
    formIsValid = !validatePrice() ? false : formIsValid;

    switch (types.value) {
        case "AE" : //Arme
            formIsValid = !validateEfficiency() ? false : formIsValid;
            formIsValid = !validateNotEmpty("genders") ? false : formIsValid;
            formIsValid = !validateWeaponDescription() ? false : formIsValid;
            break;
        case "AM" : //Armure
            formIsValid = !validateNotEmpty("materials") ? false : formIsValid;
            formIsValid = !validateWeight() ? false : formIsValid;
            formIsValid = !validateNotEmpty("sizes") ? false : formIsValid;
            break;
        case "PO" : //Potion
            formIsValid = !validateEffect() ? false : formIsValid;
            formIsValid = !validateDuration() ? false : formIsValid;
            break;
        case "RS" :
            formIsValid = !validateRessourceDescription() ? false : formIsValid;
            break;
    }

    formIsValid = !validateImage() ? false : formIsValid;

    return formIsValid;
}

function updateValidation(element, valid) {
    if (valid) {
        element.classList.remove('errorField');
        return true;
    }
    element.classList.add('errorField');
    return false;
}

function validateNotEmpty(id) {
    const element = document.getElementById(id);
    return updateValidation(element, element.value.length > 0);
}

function validateNotMoreThan(id, max) {
    const element = document.getElementById(id);
    return updateValidation(element, element.value.length <= max);
}

function validateNumber(id) {
    const element = document.getElementById(id);
    return updateValidation(element, element.value > 0);
}

function validateName(id) {
    const element = document.getElementById(id);
    return updateValidation(element, /[^0-9]$/.test(element.value));
} //OK

function validateNameItem() {
    if(!validateNotEmpty('name')){
        return false;
    }
    else if (!validateName('name')) {
        document.getElementById('nameValidation').innerHTML = "Format invalide";
        return false;
    } 
    else
    {
        document.getElementById('nameValidation').innerHTML = "";
        return true;
    }
} //OK

function validateQuantity(){
    if(!validateNotEmpty('quantity')){
        return false;
    }
    else if(!validateNumber('quantity'))
    {   
        document.getElementById('quantityValidation').innerHTML = "Quantité invalide";
        return false;
    }
    else
    {
        document.getElementById('quantityValidation').innerHTML = "";
        return true;
    }
} //OK

function validatePrice(){
    if(!validateNotEmpty('price')){
        return false;
    }
    else if(!validateNumber('price'))
    {   
        document.getElementById('priceValidation').innerHTML = "Quantité invalide";
        return false;
    }
    else
    {
        document.getElementById('priceValidation').innerHTML = "";
        return true;
    }
} //OK

function validateEfficiency(){
    if(!validateNotEmpty('efficiency')){
        return false;
    }
    else if(!validateNumber('efficiency'))
    {   
        document.getElementById('efficiencyValidation').innerHTML = "Quantité invalide";
        return false;
    }
    else
    {
        document.getElementById('efficiencyValidation').innerHTML = "";
        return true;
    }
} //OK

function validateWeaponDescription() {
    if(!validateNotEmpty('weaponDescription')){
        return false;
    }
    else if(!validateNotMoreThan('weaponDescription', 280)) {
        return false;
    }
    else
    {
        document.getElementById('descriptionValidation').innerHTML = "";
        return true;
    }
} //OK

function validateWeight(){
    if(!validateNotEmpty('weight')){
        return false;
    }
    else if(!validateNumber('weight'))
    {   
        document.getElementById('weightValidation').innerHTML = "Poids invalide";
        return false;
    }
    else
    {
        document.getElementById('weightValidation').innerHTML = "";
        return true;
    }
} //OK

function validateEffect(){
    if(!validateNotEmpty('effect')){
        return false;
    }
    else if(!validateNotMoreThan('effect', 280)) {
        return false;
    }
    else
    {
        document.getElementById('effectValidation').innerHTML = "";
        return true;
    }
} //OK

function validateDuration(){
    if(!validateNotEmpty('duration')){
        return false;
    }
    else if(!validateNumber('duration'))
    {   
        document.getElementById('durationValidation').innerHTML = "Durée invalide";
        return false;
    }
    else
    {
        document.getElementById('durationValidation').innerHTML = "";
        return true;
    }
} //OK

function validateRessourceDescription(){
    if(!validateNotEmpty('ressourceDescription')){
        return false;
    }
    else if(!validateNotMoreThan('ressourceDescription', 280)) {
        return false;
    }
    else
    {
        document.getElementById('rsDescriptionValidation').innerHTML = "";
        return true;
    }
} //OK

function validateImage() {
    let input = document.getElementById("ImageUploader");
    return updateValidation(document.getElementById("UploadedImageContainer"), input.files[0] !== undefined);
}

function RegEx(regex, value) {
    return regex.test(value);
}

/*
* /^[a-z]([a-z\-]|\s)*$/i
* /^[A-Za-z]+([^0-9]*)$/
* */