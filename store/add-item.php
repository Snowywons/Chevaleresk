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

CreateNotificationContainer();
CreateOverlay();

//Ajout d'un item 
echo "
    <main class='add-item'>
        <h1>Ajouter un item</h1>
        
        <form method='POST' name ='myItem'>
            <fieldset>
                <!-- Nom -->
                <label for='name'>Nom</label>
                <input type='text' id='name' name='name' value=''>
                
                <!-- Type -->
                <label for='types'>Type</label>
                <select name='types' id='types'>
                    <option selected disabled hidden value=''>-Choisir un type-</option>
                    <option value='AR'>Arme</option>
                    <option value='AM'>Armure</option>
                    <option value='PO'>Potion</option>
                    <option value='RS'>Ressource</option>
                </select>
                
                <!-- Arme -->
                <div id='AR_Informations' class='addItemInfosContainer hidden'>
                    <label for='efficiency'>Efficacité</label>
                    <input type='number' id='efficiency' name='efficiency' value='0'>
                    <label for='genres'>Genre</label>
                    <select name='genders' id='genders'>
                        <option selected disabled hidden value=''>-Choisir un genre-</option>
                        <option value='one-handed'>Une main</option>
                        <option value='two-handed'>Deux mains</option>
                    </select>
                    <label for='weaponDescription'>Description</label>
                    <textarea id='weaponDescription' name='weaponDescription'></textarea>
                </div>
                
                <!-- Armure -->
                <div id='AM_Informations' class='addItemInfosContainer hidden'>
                    <label for='materials'>Matière</label>
                    <select name='materials' id='materials'>
                        <option selected disabled hidden value=''>-Choisir une matière-</option>
                        <option value='leather'>Cuire</option>
                        <option value='metal'>Métal</option>
                    </select>
                    <label for='weigth'>Poids</label>
                    <input type='number' id='weigth' name='weigth' value='0'>
                    <label for='size'>Taille</label>
                    <input type='number' id='size' name='size' value='0'>
                </div>
                
                <!-- Potion -->
                <div id='PO_Informations' class='addItemInfosContainer hidden'>
                    <label for='effect'>Effet</label>
                    <textarea id='effect' name='effect'></textarea>
                    <label for='duration'>Durée (secondes)</label>
                    <input type='number' id='duration' name='duration' value='0'>
                </div>
    
                <!-- Ressource -->
                <div id='RS_Informations' class='addItemInfosContainer hidden'>
                    <label for='ressourceDescription'>Description</label>
                    <textarea id='ressourceDescription' name='ressourceDescription'></textarea>
                </div>
    
                <!-- Quantité -->
                <label for='quantity'>Quantité</label>
                <input type='number' id='quantity' name='quantity' value='0'>
                
                <!-- Prix -->
                <label for='price'>Prix unitaire (écus)</label>
                <input type='number' id='price' name='price' value='0' >
                
                <!-- Image -->
                <label for='picture'>Image</label>
                <div class='addItemPreviewContainer'>
                    <img src='" . $root . "icons/DefaultIcon.png' id='imageToUpload' oneclick='imageClick()'>
                </div>
                <input type='file' accept='.jpg,.jpeg,.png' id='picture' onchange='displayImage(this)' name='picture' value=''>
                
                <!-- Ajouter -->
                <input type='submit' class='saveChanges' value='Ajouter'>
        </fieldset>
    </form>
</main>";

echo "<div id='deleteConfirmReference'></div>";
//---------------------------------------------------------------------------------------------------------------------
include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/add-item.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/functions.js' defer></script>";
    