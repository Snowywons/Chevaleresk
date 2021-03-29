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
            <div>$balance</div>
            <div class='adminActionsContainer'>
                <button id='" . $alias . "_bagButton' class='bagButton'>
                    <img src='" . $root . "/icons/BagIcon.png'/>
                </button>
                <button id='" . $alias . "_modifyButton' class='modifyButton'>
                    <img src='" . $root . "/icons/EditIcon.png'/>
                </button>
                <button id='" . $alias . "_deleteButton' class='deleteButton'>
                    <img src='" . $root . "/icons/DeleteIcon.png'/>
                </button>
            </div>";
    }

    $content .= "</div>";

    return $content;
}