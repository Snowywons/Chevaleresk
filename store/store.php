<?php
$root = "../";

include_once $root."master/header.php";
include_once $root."utilities/dbUtilities.php";
include_once $root."utilities/filterUtilities.php";
include_once $root."utilities/popupUtilities.php";

global $conn;

$records = executeQuery("SELECT * FROM Items;");

/*Important de construire un array de la forme adéquate*/
$idItems = [];
foreach($records as $data) {
    array_push($idItems, $data[0]);
}
CreateItemDetailsContainers($idItems);


echo <<<HTML
<h1 style="background-color: deeppink">BOUTONS AJOUT, MODIF, SUPP DISPONIBLES SEULEMENT POUR LES ADMINISTRATEURS</h1>
<main class="store">
    <h1>Magasin</h1>
    
HTML;

//DEVRAIT SEULEMENT ÊTRE DISPO POUR LES ADMINISTRATEURS
echo <<<HTML
    <div class="addItemContainer">
        <span>Ajouter un item</span>
        <img src="../icons/PlusIcon.png">
    </div>
    <br>
HTML;


CreateFilterSection();


echo <<<HTML
    <br>
    <div class="storeContainer">
        <div class="category">Item</div>
        <div class="category">Prix unitaire (écus)</div>
        <div class="category">Quantité disponible</div>
        <div class="category rightLastColumn">Quantité souhaitée</div>
HTML;

foreach ($records as $data) {
    $idItem = $data[0];
    $nomItem = $data[1];
    $quantiteStock = $data[2];
    $prixItem = $data[3];
    $photoItem = $data[4];
    $codeType = $data[5];

    echo "<div id='".$idItem. "_preview' class='itemPreviewContainer'>
                <!-- DEVRAIT SEULEMENT ÊTRE DISPO POUR LES ADMINISTRATEURS -->
                <div class='adminButtonsContainer'>
                    <button id='".$idItem."_modifyButton' class='modifyButton'>
                        <img src='".$root."/icons/EditIcon.png'/>
                    </button>
                    <button id='".$idItem."_deleteButton' class='deleteButton'>
                        <img src='".$root."/icons/DeleteIcon.png'/>
                    </button>
                </div>
                
                <img src='".$root."/icons/ChevalereskIcon.png'/>
                <div>" . $nomItem . "</div>
          </div>";
    echo "<div>" . $prixItem . "</div>";
    echo "<div>" . $quantiteStock . "</div>";
    echo "<div class='rightLastColumn'>
                <div class='shoppingCartActionsContainer'>
                <div class='shoppingCartQuantityContainer'>
                        <button id='".$idItem."_removeItem' class='removeItem'>-</button>
                        <input id='".$idItem."_itemQuantity' class='itemQuantity' type='number' value='0'/>
                        <button id='".$idItem."_addItem' class='addItem'>+</button>
                    </div>
                    <div class='adminButtonsContainer'>
                        <button id='".$idItem."_addToShoppingCart' class='addToShoppingCart'>Ajouter</button>
                    </div>
                </div>
          </div>";
}

echo <<<HTML
    </div>
</main>
HTML;

include_once $root."master/footer.php";

echo "
    <script type='text/javascript' src='".$root."js/filter.js' defer></script>
    <script type='text/javascript' src='".$root."js/popup.js' defer></script>
    <script type='text/javascript' src='".$root."js/shoppingcart.js' defer></script>
    <script type='text/javascript' src='".$root."js/item.js' defer></script>
    <script type='text/javascript' src='".$root."js/evaluations.js' defer></script>";
?>
