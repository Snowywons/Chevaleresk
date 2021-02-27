<?php
include_once "header.php";
include_once "dbUtilities.php";
include_once "filterUtilities.php";
include_once "popupUtilities.php";

$conn = connectDB("167.114.152.54", "dbchevalersk13", "chevalier13", "x7ad6a84");
$records = [];

if ($conn) {
    $query = "SELECT * FROM Items;";

    try {
        $records = $conn->query($query)->fetchall();
    } catch (PDOException $e) { }
}

//var_dump($records);

/*Important de construire un array de la forme adéquate*/
$idItems = [];
foreach($records as $data) {
    array_push($idItems, $data[0]);
}
CreateItemDetailsContainers($idItems);


echo <<<HTML
<main class="indexPage">
    <h1>Magasin</h1>
    
HTML;

CreateFilterSection();

echo <<<HTML
    <br>
    <div class="storeContainer">
        <div class="category">Item</div>
        <div class="category">Prix unitaire ($)</div>
        <div class="category">Quantité disponible</div>
        <div class="category">Quantité souhaitée</div>
HTML;

foreach ($records as $data) {
    $idItem = $data[0];
    $nomItem = $data[1];
    $quantiteStock = $data[2];
    $prixItem = $data[3];
    $photoItem = $data[4];
    $codeType = $data[5];

    echo "<div id='".$idItem."_preview' class='itemPreviewContainer'>
                <img src='./Icons/ChevalereskIcon.png'/>
                <div>" . $nomItem . "</div>
          </div>";
    echo "<div>" . $prixItem . "</div>";
    echo "<div>" . $quantiteStock . "</div>";
    echo "<div class='rightLastColumn'>
                <div class='shoppingCartColumn'>
                    <button id='".$idItem."_removeItem' class='removeItem'>-</button>
                    <input id='".$idItem."_itemQuantity' class='itemQuantity' type='number' value='0'/>
                    <button id='".$idItem."_addItem' class='addItem'>+</button>
                    <button id='".$idItem."_addToShoppingCart' class='addToShoppingCart'>Ajouter</button>
                </div>
          </div>";
}

echo <<<HTML
    </div>
</main>
HTML;

include_once "footer.php";
echo <<<HTML
    <script type="text/javascript" src="filter.js" defer></script>
    <script type="text/javascript" src="popup.js" defer></script>
    <script type="text/javascript" src="shoppingcart.js" defer></script>
HTML;
?>
