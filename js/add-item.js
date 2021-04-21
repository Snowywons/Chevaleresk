function AddItem() {
    let name = document.getElementById("name");
    let types = document.getElementById("types");
    let quantity = document.getElementById("quantity");
    let price = document.getElementById("price");
    let efficiency = document.getElementById("efficiency");
    let genders = document.getElementById("genders");
    let weaponDescription = document.getElementById("weaponDescription");
    let materials = document.getElementById("materials");
    let weigth = document.getElementById("weigth");
    let size = document.getElementById("size");
    let effect = document.getElementById("effect");
    let duration = document.getElementById("duration");
    let ressourceDescription = document.getElementById("ressourceDescription");

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
            data.append('weigth', weigth.value);
            data.append('size', size.value);
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
            if (requete.status === 200) {
                // console.log(requete.responseText);
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

function validateNumber(id) {
    const element = document.getElementById(id);
    return updateValidation(element, element.value > 0);
}

function validateName(id) {
    const element = document.getElementById(id);
    return updateValidation(element, /^[a-z]([a-z\-]|\s)*$/i.test(element.value));
}

function validateNameItem() {
    if(!validateNotEmpty('name')){
        document.getElementById('nameValidation').innerHTML = "Veuillez remplir ce champ!";
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
}

function validateQuantity(){
    if(!validateNotEmpty('quantity')){
        document.getElementById('quantityValidation').innerHTML = "Veuillez remplir ce champ!";
        return false;
    }
    else if(!validateNumber('quantity'))
    {   
        document.getElementById('quantityValidation').innerHTML = "Veuillez mettre une qté supérieure à 0!";
        return false;
    }
    else
    {
        document.getElementById('quantityValidation').innerHTML = "";
        return true;
    }
}

function validatePrice(){
    if(!validateNotEmpty('price')){
        document.getElementById('priceValidation').innerHTML = "Veuillez remplir ce champ!";
        return false;
    }
    else if(!validateNumber('price'))
    {   
        document.getElementById('priceValidation').innerHTML = "Veuillez mettre un prix supérieur à 0!";
        return false;
    }
    else
    {
        document.getElementById('priceValidation').innerHTML = "";
        return true;
    }
}

function validateEfficiency(){
    if(!validateNotEmpty('efficiency')){
        document.getElementById('efficiencyValidation').innerHTML = "Veuillez remplir ce champ!";
        return false;
    }
    else if(!validateNumber('efficiency'))
    {   
        document.getElementById('efficiencyValidation').innerHTML = "Veuillez mettre l'efficacité supérieure à 0!";
        return false;
    }
    else
    {
        document.getElementById('efficiencyValidation').innerHTML = "";
        return true;
    }
}

function validateDescription() {
    if(!validateName('weaponDescription')){
        document.getElementById('descriptionValidation').innerHTML = "Format invalide!";
        return false;
    }
    else if(!validateNotEmpty('weaponDescription')){
        document.getElementById('descriptionValidation').innerHTML = "Veuillez remplir ce champ!";
        return false;
    }
    else
    {
        document.getElementById('descriptionValidation').innerHTML = "";
        return true;
    }
}

function validateWeight(){
    if(!validateNotEmpty('weight')){
        document.getElementById('weightValidation').innerHTML = "Veuillez remplir ce champ!";
        return false;
    }
    else if(!validateNumber('weight'))
    {   
        document.getElementById('weightValidation').innerHTML = "Veuillez mettre un poids supérieur à 0!";
        return false;
    }
    else
    {
        document.getElementById('weightValidation').innerHTML = "";
        return true;
    }
}

function validateSize(){
    if(!validateNotEmpty('size')){
        document.getElementById('sizeValidation').innerHTML = "Veuillez remplir ce champ!";
        return false;
    }
    else if(!validateNumber('size'))
    {   
        document.getElementById('sizeValidation').innerHTML = "Veuillez mettre une grandeur supérieure à 0";
        return false;
    }
    else
    {
        document.getElementById('sizeValidation').innerHTML = "";
        return true;
    }
}

function validateEffect(){
    if(!validateName('effect')){
        document.getElementById('effectValidation').innerHTML = "Format invalide!";
        return false;
    }
    else if(!validateNotEmpty('effect')){
        document.getElementById('effectValidation').innerHTML = "Veuillez remplir ce champ!";
        return false;
    }
    else
    {
        document.getElementById('effectValidation').innerHTML = "";
        return true;
    }
}

function validateDuration(){
    if(!validateNotEmpty('duration')){
        document.getElementById('durationValidation').innerHTML = "Veuillez remplir ce champ!";
        return false;
    }
    else if(!validateNumber('duration'))
    {   
        document.getElementById('durationValidation').innerHTML = "Veuillez mettre une durée supérieure à 0!";
        return false;
    }
    else
    {
        document.getElementById('durationValidation').innerHTML = "";
        return true;
    }
}

function validateRsDescription(){
    if(!validateName('ressourceDescription')){
        document.getElementById('rsDescriptionValidation').innerHTML = "Format invalide!";
        return false;
    }
    else if(!validateNotEmpty('ressourceDescription')){
        document.getElementById('rsDescriptionValidation').innerHTML = "Veuillez remplir ce champ!";
        return false;
    }
    else
    {
        document.getElementById('rsDescriptionValidation').innerHTML = "";
        return true;
    }
}

/*function validateAddItemForm() {

    let allValid = true;

    if (!validateName()) allValid = false;
    if(!validateQuantity()) allValid = false;
    if(!validatePrice()) allValid = false;
    if(!validateEfficiency()) allValid = false;
    if(!validateDescription()) allValid = false;
    if(!validateWeight()) allValid = false;
    if(!validateSize()) allValid = false;
    if(!validateEffect()) allValid = false;
    if(!validateDuration()) allValid = false;
    if(!validateRsDescription()) allValid = false;

    return allValid;
}*/

function RegEx(regex, value) {
    return regex.test(value);
}