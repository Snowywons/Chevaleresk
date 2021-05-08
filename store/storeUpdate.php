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
            <div id='" . $idItem . "_preview' class='itemPreviewContainer fadeIn' onclick='OpenPopup(\"" . $idItem . "_itemDetailsContainer\")'>
                <div class='itemIconContainer'>
                    <img src='" . $root . "/icons/$photoURL'/>
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
                        <button class='removeItem' onclick='RemoveItem(\"$idItem\")'>-</button>
                        <input id='" . $idItem . "_itemQuantity' class='itemQuantity' type='number' value='1'/>
                        <button class='addItem' onclick='AddItem(\"$idItem\")'>+</button>
                    </div>
                    <button class='addToShoppingCart' onclick='AddItemToCart(\"$idItem\")'>Ajouter</button>
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
            <div id='" . $idItem . "_preview' class='itemPreviewContainer fadeIn' onclick='OpenPopup(\"" . $idItem . "_itemDetailsContainer\")'>
                <div class='itemIconContainer'>
                    <img src='" . $root . "/icons/$photoURL'/>
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
                        <input id='" . $idItem . "_quantity' class='itemQuantity' type='number' disabled value='$quantity'/>
                    </div>
                    <button class='quantityButton' onclick='UpdateQuantity(\"$idItem\")'>
                        <img src='" . $root . "/icons/EditIcon.png'/>
                    </button>
                    <button class='deleteButton' onclick='DeleteItem(\"$idItem\")'>
                        <img src='" . $root . "/icons/DeleteIcon.png'/>
                    </button>
                </div>
            </div>";
    }

    $content .= "</div>";

    return $content;
}

function CreateShoppingCartTotalContainer($alias)
{
    $currentBalance = GetPlayerBalanceByAlias($alias);
    $total = CalculateShoppingCartTotalByAlias($alias);
    $remainingBalance = $currentBalance - $total;
    $color = $remainingBalance < 0 ? "red" : "black";

    if ($total > 0) {
        return "        
        <div id='shoppingCartTotalContainer' class='shoppingCartTotalContainer'>
            <div id='currentBalanceContainer'>Votre solde</div><div>$currentBalance</div>
            <div id='totalContainer'>Total</div><div style='color: crimson'>-$total</div>
            <div></div><div class='totalLigne'></div>
            <div id='remainingBalanceContainer'>Solde restant</div><div style='color: $color'>$remainingBalance</div>
            <div></div>
            <div id='payButton' class='mediumButton payButton' onclick='PayCart()'>
                <span>Payer</span>
            </div>
        </div>";
    }

    return "<div>Le panier est vide.</div>";
}

function CreateInventoryStoreContainer($records)
{
    global $root;

    $content = "
        <div class='storeContainer'>
        <div class='category'>Item</div>
        <div class='category rightLastColumn'>Quantité</div>";

    if($records == NULL) {
        $content.= "<div style='grid-column-start: 1; grid-column-end: 3;'>Aucun item correspondant</div>";
    }

    foreach ($records as $data) {
        $idItem = $data[0];
        $name = $data[1];
        $stock = $data[2];
        $price = $data[3];
        $photoURL = $data[4];
        $codeType = $data[5];
        $quantity = $data[8];

        $content .= "
            <div id='" . $idItem . "_preview' class='itemPreviewContainer fadeIn' onclick='OpenPopup(\"" . $idItem . "_itemDetailsContainer\")'>
                <div class='itemIconContainer'>
                    <img src='" . $root . "/icons/$photoURL'/>
                </div>
                <div class='titleContainer'>
                    <div>" . $name . "</div>
                </div>
            </div>
            <div class='rightLastColumn fadeIn'>
                <div class='shoppingCartActionsContainer'>
                    <div class='shoppingCartQuantityContainer'>
                        <input id='" . $idItem . "_itemQuantity' 
                        class='itemQuantity' type='number' disabled value='$quantity'/>
                    </div>
                </div>
            </div>";
    }

    $content .= "</div>";

    return $content;
}

?>