//Les Conteneurs des détails des items (popups)
let itemDetailsContainers = document.querySelectorAll(".itemDetailsContainer");

//Conteneur/Bouton (frame) pour ouvrir un popup
let itemPreviewContainers = document.querySelectorAll(".itemPreviewContainer");
itemPreviewContainers.forEach((item)=> {
    item.addEventListener("click", ()=> {
        openContainer(item);
    })
});

//Écran noir transparent derrière le popup
let overlay = document.querySelector("#overlay");
overlay.addEventListener("click", () => closeContainers());

//Bouton Sortie du popup (conteneur)
let itemDetailsContainerExitButtons = document.querySelectorAll(".itemDetailsContainerExitButton");
itemDetailsContainerExitButtons.forEach((item)=> {
    item.addEventListener("click", ()=> {
        closeContainers();
    })
});

function openContainer(from)
{
    let array = Array.prototype.slice.call(itemDetailsContainers);
    let troncId = from.id.split('_')[0];
    let formatId = troncId + "_details";
    let itemDetailsContainer = array.find(element => element.id === formatId);
    if (itemDetailsContainer) {
        itemDetailsContainer.classList.add("active");
        overlay.classList.add("active");
    }
}

function closeContainers()
{
    itemDetailsContainers.forEach((item) => {
        item.classList.remove("active");
    })

    overlay.classList.remove("active");
}