<?php
$root = "../";

include_once $root . "master/header.php";
include_once $root . "utilities/sessionUtilities.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "utilities/popupUtilities.php";
include_once $root . "db/itemsDT.php";

//Accès interdit
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] == false) {
    header("location: ../store/store.php");
    exit;
}

/*$name = "";*/
/*$types = "";
$quantity = "";
$price = "";
$nameError = "";

if (isset($_POST["submit"])) {
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $types = isset($_POST["types"]) ? $_POST["types"] : "";
    $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";
    $price = isset($_POST["price"]) ? $_POST["price"] : "";
    $image = isset($_POST["image"]) ? $_POST["price"] : "";
    if($types == 'AE')
    {
      $efficiency = isset($_POST["efficiency"]) ? $_POST["efficiency"] : "";
      $genders = isset($_POST["genders"]) ? $_POST["genders"] : "";
      $weaponDescription = isset($_POST["weaponDescription"]) ? $_POST["weaponDescription"] : "";
    }
}*/

//Ajout d'un item
echo "
<main class='add-item'>
<h1>Ajouter un item</h1>

<form method='POST' name ='myItem' onsubmit='return validateAddItemForm()'>
    <fieldset>
        <!-- Nom -->
        <label for='name'>Nom
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <input type='text' id='name' name='name' value='' onblur='validateNameItem()'>
        <div id='nameValidation' style='color:red'></div>

        <!-- Type -->
        <label for='types'>Type
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <select name='types' id='types' onchange='ChangeTypeField()' required pattern='AE|AM|PO|RS'>
            <option selected disabled hidden value=''>-Choisir un type-</option>
            <option value='AE'>Arme</option>
            <option value='AM'>Armure</option>
            <option value='PO'>Potion</option>
            <option value='RS'>Ressource</option>
        </select>
        <div id='typesValidation' style='color:red'></div>
        
        <!-- Arme -->
        <div id='AE_Informations' class='addItemInfosContainer hidden'>
            <label for='efficiency'>Efficacité
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <input type='number' id='efficiency' name='efficiency' value='0' onblur='validateEfficiency()'>
            <div id='efficiencyValidation' style='color:red'></div>

            <label for='genres'>Genre
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <select name='genders' id='genders' required pattern='one-handed|two-handed'>
                <option selected disabled hidden value=''>-Choisir un genre-</option>
                <option value='one-handed'>Une main</option>
                <option value='two-handed'>Deux mains</option>
            </select>
            <div id='sortValidation' style='color:red'></div>

            <label for='weaponDescription'>Description
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <textarea id='weaponDescription' name='weaponDescription' onblur='validateDescription()'></textarea>
            <div id='descriptionValidation' style='color:red'></div>
        </div>

        <!-- Armure -->
        <div id='AM_Informations' class='addItemInfosContainer hidden'>
            <label for='materials'>Matière
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <select name='materials' id='materials' <!--required pattern='leather|metal'-->>
                <option selected disabled hidden value=''>-Choisir une matière-</option>
                <option value='leather'>Cuir</option>
                <option value='metal'>Métal</option>
            </select>
            <div id='materialValidation' style='color:red'></div>

            <label for='weight'>Poids
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <input type='number' id='weight' name='weight' value='0' onblur='validateWeight()'>
            <div id='weightValidation' style='color:red'></div>

            <label for='size'>Taille
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <input type='number' id='size' name='size' value='0' onblur='validateSize()'>
            <div id='sizeValidation' style='color:red'></div>
        </div>

        <!-- Potion -->
        <div id='PO_Informations' class='addItemInfosContainer hidden'>
            <label for='effect'>Effet
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <textarea id='effect' name='effect' onblur='validateEffect()'></textarea>
            <div id='effectValidation' style='color:red'></div>

            <label for='duration'>Durée (secondes)
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <input type='number' id='duration' name='duration' value='0' onblur='validateDuration()'>
            <div id='durationValidation' style='color:red'></div>
        </div>

        <!-- Ressource -->
        <div id='RS_Informations' class='addItemInfosContainer hidden'>
            <label for='ressourceDescription'>Description
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <textarea id='ressourceDescription' name='ressourceDescription' onblur='validateRsDescription()'></textarea>
            <div id='rsDescriptionValidation' style='color:red'></div>
        </div>

        <!-- Quantité -->
        <label for='quantity'>Quantité
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <input type='number' id='quantity' name='quantity' value='0' onblur='validateQuantity()'>
        <div id='quantityValidation' style='color:red'></div>
        
        <!-- Prix -->
        <label for='price'>Prix unitaire (écus)
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <input type='number' id='price' name='price' value='0' onblur='validatePrice()'>
        <div id='priceValidation' style='color:red'></div>
        
        <!-- Image -->
        <label for='picture'>Image</label>
        <div class='addItemPreviewContainer'>
            <img src='" . $root . "icons/DefaultIcon.png' id='UploadedImage' onclick='OpenImageUploader()'>
        </div>
        <input type='file' accept='.jpg,.jpeg,.png' id='ImageUploader' name='picture' value='' 
                onchange='ChangeImagePreview()'>
        
        <!-- Ajouter -->
        <input type='submit' class='saveChanges' value='Ajouter' onclick='AddItem()' >
</fieldset>
</form>
</main>";
//---------------------------------------------------------------------------------------------------------------------
include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/add-item.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/functions.js' defer></script>";
    