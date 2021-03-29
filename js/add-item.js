AddClickEventFor("saveChanges", (item) => {
    let name = document.getElementById("name");                                 //input
    let types = document.getElementById("types");                               //select

    let quantity = document.getElementById("quantity");                         //input
    let price = document.getElementById("price");                               //input

    let request = "submit=addItemDataBase";

    if (name.value !== "") request += "&name=" + name.value;
    else {
        NotifyWithPopup("Le nom est invalide.");
        return;
    }

    if (types.value !== "") request += "&type=" + types.value;
    else {
        NotifyWithPopup("Le type est invalide.");
        return;
    }

    if (quantity.value >= 0) request += "&quantity=" + quantity.value;
    else {
        NotifyWithPopup("La quantité est invalide.");
        return;
    }

    if (price.value >= 0) request += "&price=" + price.value;
    else {
        NotifyWithPopup("Le prix est invalide.");
        return;
    }

    switch (types.value) {
        case "AR" :
            let efficiency = document.getElementById("efficiency");                     //input
            let genders = document.getElementById("genders");                           //select
            let weaponDescription = document.getElementById("weaponDescription");       //textarea

            if (efficiency.value >= 0) request += "&efficiency=" + efficiency.value; else {
                NotifyWithPopup("L'efficacité est invalide.");
                return;
            }

            if (genders.value !== "") request += "&gender=" + genders.value; else {
                NotifyWithPopup("Le genre est invalide.");
                return;
            }

            if (weaponDescription.value !== "") request += "&description=" + weaponDescription.value; else {
                NotifyWithPopup("La description est invalide.");
                return;
            }
            break;
        case "AM" :
            let materials = document.getElementById("materials");                       //select
            let weigth = document.getElementById("weigth");                             //input
            let size = document.getElementById("size");                                 //input

            if (materials.value !== "") request += "&material=" + materials.value; else {
                NotifyWithPopup("La matière est invalide.");
                return;
            }

            if (weigth.value >= 0) request += "&weigth=" + weigth.value; else {
                NotifyWithPopup("Le poids est invalide.");
                return;
            }

            if (size.value >= 0) request += "&size=" + size.value; else {
                NotifyWithPopup("La grandeur est invalide.");
                return;
            }
            break;
        case "PO" :
            let effect = document.getElementById("effect");                             //textarea
            let duration = document.getElementById("duration");                         //input

            if (effect.value !== "") request += "&effect=" + effect.value; else {
                NotifyWithPopup("L'effet est invalide.");
                return;
            }

            if (duration.value >= 0) request += "&duration=" + duration.value; else {
                NotifyWithPopup("La durée est invalide.");
                return;
            }
            break;
        case "RS" :
            let ressourceDescription = document.getElementById("ressourceDescription"); //textarea

            if (ressourceDescription.value !== "") request += "&description=" + ressourceDescription.value; else {
                NotifyWithPopup("La description est invalide.");
                return;
            }
            break;
    }

    ServerRequest("POST", "../server/httpRequestHandler.php", request, (requete) => {
        NotifyWithPopup(requete.responseText);
    }, () => {
    });
});

let select = document.getElementById("types");

select.addEventListener("change", () => {
    let elems = document.querySelectorAll(".addItemInfosContainer");
    elems.forEach((item) => {
        if (!item.classList.contains("hidden"))
            item.classList.add("hidden");
    });

    let id = select.value + "_Informations";
    let elem = document.getElementById(id);
    elem.classList.remove("hidden");
});