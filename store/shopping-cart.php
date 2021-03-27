<?php
$root = "../";

include_once $root . "master/header.php";
include_once $root . "utilities/sessionUtilities.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "utilities/filterUtilities.php";
include_once $root . "utilities/popupUtilities.php";
include_once $root . "db/playersDT.php";
include_once $root . "db/itemsDT.php";
include_once $root . "db/weaponsDT.php";
include_once $root . "db/armorsDT.php";
include_once $root . "db/potionsDT.php";
include_once $root . "db/ressourcesDT.php";
include_once $root . "db/shopping-cartsDT.php";
include_once $root . "store/storeUpdate.php";

global $conn;

$_SESSION["filters"] = "'AR','AM','PO','RS'";

$alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";

//Création des conteneurs cachés et du overlay
$records = GetAllShoppingCartItemsByAlias($alias);
CreateItemDetailsContainers($records);
CreateNotificationContainer();
CreateOverlay();

//---------------------------------------------------------------------------------------------------------------------
echo "
<main class='shopping-cart'>
    <h1>Panier d'achat</h1>";

CreateFilterSection();

echo "<div id='storeReference'>";
echo CreateShoppingCartStoreContainer($records);
echo "</div>";

echo "
    <br>
    <div class='shoppingCartTransactionContainer'>
        <div id='shoppingCartTotalReference'>";
echo CreateShoppingCartTotalContainer();
echo "
        </div>
        <div></div>
        <div><br><button id='payButton' class='payButton'>Payer</button></div>
    </div>
</main>";

echo "<div id='deleteConfirmReference'></div>";
//---------------------------------------------------------------------------------------------------------------------

include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/filters.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/store.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/shoppingcart.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/evaluations.js' defer></script>";
?>

