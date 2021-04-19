<?php
$root = "../";

include_once $root."master/header.php";

$idItem = "0"; //Doit obtenir le dernier id des items de la bd + 1

$nom = "NAN";
$quantite = "999";
$prix = "0";

echo <<<HTML
<main class="modify-item">
    <h1>Modifier un item</h1>
    
    <form action="">
        <fieldset>
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="$nom">
            
            <label for="types">Type</label>
            <select name="types" id="types">
                <option selected disabled hidden>-Choisir un type-</option>
                <option value="arme">Arme</option>
                <option value="armure">Armure</option>
                <option value="potion">Potion</option>
            </select>
            
            <!-- Arme -->
            <div id='armeInfos' class="addItemInfosContainer hidden">
                <label for='efficacite'>Efficacité</label>
                <input type="number" id="efficacite" name="efficacite" value="0">
                <label for='genres'>Genre</label>
                <select name="genres" id="genres">
                    <option selected disabled hidden>-Choisir un genre-</option>
                    <option value="1main">Une main</option>
                    <option value="2mains">Deux mains</option>
                </select>
                <label for='description'>Description</label>
                <textarea id="description" name="description"></textarea>
            </div>
            
            <!-- Armure -->
            <div id='armureInfos' class="addItemInfosContainer hidden">
                <label for='matieres'>Matière</label>
                <select name="matieres" id="matieres">
                    <option selected disabled hidden>-Choisir une matière-</option>
                    <option value="cuire">Cuire</option>
                    <option value="metal">Métal</option>
                </select>
                <label for="poids">Poids</label>
                <input type="number" id="poids" name="poids" value="0">
                <label for="taille">Taille</label>
                <input type="number" id="taille" name="taille" value="0">
            </div>
            
            <!-- Potion -->
            <div id='potionInfos' class="addItemInfosContainer hidden">
                <label for="effet">Effet</label>
                <textarea id="effet" name="effet"></textarea>
                <label for="duree">Durée (secondes)</label>
                <input type="number" id="duree" name="duree" value="0">
            </div>
            
            <label for="quantite">Quantité</label>
            <input type="number" id="quantite" name="quantite" value="$quantite">
                    
            <label for="price">Prix unitaire (écus)</label>
            <input type="number" id="price" name="price" value="$prix">
            
            <label for="picture">Image</label>
HTML;
echo "
<div class='addItemPreviewContainer'>
    <img src='" . $root . "icons/ChevalereskIcon.png'>
</div>";
echo <<<HTML
            <input type="file" id="picture" name="picture" value="">
            <input type="submit" value="Ajouter">
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
// let input = document.querySelectorAll("input[type='range']")[0];
// let vInput = document.getElementById("vprice");
//
// input.addEventListener("input", ()=> {
//     vInput.value = input.value;
// })

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