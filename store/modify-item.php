<?php
$root = "../";

include_once $root . "master/header.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "db/itemsDT.php";
include_once $root . "db/weaponsDT.php";
include_once $root . "db/ressourcesDT.php";
include_once $root . "db/armorsDT.php";
include_once $root . "db/potionsDT.php";

//Accès interdit
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] == false) {
    header("location: ../store/store.php");
    exit;
}

$idItem = isset($_GET["idItem"]) ? $_GET["idItem"] : -1;

$record = GetItemById($idItem);

$nomItem = "";
$quantiteStock = "";
$prixItem = "";
$codePhoto = "";
$codeType = "";
$previousCodeType = "";
$previousName = "";
if (!empty($record)) {
    $nomItem = $record[1];
    $previousName = $nomItem;
    $quantiteStock = $record[2];
    $prixItem = $record[3];
    $codePhoto = $record[4];
    $codeType = $record[5];
    $previousCodeType = $codeType;
}

$efficacite = "";
$genre = "";
$description = "";
if ($codeType === "AE") {
    $weapon = GetWeaponById($idItem);
    if ($weapon) {
        $efficacite = $weapon[1];
        $genre = $weapon[2];
        $description = $weapon[3];
    }
}

$matiere = "";
$poids = "";
$taille = "";
if ($codeType === "AM") {
    $armor = GetArmorById($idItem);
    if ($armor) {
        $matiere = $armor[1];
        $poids = $armor[2];
        $taille = $armor[3];
    }
}

$effet = "";
$duree = "";
if ($codeType === "PO") {
    $potion = GetPotionById($idItem);
    if ($potion) {
        $effet = $potion[1];
        $duree = $potion[2];
    }
}

$ressourceDescription = "";
if ($codeType === "RS") {
    $ressource = GetRessourceById($idItem);
    if ($ressource)
        $ressourceDescription = $ressource[1];
}

//Afficher le form
echo "<main class='modify-item'>
<span data-shadow=\"" . "Modifier&nbsp;un&nbsp;item" . "\" class='pageTitle'
        style='left: 50%;transform: translateX(-53%)'>Modifier&nbsp;un&nbsp;item</span><br><br>

