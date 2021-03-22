<?php
$root = "../";

include_once $root . "master/header.php";
include_once $root . "utilities/sessionUtilities.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "utilities/filterUtilities.php";
include_once $root . "utilities/popupUtilities.php";
include_once $root . "db/itemsDT.php";
include_once $root . "db/weaponsDT.php";
include_once $root . "db/armorsDT.php";
include_once $root . "db/potionsDT.php";
include_once $root . "db/ressourcesDT.php";
include_once $root . "store/storeUpdate.php";

global $conn;

//Création des conteneurs cachés et du overlay
$records = GetAllItems();
CreateItemDetailsContainers($records);
CreateItemDeleteConfirmationContainers($records);
CreateOverlay();

//---------------------------------------------------------------------------------------------------------------------
echo "
    <main class='store'>
        <h1>Magasin</h1>";

if (UserIsAdmin()) {
    echo "
        <div class='addItemContainer'>
            <span>Ajouter un item</span>
            <img src='../icons/PlusIcon.png'>
        </div>
        <br>";
}

CreateFilterSection();
$records = isset($_SESSION["filters"]) ? GetFilteredItems($_SESSION["filters"]) : GetAllItems();

echo "<div id='storeReference'>";
echo CreateStoreContainer($records);
echo "</div></main>";
//---------------------------------------------------------------------------------------------------------------------

include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/filters.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/store.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/itemPreviewButtons.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/shoppingcart.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/evaluations.js' defer></script>";
?>
