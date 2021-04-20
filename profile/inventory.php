<?php

$root = "../";

include_once $root . "master/header.php";
include_once $root . "utilities/sessionUtilities.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "utilities/filterUtilities.php";
include_once $root . "utilities/popupUtilities.php";
include_once $root . "server/httpRequestHandler.php";
include_once $root . "db/playersDT.php";
include_once $root . "db/itemsDT.php";
include_once $root . "db/weaponsDT.php";
include_once $root . "db/armorsDT.php";
include_once $root . "db/potionsDT.php";
include_once $root . "db/ressourcesDT.php";
include_once $root . "db/inventoriesDT.php";
include_once $root . "store/storeUpdate.php";

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
    header("location: ../profile/profile.php");
    exit;
}

//Création des conteneurs cachés et du overlay
$records = GetAllInventoryItemsByAlias($targetAlias);
CreateItemDetailsContainers($records);
CreateNotificationContainer();
CreateOverlay();

echo "
<main class='inventory'>
    <h1>Inventaire de $targetAlias</h1>
    
    <div class='bigButton backToStoreContainer' onclick='Redirect(\"../store/store\")'>
        <span class='backToStoreButton'>Retour au magasin</span>
    </div>";

CreateFilterSection();

echo "<div id='storeReference'>";
echo CreateInventoryStoreContainer($records);


if($records == NULL){

    echo "<br>
    L'inventaire de $targetAlias est vide !";
}

echo "</div></main>";

echo "<div id='popupContentReference'></div>";
//---------------------------------------------------------------------------------------------------------------------

include_once $root."master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/filters.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/store.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/evaluations.js' defer></script>";

?>
