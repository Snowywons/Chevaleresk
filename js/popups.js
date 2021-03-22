UpdateAllPopups()

function UpdateAllPopups() {

//Les Conteneurs des détails des items (popups)
    let itemDetailsContainers = document.querySelectorAll(".itemDetailsContainer");
    let itemDeleteConfirmationContainers = document.querySelectorAll(".itemDeleteConfirmationContainer");

//Conteneur/Bouton (frame) pour ouvrir un popup
    let itemPreviewContainers = document.querySelectorAll(".itemPreviewContainer");
    itemPreviewContainers.forEach((item) => {
        item.addEventListener("click", () => {
            openContainer(item, "details", itemDetailsContainers);
        })
    });

//Bouton pour ouvrir une confirmation (popup)
    let deleteButtons = document.querySelectorAll(".deleteButton");
    deleteButtons.forEach((item) => {
        item.addEventListener("click", () => {
            openContainer(item, "delete", itemDeleteConfirmationContainers);
        })
    });

//Écran noir transparent derrière le popup
    let overlay = document.querySelector("#overlay");
    overlay.addEventListener("click", () => closeContainers());

//Bouton Sortie du popup (conteneur)
    let itemDetailsContainerExitButtons = document.querySelectorAll(".itemDetailsContainerExitButton");
    itemDetailsContainerExitButtons.forEach((item) => {
        item.addEventListener("click", () => {
            closeContainers();
        })
    });


    const openContainer = (from, groupName, linkContainers)=> {
        let array = Array.prototype.slice.call(linkContainers);
        let troncId = from.id.split('_')[0];
        let formatId = troncId + "_" + groupName;
        let itemDetailsContainer = array.find(element => element.id === formatId);
        if (itemDetailsContainer) {
            itemDetailsContainer.classList.add("active");
            overlay.classList.add("active");
        }
    }

    const closeContainers = ()=> {
        itemDetailsContainers.forEach((item) => {
            item.classList.remove("active");
        })
        itemDeleteConfirmationContainers.forEach((item) => {
            item.classList.remove("active");
        })

        overlay.classList.remove("active");
    }
}