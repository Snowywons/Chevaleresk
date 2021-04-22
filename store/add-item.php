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
        <select name='types' id='types' onchange='ChangeTypeField()' onblur='validateNotEmpty(\"types\")'>
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
            <input type='number' id='efficiency' name='efficiency' placeholder='0' onblur='validateEfficiency()'>
            <div id='efficiencyValidation' style='color:red'></div>

            <label for='genres'>Genre
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <select name='genders' id='genders' onblur='validateNotEmpty(\"genders\")'>
                <option selected disabled hidden value=''>-Choisir un genre-</option>
                <option value='Une main'>Une main</option>
                <option value='Deux mains'>Deux mains</option>
            </select>
            <div id='sortValidation' style='color:red'></div>

            <label for='weaponDescription'>Description (max 280 caractères)
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <textarea id='weaponDescription' name='weaponDescription' onblur='validateWeaponDescription()'></textarea>
            <div id='descriptionValidation' style='color:red'></div>
        </div>

        <!-- Armure -->
        <div id='AM_Informations' class='addItemInfosContainer hidden'>
            <label for='materials'>Matière
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <select name='materials' id='materials' onblur='validateNotEmpty(\"materials\")'>
                <option selected disabled hidden value=''>-Choisir une matière-</option>
                <option value='Cuir'>Cuir</option>
                <option value='Métal'>Métal</option>
            </select>
            <div id='materialValidation' style='color:red'></div>

            <label for='weight'>Poids
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <input type='number' id='weight' name='weight' placeholder='0' onblur='validateWeight()'>
            <div id='weightValidation' style='color:red'></div>

            <label for='size'>Taille
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <select name='sizes' id='sizes' onblur='validateNotEmpty(\"sizes\")'>
                <option selected disabled hidden value=''>-Choisir une taille-</option>
                <option value='xs'>XS</option>
                <option value='s'>S</option>
                <option value='m'>M</option>
                <option value='l'>L</option>
                <option value='xl'>XL</option>
            </select>
            <div id='sizeValidation' style='color:red'></div>
        </div>

        <!-- Potion -->
        <div id='PO_Informations' class='addItemInfosContainer hidden'>
            <label for='effect'>Effet (max 280 caractères)
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <textarea id='effect' name='effect' onblur='validateEffect()'></textarea>
            <div id='effectValidation' style='color:red'></div>

            <label for='duration'>Durée (secondes)
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <input type='number' id='duration' name='duration' placeholder='0' onblur='validateDuration()'>
            <div id='durationValidation' style='color:red'></div>
        </div>

        <!-- Ressource -->
        <div id='RS_Informations' class='addItemInfosContainer hidden'>
            <label for='ressourceDescription'>Description (max 280 caractères)
                <abbr title='Obligatoire' style='color:red'>*</abbr>
            </label>
            <textarea id='ressourceDescription' name='ressourceDescription' onblur='validateRessourceDescription()'></textarea>
            <div id='rsDescriptionValidation' style='color:red'></div>
        </div>

        <!-- Quantité -->
        <label for='quantity'>Quantité
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <input type='number' id='quantity' name='quantity' placeholder='0' onblur='validateQuantity()'>
        <div id='quantityValidation' style='color:red'></div>
        
        <!-- Prix -->
        <label for='price'>Prix unitaire (écus)
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <input type='number' id='price' name='price' placeholder='0' onblur='validatePrice()'>
        <div id='priceValidation' style='color:red'></div>
        
        <!-- Image -->
        <label for='picture'>Image
            <abbr title='Obligatoire' style='color:red'>*</abbr>
        </label>
        <div id='UploadedImageContainer' class='addItemPreviewContainer'>
            <img src='" . $root . "icons/DefaultIcon.png' id='UploadedImage' onclick='OpenImageUploader()'>
        </div>
        <div id='imageValidation' style='color:red'></div>
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
    