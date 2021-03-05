<?php
$root = "../";

include_once $root."master/header.php";

$idItem = "0"; //Doit obtenir le dernier id des items de la bd + 1

$nom = "NAN";
$type = "NAN";
$quantite = "999";
$prix = "0";

echo <<<HTML
<!--DEV MESSAGE-->
<h1 style="background-color: deeppink">CETTE PAGE DEVRA ÊTRE ACCESSIBLE SEULEMENT PAR LES ADMINISTRATEURS</h1>
<main class="delete-item">
    <h1>Supprimer un item</h1>
    
    <form action="">
        <fieldset>
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="$nom" disabled>
            
            <label for="type">Type</label>
            <input type="text" id="type" name="type" value="$type" disabled>
            
            <label for="picture">Image</label>
HTML;
echo "
<div class='addItemPreviewContainer'>
    <img src='" . $root . "icons/ChevalereskIcon.png'>
</div>";
echo <<<HTML
            <input type="submit" value="Supprimer">
        </fieldset>
    </form>
</main>
HTML;

include_once $root."master/footer.php";

//TEMPORAIRE
echo "
    <script type='text/javascript' src='".$root."js/shoppingcart.js' defer></script>";

//TEMPORAIRE
echo "<script>";
echo <<<JS
let input = document.querySelectorAll("input[type='range']")[0];
let vInput = document.getElementById("vprice");

input.addEventListener("input", ()=> {
    vInput.value = input.value;
})

let select = document.getElementById("types");

select.addEventListener("change", ()=> {
    let elems = document.querySelectorAll(".addItemInfosContainer");
    elems.forEach((item)=> {
        if (!item.classList.contains("hidden"))
            item.classList.add("hidden");
    });
    
    let id = select.value + "Infos";
    let elem = document.getElementById(id);
    elem.classList.remove("hidden");
})
JS;
echo "</script>";

/*
*              <label for='".$idItem."_itemQuantity'>Quantité</label>
 *             <div class='adjustItemQuantityContainer'>
                <button id='".$idItem."_removeItem' class='removeItem'>-</button>
                <input id='".$idItem."_itemQuantity' class='itemQuantity' type='number' value='1'/>
                <button id='".$idItem."_addItem' class='addItem'>+</button>
                </div>
 *
 *
 * */
?>