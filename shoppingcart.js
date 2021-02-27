let removeItemButtons = document.querySelectorAll(".removeItem");
let addItemButtons = document.querySelectorAll(".addItem");
let itemQuantityInputs = document.querySelectorAll(".itemQuantity");
let modifyShoppingCartButtons = document.querySelectorAll(".modifyShoppingCart");

modifyShoppingCartButtons.forEach((item)=> {
    item.addEventListener("click", ()=> {
        if (item.classList.contains("clicked"))
        {
            hiddeButton(item);
            let itemQuantityInput = getItemQuantityInput(item);
            if (itemQuantityInput) {
                let count = parseInt(itemQuantityInput.value);
                if (!count || count < 0) count = 0;
                itemQuantityInput.value = count;
            }
        }
        else
        {
            showButton(item);
        }
    })
});

removeItemButtons.forEach((item)=> {
    item.addEventListener("click", ()=> {
        removeItem(item);
    })
});

addItemButtons.forEach((item)=> {
    item.addEventListener("click", ()=> {
        addItem(item);
    })
});

function showButton(from)
{
    let array = Array.prototype.slice.call(removeItemButtons);
    let troncId = from.id.split('_')[0];
    let formatId = troncId + "_removeItem";
    let removeItemButton = array.find(element => element.id === formatId);
    if (removeItemButton) {
        removeItemButton.classList.remove("hidden");
    }

    array = Array.prototype.slice.call(addItemButtons);
    troncId = from.id.split('_')[0];
    formatId = troncId + "_addItem";
    let addItemButton = array.find(element => element.id === formatId);
    if (addItemButton) {
        addItemButton.classList.remove("hidden");
    }

    array = Array.prototype.slice.call(itemQuantityInputs);
    troncId = from.id.split('_')[0];
    formatId = troncId + "_itemQuantity";
    let itemQuantity = array.find(element => element.id === formatId);
    if (itemQuantity) {
        itemQuantity.disabled = false;
    }

    from.classList.add("clicked");
    from.innerHTML = "Confirmer";
}

function hiddeButton(from)
{
    let array = Array.prototype.slice.call(removeItemButtons);
    let troncId = from.id.split('_')[0];
    let formatId = troncId + "_removeItem";
    let removeItemButton = array.find(element => element.id === formatId);
    if (removeItemButton) {
        removeItemButton.classList.add("hidden");
    }

    array = Array.prototype.slice.call(addItemButtons);
    troncId = from.id.split('_')[0];
    formatId = troncId + "_addItem";
    let addItemButton = array.find(element => element.id === formatId);
    if (addItemButton) {
        addItemButton.classList.add("hidden");
    }

    array = Array.prototype.slice.call(itemQuantityInputs);
    troncId = from.id.split('_')[0];
    formatId = troncId + "_itemQuantity";
    let itemQuantity = array.find(element => element.id === formatId);
    if (itemQuantity) {
        itemQuantity.disabled = true;
    }

    from.classList.remove("clicked");
    from.innerHTML = "Modifier";
}

function addItem(from)
{
    let itemQuantityInput = getItemQuantityInput(from);
    if (itemQuantityInput) {
        let count = parseInt(itemQuantityInput.value);
        if (!count) count = 0;
        itemQuantityInput.value = count === 0 ? 1 : ++count;
    }
}

function removeItem(from)
{
    let itemQuantityInput = getItemQuantityInput(from);
    if (itemQuantityInput) {
        let count = parseInt(itemQuantityInput.value);
        if (itemQuantityInput.value > 0)
            itemQuantityInput.value = --count;
    }
}

function getItemQuantityInput(from)
{
    let array = Array.prototype.slice.call(itemQuantityInputs);
    let troncId = from.id.split('_')[0];
    let formatId = troncId + "_itemQuantity";
    let itemQuantityInput = array.find(element => element.id === formatId);
    if (itemQuantityInput)
        return itemQuantityInput;
    return null;
}