<?php

$root = "../";

include_once $root."master/header.php";
include_once $root."utilities/dbUtilities.php";
include_once $root."utilities/filterUtilities.php";
include_once $root."utilities/popupUtilities.php";

global $conn;

if (isset($_GET["idJoueur"])) {
    $idPlayer = $_GET["idJoueur"];
} else {
    $idPlayer = 1; //Id du joueur (à  récupérer dans la superglobal session)
}
$records = executeQuery("SELECT * FROM Joueurs WHERE idJoueur=$idPlayer;")[0];
$alias = $records[1];

$records = executeQuery("SELECT * FROM Inventaires WHERE idJoueur=$idPlayer;");
/*Important de construire un array de la forme adéquate*/
$idItems = [];
foreach($records as $data) {
    array_push($idItems, $data[1]);
}
CreateItemDetailsContainers($idItems);
CreateOverlay();


echo <<<HTML
<main class="inventory">
    <h1>Inventaire de $alias</h1>
    
HTML;

CreateFilterSection();

echo <<<HTML
    <br>
    <div class="storeContainer">
        <div class="category">Item</div>
        <div class="category">Quantité</div>
HTML;

foreach ($records as $data) {
    $idJoueur = $data[0];
    $idItem = $data[1];
    $quantiteItem = $data[2];

    $nomItem = "NOM ITEM";

    echo "<div id='".$idItem. "_preview' class='itemPreviewContainer'>
                <img src='".$root."icons/ChevalereskIcon.png'/>
                <div>" . $nomItem . "</div>
          </div>";
    echo "<div class='rightLastColumn'>$quantiteItem</div>";
}

echo <<<HTML
    </div>
</main>
HTML;

include_once $root."master/footer.php";

echo "
    <script type='text/javascript' src='".$root."js/filter.js' defer></script>
    <script type='text/javascript' src='".$root."js/popup.js' defer></script>
    <script type='text/javascript' src='".$root."js/evaluations.js' defer></script>";

?>
