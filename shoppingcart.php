<?php
include_once "header.php";
include_once "dbConnect.php";
include_once "filterUtilities.php";
include_once "popupUtilities.php";

global $conn;

$records = [];
$myId = 1; //Id du joueur (à  récupérer dans la superglobal session)

if ($conn) {
    $query = "SELECT * FROM PaniersJoueur WHERE idJoueur=$myId;";

    try {
        $records = $conn->query($query)->fetchall();
    } catch (PDOException $e) { }
}

/*Important de construire un array de la forme adéquate*/
$idItems = [];
foreach($records as $data) {
    array_push($idItems, $data[1]);
}
CreateItemDetailsContainers($idItems);


echo <<<HTML
<main class="shoppingcartPage">
    <h1>Panier d'achat</h1>
    
HTML;

CreateFilterSection();

echo <<<HTML
    <br>
    <div class="storeContainer">
        <div class="category">Item</div>
        <div class="category">Prix unitaire ($)</div>
        <div class="category">Quantité ajoutée</div>
HTML;

foreach ($records as $data) {
    $idJoueur = $data[0];
    $idItem = $data[1];
    $quantiteItem = $data[2];

    $nomItem = "NOM ITEM";
    $prixItem = "PRIX ITEM";

    echo "<div id='".$idItem."_preview' class='itemPreviewContainer'>
                <img src='./Icons/ChevalereskIcon.png'/>
                <div>" . $nomItem . "</div>
          </div>";
    echo "<div>" . $prixItem . "</div>";
    echo "<div class='rightLastColumn'>
                <div class='shoppingCartColumn'>
                    <button id='".$idItem."_removeItem' class='removeItem hidden'>-</button>
                    <input id='".$idItem."_itemQuantity' class='itemQuantity' type='number' value='$quantiteItem' disabled/>
                    <button id='".$idItem."_addItem' class='addItem hidden'>+</button>
                    <button id='".$idItem."_modifyItemQuantity' class='modifyItemQuantity'>Modifier</button>
                    <button id='".$idItem."_deleteFromShoppingCart' class='deleteFromShoppingCart'>Supprimer</button>
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