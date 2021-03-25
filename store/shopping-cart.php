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

$alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";

//Création des conteneurs cachés et du overlay
$records = GetAllItems();
CreateItemDetailsContainers($records);
CreateNotificationContainer();
CreateOverlay();

//---------------------------------------------------------------------------------------------------------------------
echo <<<HTML
<main class="shopping-cart">
    <h1>Panier d'achat</h1>
    
HTML;

CreateFilterSection();
$records = isset($_SESSION["filters"]) ?
    GetFilteredShoppingCartItemsByAlias($_SESSION["filters"], $alias) : GetAllShoppingCartItemsByAlias($alias);

echo "<div id='storeReference'>";
echo CreateShoppingCartStoreContainer($records);
echo "</div>";

echo <<<HTML
</div>
<br>
<div class="shoppingCartTotalContainer">
    <div>Votre solde</div><div>0</div>
    <div>Total</div><div>-0</div>
    <div></div><div class="totalLigne"></div>
    <div>Solde restant</div><div>0</div>
    <div></div><div><br><button id="payButton" class="pay">Payer</button></div>
</div>
</main>
HTML;
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

