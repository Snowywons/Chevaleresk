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

function CreateStoreContainer($records)
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

        $content .= "
            <div id='" . $idItem . "_preview' class='itemPreviewContainer fadeIn'>
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
                    <button id='" . $idItem . "_addToShoppingCart' class='addToShoppingCart'>Ajouter</button>
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
            <div id='" . $idItem . "_preview' class='itemPreviewContainer fadeIn'>
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
                    <button id='" . $idItem . "_saveButton' class='saveButton'>
                        <img src='" . $root . "/icons/SaveIcon.png'/>
                    </button>
                    <button id='" . $idItem . "_deleteButton' class='deleteButton'>
                        <img src='" . $root . "/icons/DeleteIcon.png'/>
                    </button>
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
        <div class='category'>Quantité</div>";

    foreach ($records as $data) {
        $idItem = $data[0];
        $name = $data[1];
        $stock = $data[2];
        $price = $data[3];
        $photoURL = $data[4];
        $codeType = $data[5];
        $quantity = $data[6];

        $content .= "
            <div id='" . $idItem . "_preview' class='itemPreviewContainer fadeIn'>
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
                    <button id='" . $idItem . "_saveButton' class='saveButton'>
                        <img src='" . $root . "/icons/SaveIcon.png'/>
                    </button>
                    <button id='" . $idItem . "_deleteButton' class='deleteButton'>
                        <img src='" . $root . "/icons/DeleteIcon.png'/>
                    </button>
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