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
include_once $root . "db/evaluationsDT.php";
include_once $root . "evaluations/evaluationsUpdate.php";


global $conn;

CreateNotificationContainer();
CreateOverlay();

$idItem = isset($_GET["idItem"]) ? $_GET["idItem"] : "";

echo "
<main class='evaluations'>
    <h1>Évaluations</h1>";

echo "<div id='evaluationsReference'>";

if ($idItem == "") {
    CreateBackToStoreButton();
    $records = GetAllEvaluationsPreviews();
    echo CreateEvaluationsContainer($records);
} else {
    echo "
        <div class='bigButton evaluationsListButtonContainer'>
            <span>Retour à la liste</span>
        </div>";

    $records = GetEvaluationPreviewByIdItem($idItem);
    echo CreateEvaluationContainer($records);
}

echo "</div></main>";
echo "<div id='popupContentReference'></div>";

include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/evaluations.js' defer></script>";
?>
