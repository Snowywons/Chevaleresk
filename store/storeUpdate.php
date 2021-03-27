<?php
$root = "../";

include_once $root . "utilities/sessionUtilities.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "utilities/popupUtilities.php";
include_once $root . "db/itemsDT.php";
include_once $root . "db/playersDT.php";
include_once $root . "db/shopping-cartsDT.php";
include_once $root . "db/inventoriesDT.php";

global $conn;

if (isset($_POST["submit"])) {

    //Sur un changement de filtre
    if ($_POST["submit"] == "setFilters") {
        $alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
        $filters = isset($_POST["filters"]) ? $_POST["filters"] : "'','','',''";
        $_SESSION["filters"] = $filters;

        //Mise à jour des conteneurs du store à partir de la page 'store.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "store") {
            $records = GetFilteredItems($filters);
            echo json_encode(CreateStoreContainer($records));
            exit;
        }

        //Mise à jour des conteneurs du store à partir de la page 'shopping-cart.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "shopping-cart") {
            $records = GetFilteredShoppingCartItemsByAlias($filters, $alias);
            echo json_encode(CreateShoppingCartStoreContainer($records));
            exit;
        }

        //Mise à jour des conteneurs du store à partir de la page 'inventory.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "inventory") {
            $records = GetFilteredInventoryItemsByAlias($filters, $alias);
            echo json_encode(CreateInventoryStoreContainer($records));
            exit;
        }
    }

    //Sur la création d'un conteneur de suppression d'item
    if ($_POST["submit"] == "createDeleteConfirmContainer") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
        $sender = isset($_POST["sender"]) ? $_POST["sender"] : "";

        echo json_encode(CreateItemDeleteConfirmationContainer($idItem, $sender));
        exit;
    }

    //Sur l'ajout d'un item au panier
    if ($_POST["submit"] == "addItemShoppingCart") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = $_SESSION["alias"];
        $idItem = $_POST["idItem"];
        $quantity = $_POST["quantity"];

        echo AddItemShoppingCartByAlias($alias, $idItem, $quantity);
        exit;
    }

    //Sur la modification de quantité d'un item
    if ($_POST["submit"] == "modifyItemQuantity") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
        $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";

        //Demande de la page 'store.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "store") {
            echo "Cette fonctionnalité n'existe pas.";
            exit;
        }

        //Demande de la page 'shopping-cart.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "shopping-cart") {
            echo ModifyItemQuantityShoppingCartByAlias($alias, $idItem, $quantity);
            exit;
        }

        //Demande de la page 'inventory.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "inventory") {
            echo ModifyItemQuantityInventoryByAlias($alias, $idItem, $quantity);
            exit;
        }
    }

    //Sur la suppression d'un item
    if ($_POST["submit"] == "deleteConfirm") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";

        //Demande de la page 'store.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "store") {
            echo "Cette fonctionnalité n'existe pas.";
            exit;
        }

        //Demande de la page 'shopping-cart.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "shopping-cart") {
            echo DeleteItemFromShoppingCartByAlias($alias, $idItem);
            exit;
        }

        //Demande de la page 'inventory.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "inventory") {
            echo DeleteItemFromInventoryByAlias($alias, $idItem);
            exit;
        }
    }

    //Sur le paiement du panier du joueur
    if ($_POST["submit"] == "payShoppingCart") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";

        $message = PayShoppingCartByAlias($alias);
        $_SESSION["balance"] = GetPlayerBalanceByAlias($alias);

        echo $message;
        exit;
    }

    //Sur le calcule du panier du joueur
    if ($_POST["submit"] == "calculateShoppingCart") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        echo json_encode(CreateShoppingCartTotalContainer());
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
            <div id='" . $idItem . "_preview' class='itemPreviewContainer fadeIn'>";

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
            <div class='fadeIn'>" . $price . "</div>
            <div class='fadeIn'>" . $stock . "</div>
            <div class='rightLastColumn fadeIn'>
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

    $content .= "</div>";

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
            <div id='" . $idItem . "_preview' class='itemPreviewContainer fadeIn'>";

        $content .= "
                <div class='itemIconContainer'>
                    <img src='" . $root . "/icons/$photoURL.png'/>
                </div>
                <div class='titleContainer'>
                    <div>" . $name . "</div>
                </div>
            </div>
            <div class='fadeIn'>" . $price . "</div>
            <div class='fadeIn'>" . $stock . "</div>
            <div class='rightLastColumn fadeIn'>
                <div class='shoppingCartActionsContainer'>
                    <div class='shoppingCartQuantityContainer'>
                        <button id='" . $idItem . "_removeItem' class='removeItem'>-</button>
                        <input id='" . $idItem . "_itemQuantity' class='itemQuantity' type='number' value='$quantity'/>
                        <button id='" . $idItem . "_addItem' class='addItem'>+</button>
                    </div>
                    <div class='adminButtonsContainer'>
                        <button id='" . $idItem . "_saveButton' class='saveButton'>
                            <img src='" . $root . "/icons/SaveIcon.png'/>
                        </button>
                        <button id='" . $idItem . "_deleteButton' class='deleteButton'>
                            <img src='" . $root . "/icons/DeleteIcon.png'/>
                        </button>
                    </div>
                </div>
            </div>";
    }

    $content .= "</div>";

    return $content;
}

