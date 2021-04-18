<?php
$root = "../";

global $conn;

function CreateManagerContainer($records) {
    global $root;

    $content = "
        <div class='managerContainer'>
            <div class='category'>Alias</div>
            <div class='category'>Nom</div>
            <div class='category'>Prénom</div>
            <div class='category'>Solde (écus)</div>
            <div class='category'>Actions</div>";

    foreach ($records as $data) {
        $alias = $data[0];
        $lastName = $data[1];
        $firstName = $data[2];
        $balance = $data[3];
        $isAdmin = $data[4];

        $content .= "
            <div>$alias</div>
            <div>$lastName</div>
            <div>$firstName</div>
            <div class='adminActionsContainer' style='justify-content:flex-end'>
                $balance
                <button class='balanceButton' onclick='UpdatePlayerBalance(\"$alias\", $balance)'>
                    <img src='" . $root . "/icons/EditIcon.png'/>
                </button>
            </div>
            <div class='adminActionsContainer'>
                <button class='shoppingCartButton' onclick='Redirect(\"../store/shopping-cart\", \"alias=$alias\")'>
                    <img src='" . $root . "/icons/ShoppingCartIcon.png'>
                </button>
                <button class='bagButton' onclick='Redirect(\"../profile/inventory\", \"alias=$alias\")'>
                    <img src='" . $root . "/icons/BagIcon.png'/>
                </button>
                <button class='modifyButton' onclick='Redirect(\"../profile/modify-profile\", \"alias=$alias\")'>
                    <img src='" . $root . "/icons/EditIcon.png'/>
                </button>
                <button class='deleteButton' onclick='DeletePlayer(\"$alias\")'>
                    <img src='" . $root . "/icons/DeleteIcon.png'/>
                </button>
            </div>";
    }

    $content .= "</div>";

    return $content;
}