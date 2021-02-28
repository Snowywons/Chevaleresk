<?php
include_once "header.php";
include_once "dbConnect.php";
include_once "dbUtilities.php";
include_once "filterUtilities.php";
include_once "popupUtilities.php";

global $conn;

$records = [];
$myId = 1; //Id du joueur (à  récupérer dans la superglobal session)

if ($conn) {
    $query = "SELECT * FROM Inventaires WHERE idJoueur=$myId;";

    try {
        $records = $conn->query($query)->fetchall();
    } catch (PDOException $e) { }
}

//var_dump($records);

/*Important de construire un array de la forme adéquate*/
$idItems = [];
foreach($records as $data) {
    array_push($idItems, $data[1]);
}
CreateItemDetailsContainers($idItems);


echo <<<HTML
<main class="inventoryPage">
    <h1>Inventaire</h1>
    
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

    echo "<div id='".$idItem."_preview' class='itemPreviewContainer'>
                <img src='./Icons/ChevalereskIcon.png'/>
                <div>" . $nomItem . "</div>
          </div>";
    echo "<div class='rightLastColumn'>$quantiteItem</div>";
}

echo <<<HTML
    </div>
</main>
HTML;

include_once "footer.php";
echo <<<HTML
    <script type="text/javascript" src="filter.js" defer></script>
    <script type="text/javascript" src="popup.js" defer></script>
    <script type="text/javascript" src="evaluation.js" defer></script>
HTML;
?>
