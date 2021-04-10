<?php
$root = "../";

include_once $root . "master/header.php";
include_once $root . "utilities/sessionUtilities.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "utilities/filterUtilities.php";
include_once $root . "utilities/popupUtilities.php";
include_once $root . "server/httpRequestHandler.php";
include_once $root . "store/storeUpdate.php";
include_once $root . "db/playersDT.php";
include_once $root . "db/inventoriesDT.php";
include_once $root . "db/shopping-cartsDT.php";
include_once $root . "db/itemsDT.php";
include_once $root . "db/weaponsDT.php";
include_once $root . "db/armorsDT.php";
include_once $root . "db/potionsDT.php";
include_once $root . "db/ressourcesDT.php";

global $conn;

//Accès interdit
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false) {
    header("location: ../session/login.php");
    exit;
}

$alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
$targetAlias = isset($_GET["alias"]) ? $_GET["alias"] : $alias;
$isAdmin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : false;

//Accès interdit
if (!$isAdmin && $alias !== $targetAlias) {
    header("location: ../store/store.php");
    exit;
}

$_SESSION["filters"] = "'AR','AM','PO','RS'";

//Création des conteneurs cachés et du overlay
$records = GetAllShoppingCartItemsByAlias($targetAlias);
CreateItemDetailsContainers($records);
CreateNotificationContainer();
CreateOverlay();

//---------------------------------------------------------------------------------------------------------------------
echo "
<main class='shopping-cart'>
    <h1>Panier d'achat de $targetAlias</h1>";

echo "<div id='storeReference'>";
echo CreateShoppingCartStoreContainer($records);
echo "</div>";

echo "
    <br>
    <div class='shoppingCartTransactionContainer'>
        <div id='shoppingCartTotalReference'>";
echo CreateShoppingCartTotalContainer($targetAlias);
echo "
        </div>
        <div id='payButton' class='mediumButton payButton'><span>Payer</span></div>
    </div>
</main>";

echo "<div id='popupContentReference'></div>";
//---------------------------------------------------------------------------------------------------------------------

include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/store.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/shoppingcart.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/evaluations.js' defer></script>";
?>

