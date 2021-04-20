<?php
$root = "../";

include_once $root . "master/header.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "utilities/filterUtilities.php";
include_once $root . "server/httpRequestHandler.php";
include_once $root . "db/playersDT.php";
include_once $root . "db/itemsDT.php";
include_once $root . "db/weaponsDT.php";
include_once $root . "db/armorsDT.php";
include_once $root . "db/potionsDT.php";
include_once $root . "db/ressourcesDT.php";
include_once $root . "store/storeUpdate.php";

global $conn;

$records = GetAllItems();
CreateItemDetailsContainers($records);

//---------------------------------------------------------------------------------------------------------------------
echo "
    <main class='store'>
        <h1>Magasin</h1>";

//Administrateurs seulement
if (UserIsAdmin()) {
    echo "
        <div class='bigButton addItemStoreContainer' onclick='window.location.href = \"../store/add-item.php\"'>
            <span>Ajouter un item</span>
            <img src='../icons/PlusIcon.png'>
        </div>";
}

    CreateFilterSection();

    //Le contenu du magasin
    echo "
        <div id='storeReference'>".
            CreateStoreContainer($records)."
        </div>
    </main>";
//---------------------------------------------------------------------------------------------------------------------

include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/filters.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/store.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/shoppingcart.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/evaluations.js' defer></script>";
?>
