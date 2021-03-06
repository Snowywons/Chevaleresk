<?php

$root = "../";

include_once $root."master/header.php";
include_once $root."utilities/dbUtilities.php";
include_once $root."utilities/filterUtilities.php";
include_once $root."utilities/popupUtilities.php";

global $conn;

$myId = 1; //Id du joueur (à  récupérer dans la superglobal session)
$records = executeQuery("SELECT * FROM PaniersJoueur WHERE idJoueur=$myId;");

/*Important de construire un array de la forme adéquate*/
$idItems = [];
foreach($records as $data) {
    array_push($idItems, $data[1]);
}
CreateItemDetailsContainers($idItems);
CreateItemDeleteConfirmationContainers($idItems);
CreateOverlay();


echo <<<HTML
<main class="shopping-cart">
    <h1>Panier d'achat</h1>
    
HTML;

CreateFilterSection();

echo <<<HTML
    <br>
    <div class="storeContainer">
        <div class="category">Item</div>
        <div class="category">Prix unitaire ($)</div>
        <div class="category rightLastColumn">Quantité ajoutée</div>
HTML;

foreach ($records as $data) {
    $idJoueur = $data[0];
    $idItem = $data[1];
    $quantiteItem = $data[2];

    $nomItem = "NOM ITEM";
    $prixItem = "PRIX ITEM";

    echo "
    <div id='".$idItem. "_preview' class='itemPreviewContainer'>
        <img src='".$root."icons/ChevalereskIcon.png'/>
        <div>" . $nomItem . "</div>
    </div>
    
    <div>$prixItem</div>
    
    <div class='rightLastColumn'>
                <div class='shoppingCartActionsContainer'>
                    <!-- Ajouter, Diminuer -->
                    <div class='shoppingCartQuantityContainer'>
                        <button id='".$idItem."_removeItem' class='removeItem hidden'>-</button>
                        <input id='".$idItem."_itemQuantity' class='itemQuantity' type='number' value='$quantiteItem' disabled/>
                        <button id='".$idItem."_addItem' class='addItem hidden'>+</button>
                    </div>
                    <!-- Modifier, Supprimer -->
                    <div class='adminButtonsContainer'>
                        <button id='".$idItem."_modifyButton' class='modifyButton'>
                            <img src='".$root."/icons/EditIcon.png'/>
                        </button>
                        <button id='".$idItem."_deleteButton' class='deleteButton'>
                            <img src='".$root."/icons/DeleteIcon.png'/>
                        </button>
                    </div>
                </div>
          </div>";
}

echo <<<HTML
</div>
<br>
<div class="shoppingCartTotalContainer">
    <div>Votre solde</div><div>0</div>
    <div>Total</div><div>-0</div>
    <div></div><div class="totalLigne"></div>
    <div>Solde restant</div><div>0</div>
    <div></div><div><br><button class="pay">Payer</button></div>
</div>
</main>
HTML;

include_once $root."master/footer.php";

echo "
    <script type='text/javascript' src='".$root."js/filter.js' defer></script>
    <script type='text/javascript' src='".$root."js/popup.js' defer></script>
    <script type='text/javascript' src='".$root."js/shoppingcart.js' defer></script>
    <script type='text/javascript' src='".$root."js/evaluations.js' defer></script>";

?>
