<?php
$root = "../";

include_once $root . "utilities/sessionUtilities.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "db/itemsDT.php";

global $conn;

if (isset($_POST["filters"])) {
    $_SESSION["filters"] = $_POST["filters"];
    $records = GetFilteredItems($_POST['filters']);

    echo json_encode(CreateStoreContainer($records));
}

function CreateStoreContainer($records)
{
    global $root;

    $isAdmin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : false;

    $content = "
        <div class='storeContainer'>
        <div class='category'>Item</div>
        <div class='category'>Prix unitaire (écus)</div>
        <div class='category'>Quantité disponible</div>
        <div class='category rightLastColumn'>Quantité souhaitée</div>";

    foreach ($records as $data) {
        $idItem = $data[0];
        $name = $data[1];
        $stock = $data[2];
        $price = $data[3];
        $photoURL = $data[4];
        $codeType = $data[5];

        $content .= "
            <div id='" . $idItem . "_preview' class='itemPreviewContainer'>";

        if ($isAdmin) {
            $content .= "
                <div class='adminButtonsContainer'>
                    <button id='" . $idItem . "_modifyButton' class='modifyButton'>
                        <img src='" . $root . "/icons/EditIcon.png'/>
                    </button>
                    <button id='" . $idItem . "_deleteButton' class='deleteButton'>
                        <img src='" . $root . "/icons/DeleteIcon.png'/>
                    </button>
                </div>";
        }

        $content .= "
                <div class='itemIconContainer'>
                    <img src='" . $root . "/icons/$photoURL.png'/>
                </div>
                <div class='titleContainer'>
                    <div>" . $name . "</div>
                </div>
            </div>
            <div>" . $price . "</div>
            <div>" . $stock . "</div>
            <div class='rightLastColumn'>
                <div class='shoppingCartActionsContainer'>
                    <div class='shoppingCartQuantityContainer'>
                        <button id='" . $idItem . "_removeItem' class='removeItem'>-</button>
                        <input id='" . $idItem . "_itemQuantity' class='itemQuantity' type='number' value='0'/>
                        <button id='" . $idItem . "_addItem' class='addItem'>+</button>
                    </div>
                    <div class='adminButtonsContainer'>
                        <button id='" . $idItem . "_addToShoppingCart' class='addToShoppingCart'>Ajouter</button>
                    </div>
                </div>
            </div>";
    }

    return $content;
}

?>