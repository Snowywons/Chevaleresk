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
include_once $root . "db/evaluationsDT.php";
include_once $root . "evaluations/evaluationsUpdate.php";


global $conn;

$_SESSION["filters"] = "'AR','AM','PO','RS'";

$idItem = isset($_GET["idItem"]) ? $_GET["idItem"] : "";

echo "
<main class='evaluations'>
    <h1>Évaluations</h1>";

echo "<div id='evaluationsReference'>";

if ($idItem == "") {
    echo "
        <div class='bigButton backToStoreContainer' onclick='Redirect(\"../store/store\")'>
            <span class='backToStoreButton'>Retour au magasin</span>
        </div>";

    CreateFilterSection();

    $records = GetAllEvaluationsPreviews();
    echo CreateEvaluationsContainer($records);
} else {
    echo "
        <div class='bigButton evaluationsListButtonContainer' 
            onClick='Redirect(\"../evaluations/evaluations\")'>
            <span>Retour à la liste</span>
        </div>";

    $records = GetEvaluationPreviewByIdItem($idItem);
    echo CreateEvaluationContainer($records);
}

echo "</div></main>";

include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/filters.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/store.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/evaluations.js' defer></script>";
?>
