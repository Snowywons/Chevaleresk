let itemDetailsContainers = document.querySelectorAll(".itemDetailsContainer");
let itemPreviewContainers = document.querySelectorAll(".itemPreviewContainer");
let itemDetailsContainerExitButtons = document.querySelectorAll(".itemDetailsContainerExitButton");
let overlay = document.querySelector("#overlay");

itemPreviewContainers.forEach((item)=> {
    item.addEventListener("click", ()=> {
        openContainer(item);
    })
});

overlay.addEventListener("click", () => closeContainers());

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