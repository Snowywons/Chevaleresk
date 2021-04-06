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
include_once $root . "profile/administrationUpdate.php";

global $conn;

$records = GetAllPlayers();
CreateNotificationContainer();
CreateOverlay();

echo "
    <main class='administration'>
        <h1>Gestionnaire d'utilisateurs</h1>";

echo "<div id='managerReference'>";
echo CreateManagerContainer($records);
echo "</div></main>";

echo "<div id='popupContentReference'></div>";
//---------------------------------------------------------------------------------------------------------------------

include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/store.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/administration.js' defer></script>";
?>