function CreateShoppingCartTotalContainer()
{
    $alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
    $currentBalance = GetPlayerBalanceByAlias($alias);
    $total = CalculateShoppingCartTotalByAlias($alias);
    $remainingBalance = $currentBalance - $total;
    $color = $remainingBalance < 0 ? "red" : "black";

    $content = "        
        <div id='shoppingCartTotalContainer' class='shoppingCartTotalContainer'>
            <div id='currentBalanceContainer'>Votre solde</div><div>$currentBalance</div>
            <div id='totalContainer'>Total</div><div style='color: crimson'>-$total</div>
            <div></div><div class='totalLigne'></div>
            <div id='remainingBalanceContainer'>Solde restant</div><div style='color: $color'>$remainingBalance</div>
        </div>";

    return $content;
}

function CreateInventoryStoreContainer($records)
{
    global $root;

    $isAdmin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : false;

    $content = "
        <div class='storeContainer'>
        <div class='category'>Item</div>
        <div class='category rightLastColumn'>Quantité</div>";

    foreach ($records as $data) {
        $idItem = $data[0];
        $name = $data[1];
        $stock = $data[2];
        $price = $data[3];
        $photoURL = $data[4];
        $codeType = $data[5];
        $quantity = $data[6];

        $content .= "
            <div id='" . $idItem . "_preview' class='itemPreviewContainer fadeIn'>";

        $content .= "
                <div class='itemIconContainer'>
                    <img src='" . $root . "/icons/$photoURL.png'/>
                </div>
                <div class='titleContainer'>
                    <div>" . $name . "</div>
                </div>
            </div>
            <div class='rightLastColumn fadeIn'>";

        if ($isAdmin) {
            $content .= "
                <div class='shoppingCartActionsContainer'>
                    <div class='shoppingCartQuantityContainer'>
                        <button id='" . $idItem . "_removeItem' class='removeItem'>-</button>
                        <input id='" . $idItem . "_itemQuantity' class='itemQuantity' type='number' value='$quantity'/>
                        <button id='" . $idItem . "_addItem' class='addItem'>+</button>
                    </div>
                    <div class='adminButtonsContainer'>
                        <button id='" . $idItem . "_saveButton' class='saveButton'>
                            <img src='" . $root . "/icons/SaveIcon.png'/>
                        </button>
                        <button id='" . $idItem . "_deleteButton' class='deleteButton'>
                            <img src='" . $root . "/icons/DeleteIcon.png'/>
                        </button>
                    </div>
                </div>";
        } else {
            $content .= "
                <div class='shoppingCartActionsContainer'>
                    <div class='shoppingCartQuantityContainer'>
                        <input id='" . $idItem . "_itemQuantity' 
                        class='itemQuantity' type='number' disabled value='$quantity'/>
                    </div>
                </div>";
        }

        $content .= "</div>";
    }

    $content .= "</div>";

    return $content;
}

?>