<form>
    <fieldset>
        <input type='hidden' id='idItem' name='idItem' value='$idItem'>
        <input type='hidden' id='previousCodeType' name='previousCodeType' value='$previousCodeType'>
        <input type='hidden' id='previousName' name='previousName' value='" . htmlspecialchars($previousName, ENT_QUOTES) . "'>
        <!-- Nom -->
        <label for='name'>Nom
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <input type='text' id='name' name='name' value='" . htmlspecialchars($nomItem, ENT_QUOTES) . "' onblur='validateNameItem()'>
        <div id='nameValidation' style='color:red'></div>

        <!-- Type -->
        <label for='types'>Type
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <select name='types' id='types' onchange='ChangeTypeField()' onblur='validateNotEmpty(\"types\")'>
            <option selected disabled hidden value=''>-Choisir un type-</option>
            <option value='AE' " . (($codeType == "AE") ? 'selected="selected"' : "") . ">Arme</option>
            <option value='AM' " . (($codeType == "AM") ? 'selected="selected"' : "") . ">Armure</option>
            <option value='PO' " . (($codeType == "PO") ? 'selected="selected"' : "") . ">Potion</option>
            <option value='RS' " . (($codeType == "RS") ? 'selected="selected"' : "") . ">Ressource</option>
        </select>
        <div id='typesValidation' style='color:red'></div>
        
        <!-- Arme -->
        <div id='AE_Informations' class='addItemInfosContainer " . (($codeType !== "AE") ? 'hidden' : "") . "'>
            <label for='efficiency'>Efficacité
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <input type='number' id='efficiency' name='efficiency' value='$efficacite' onblur='validateEfficiency()'>
            <div id='efficiencyValidation' style='color:red'></div>

            <label for='genders'>Genre
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <select name='genders' id='genders' onblur='validateNotEmpty(\"genders\")'>
                <option selected disabled hidden value=''>-Choisir un genre-</option>
                <option value='Une main' " . (($genre == "Une main") ? 'selected="selected"' : "") . ">Une main</option>
                <option value='Deux mains' " . (($genre == "Deux mains") ? 'selected="selected"' : "") . ">Deux mains</option>
            </select>

            <label for='weaponDescription'>Description (max 280 caractères)
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <textarea id='weaponDescription' name='weaponDescription' onblur='validateWeaponDescription()'>$description</textarea>
            <div id='descriptionValidation' style='color:red'></div>
        </div>

        <!-- Armure -->
        <div id='AM_Informations' class='addItemInfosContainer " . (($codeType !== "AM") ? 'hidden' : "") . "'>
            <label for='materials'>Matière
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <select name='materials' id='materials' onblur='validateNotEmpty(\"materials\")'>
                <option selected disabled hidden value=''>-Choisir une matière-</option>
                <option value='Cuir' " . (($matiere == "Cuir") ? 'selected="selected"' : "") . ">Cuir</option>
                <option value='Métal' " . (($matiere == "Métal") ? 'selected="selected"' : "") . ">Métal</option>
            </select>
            <div id='materialValidation' style='color:red'></div>

            <label for='weight'>Poids
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <input type='number' id='weight' name='weight' value='$poids' onblur='validateWeight()'>
            <div id='weightValidation' style='color:red'></div>

            <label for='sizes'>Taille
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <select name='sizes' id='sizes' onblur='validateNotEmpty(\"sizes\")'>
                <option selected disabled hidden value=''>-Choisir une taille-</option>
                <option value='xs' " . (($taille == "xs") ? 'selected="selected"' : "") . ">XS</option>
                <option value='s' " . (($taille == "s") ? 'selected="selected"' : "") . ">S</option>
                <option value='m' " . (($taille == "m") ? 'selected="selected"' : "") . ">M</option>
                <option value='l' " . (($taille == "l") ? 'selected="selected"' : "") . ">L</option>
                <option value='xl' " . (($taille == "xl") ? 'selected="selected"' : "") . ">XL</option>
            </select>
            <div id='sizeValidation' style='color:red'></div>
        </div>

        <!-- Potion -->
        <div id='PO_Informations' class='addItemInfosContainer " . (($codeType !== "PO") ? 'hidden' : "") . "'>
            <label for='effect'>Effet (max 280 caractères)
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <textarea id='effect' name='effect' onblur='validateEffect()'>$effet</textarea>
            <div id='effectValidation' style='color:red'></div>

            <label for='duration'>Durée (secondes)
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <input type='number' id='duration' name='duration' value='$duree' onblur='validateDuration()'>
            <div id='durationValidation' style='color:red'></div>
        </div>

        <!-- Ressource -->
        <div id='RS_Informations' class='addItemInfosContainer " . (($codeType !== "RS") ? 'hidden' : "") . "'>
            <label for='ressourceDescription'>Description (max 280 caractères)
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <textarea id='ressourceDescription' name='ressourceDescription' onblur='validateRessourceDescription()'>$ressourceDescription</textarea>
            <div id='rsDescriptionValidation' style='color:red'></div>
        </div>

        <!-- Quantité -->
        <label for='quantity'>Quantité
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <input type='number' id='quantity' name='quantity' value='$quantiteStock' onblur='validateQuantity()'>
        <div id='quantityValidation' style='color:red'></div>
        
        <!-- Prix -->
        <label for='price'>Prix unitaire (écus)
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <input type='number' id='price' name='price' value='$prixItem' onblur='validatePrice()'>
        <div id='priceValidation' style='color:red'></div>
        
        <!-- Image -->
        <label for='picture'>Image
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <div id='UploadedImageContainer' class='addItemPreviewContainer'>
            <img src='" . $root . "icons/" . $codePhoto . "' id='UploadedImage' onclick='OpenImageUploader()'>
        </div>
        <div id='imageValidation' style='color:red'></div>
        <input hidden type='file' accept='.jpg,.jpeg,.png' id='ImageUploader' name='picture' value='$codePhoto'
                onchange='ChangeImagePreview()'>
        <input type='hidden' id='codePhoto' value='$codePhoto'>
        
        <!-- Modifier -->
        <div style='grid-column-start: 1; grid-column-end: 3; text-align: right; margin-top: 10px'>
            <button class='addToStore' onclick='UpdateItem()'>Modifier</button>
        </div>
</fieldset>
</form>
</main>";

include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/update-item.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/add-item.js' defer></script>";