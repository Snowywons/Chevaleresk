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
        case "AR" : //Arme
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
