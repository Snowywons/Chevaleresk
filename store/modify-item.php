<?php
$root = "../";

include_once $root."master/header.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "db/shopping-cartsDT.php";
include_once $root . "db/itemsDT.php";
include_once $root . "db/weaponsDT.php";
include_once $root . "db/ressourcesDT.php";
include_once $root . "db/armorsDT.php";
include_once $root . "db/potionsDT.php";

if (isset($_POST["modifier"])) {
    include_once $root . "server/httpRequestHandler.php";
    //echo "modifier = ".$_POST["modifier"];
}
//Chercher les informations
$targetItem = isset($_GET["idItem"]) ? $_GET["idItem"] : -1;
$alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
$targetAlias = isset($_GET["alias"]) ? $_GET["alias"] : $alias;

$record = GetItemById($targetItem);
$weapon = GetWeaponById($targetItem);
$armor = GetArmorById($targetItem);
$ressource = GetRessourceById($targetItem);
$potion = GetPotionById($targetItem);

$idItem = ""; $nomItem = ""; $quantiteStock = ""; $prixItem = ""; $codePhoto = ""; $codeType = "";
if(!empty($record))
{
    $idItem = $record[0];
    $nomItem = $record[1];
    $quantiteStock = $record[2];
    $prixItem = $record[3];
    $codePhoto = $record[4].".png";//"../icons/$record[4].png"
    $codeType = $record[5];
}
$efficacite=""; $genre=""; $description="";
if(!empty($weapon))
{
    $efficacite=$weapon[1];
    $genre=$weapon[2];
    $description=$weapon[3];
}
$matiere=""; $poids=""; $taille="";
if(!empty($armor))
{
    $matiere=$armor[1];
    $poids=$armor[2];
    $taille=$armor[3];
}
$effet=""; $duree="";
if(!empty($potion))
{
    $effet=$potion[1];
    $duree=$potion[2];
}
$ressourceDescription="";
if(!empty($ressource))
{
    $ressourceDescription=$ressource[1];
}

//Afficher le form
echo "<main class='modify-item'>
<h1>Modifier un item</h1>

<form action='' id='updateForm' name='updateForm' method='post'>
    <fieldset>
        <input type='hidden' id='idItem' name='idItem' value='".$idItem."'>
        <label for='nom'>Nom
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <input type='text' id='nom' name='nom' value='".htmlspecialchars($nomItem, ENT_QUOTES)."'>
        
        <label for='types'>Type
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <select name='types' id='types'>
            <option selected disabled hidden>-Choisir un type-</option>
            <option value='AE' ".(($codeType=="AE")? 'selected="selected"':"").">Arme</option>
            <option value='AM' ".(($codeType=="AM")? 'selected="selected"':"").">Armure</option>
            <option value='PO' ".(($codeType=="PO")? 'selected="selected"':"").">Potion</option>
            <option value='RS' ".(($codeType=="RS")? 'selected="selected"':"").">Ressource</option>
        </select>

        <!-- Arme -->
        <div id='armeInfos' class='addItemInfosContainer hidden'>
            <label for='efficacite'>Efficacité
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <input type='number' id='efficacite' name='efficacite' value='".$efficacite."'>

            <label for='genres'>Genre
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <select name='genres' id='genres'>
                <option selected disabled hidden>-Choisir un genre-</option>
                <option value='Une main' ".(($genre=="Une main")? 'selected="selected"':"").">Une main</option>
                <option value='Deux mains' ".(($genre=="Deux mains")? 'selected="selected"':"").">Deux mains</option>
            </select>
            <label for='description'>Description (max 280 caractères)
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <textarea id='description' name='description'>".$description."</textarea>
        </div>
        
        <!-- Armure -->
        <div id='armureInfos' class='addItemInfosContainer hidden'>
            <label for='matieres'>Matière
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <select name='matieres' id='matieres'>
                <option selected disabled hidden>-Choisir une matière-</option>
                <option value='cuire' ".(($matiere=="Cuire")? 'selected="selected"':"").">Cuire</option>
                <option value='metal' ".(($matiere=="Métal")? 'selected="selected"':"").">Métal</option>
            </select>
            <label for='poids'>Poids <abbr title='Obligatoire' style='color:red'>*</abbr> </label>
            <input type='number' id='poids' name='poids' value='".$poids."'>
            <label for='taille'>Taille <abbr title='Obligatoire' style='color:red'>*</abbr> </label>
            <input type='number' id='taille' name='taille' value='".$poids."'>
        </div>
        
        <!-- Potion -->
        <div id='potionInfos' class='addItemInfosContainer hidden'>
            <label for='effet'>Effet <abbr title='Obligatoire' style='color:red'>*</abbr> </label>
            <textarea id='effet' name='effet'>".$effet."</textarea>
            <label for='duree'>Durée (secondes) <abbr title='Obligatoire' style='color:red'>*</abbr> </label>
            <input type='number' id='duree' name='duree' value='".$duree."'>
        </div>
        
        <!-- Ressource -->
        <div id='RS_Informations' class='addItemInfosContainer hidden'>
            <label for='ressourceDescription'>Description (max 280 caractères)
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <textarea id='ressourceDescription' name='ressourceDescription' >".$ressourceDescription."</textarea>
            <div id='rsDescriptionValidation' style='color:red'></div>
        </div>

        <label for='quantite'>Quantité <abbr title='Obligatoire' style='color:red'>*</abbr> </label>
        <input type='number' id='quantite' name='quantite' value='".$quantiteStock."'>
                
        <label for='price'>Prix unitaire (écus)
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <input type='number' id='price' name='price' value='".$prixItem."'>
        
        <label for='picture'>Image
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>

        <div class='addItemPreviewContainer'>
            <img src='" . $root . "icons/".$codePhoto."'>
        </div>
        <input type='file' id='picture' name='picture' value=''>
        <input type='hidden' id='submit' name='submit' value='updateItem'>
        <input type='submit' value='Modifier' id='modifier' name='modifier' class='saveChanges'>

    </fieldset>
</form>
</main>";

include_once $root."master/footer.php";

//TEMPORAIRE
echo "
    <script type='text/javascript' src='".$root."js/shoppingcart.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/store.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/update-item.js' defer></script>";

//TEMPORAIRE
echo "<script>";
echo <<<JS
// let input = document.querySelectorAll("input[type='range']")[0];
// let vInput = document.getElementById("vprice");
//
// input.addEventListener("input", ()=> {
//     vInput.value = input.value;
// })

/*let select = document.getElementById("types");

select.addEventListener("change", ()=> {
    let elems = document.querySelectorAll(".addItemInfosContainer");
    elems.forEach((item)=> {
        if (!item.classList.contains("hidden"))
            item.classList.add("hidden");
    });
    
    let id = select.value + "Infos";
    let elem = document.getElementById(id);
    elem.classList.remove("hidden");
})*/
JS;
echo "</script>";