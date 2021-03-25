<?php
$root = "../";

include_once $root . "utilities/sessionUtilities.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "db/itemsDT.php";
include_once $root . "db/shopping-cartsDT.php";

global $conn;

if (isset($_POST["submit"])) {

    //Sur un changement de filtre
    if ($_POST["submit"] == "setFilters") {

        //Mise à jour des conteneurs du store à partir de la page 'store.php'
        if ($_POST["sender"] == "store") {
            $_SESSION["filters"] = $_POST["filters"];
            $records = GetFilteredItems($_POST['filters']);
            echo json_encode(CreateStoreContainer($records));
            exit;
        }

        //Mise à jour des conteneurs du store à partir de la page 'shopping-cart.php'
        if ($_POST["sender"] == "shopping-cart") {
            $_SESSION["filters"] = $_POST["filters"];
            $alias = $_SESSION["alias"];
            $records = GetFilteredShoppingCartItemsByAlias($_POST["filters"], $alias);

            echo json_encode(CreateShoppingCartStoreContainer($records));
            exit;
        }
    }

    //Sur l'ajout d'un item au panier
    if ($_POST["submit"] == "addToShoppingCart") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = $_SESSION["alias"];
        $idItem = $_POST["idItem"];
        $quantity = $_POST["quantity"];

        echo AddItemToShoppingCartByAlias($alias, $idItem, $quantity);
        exit;
    }

    //Sur la suppression d'un item du panier
    if ($_POST["submit"] == "deleteFromShoppingCart") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = $_SESSION["alias"];
        $idItem = $_POST["idItem"];

        echo DeleteItemFromShoppingCartByAlias($alias, $idItem);
        exit;
    }

    //Sur le paiement du panier du joueur
    if ($_POST["submit"] == "payShoppingCart") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        echo PayShoppingCartByAlias($_SESSION["alias"]);
        exit;
    }
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
                        <input id='" . $idItem . "_itemQuantity' class='itemQuantity' type='number' value='1'/>
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

function CreateShoppingCartStoreContainer($records)
{
    global $root;

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
        $quantity = $data[6];

        $content .= "
            <div id='" . $idItem . "_preview' class='itemPreviewContainer'>";

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
                        <input id='" . $idItem . "_itemQuantity' class='itemQuantity' type='number' value='$quantity'/>
                        <button id='" . $idItem . "_addItem' class='addItem'>+</button>
                    </div>
                    <div class='adminButtonsContainer'>
                        <button id='" . $idItem . "_modifyButton' class='modifyButton'>
                            <img src='" . $root . "/icons/EditIcon.png'/>
                        </button>
                        <button id='" . $idItem . "_deleteButton' class='deleteButton'>
                            <img src='" . $root . "/icons/DeleteIcon.png'/>
                        </button>
                    </div>
                </div>
            </div>";
    }

    return $content;
}

?>