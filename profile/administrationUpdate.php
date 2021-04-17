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
                <button class='balanceButton' onclick='OpenBalancePopup(\"$alias\", $balance)'>
                    <img src='" . $root . "/icons/EditIcon.png'/>
                </button>
            </div>
            <div class='adminActionsContainer'>
                <button class='shoppingCartButton' onclick='Redirect(\"$alias\", \"../store/shopping-cart\")'>
                    <img src='" . $root . "/icons/ShoppingCartIcon.png'>
                </button>
                <button class='bagButton' onclick='Redirect(\"$alias\", \"../profile/inventory\")'>
                    <img src='" . $root . "/icons/BagIcon.png'/>
                </button>
                <button class='modifyButton' onclick='Redirect(\"$alias\", \"../profile/modify-profile\")'>
                    <img src='" . $root . "/icons/EditIcon.png'/>
                </button>
                <button class='deleteButton' onclick='OpenDeletePopup(\"$alias\")'>
                    <img src='" . $root . "/icons/DeleteIcon.png'/>
                </button>
            </div>";
    }

    $content .= "</div>";

    $content .= "
        <div id='balanceEditContainer' class='popupContainer'>
            <div class='popupHeaderContainer'>
                <span>Modification du solde</span>
                <button class='popupExitButton' onclick='ClosePopupAndNotifier(\"balanceEditContainer\"), '>x</button>
            </div>
            <div class='popupBodyContainer'>
                <form action='update-balance.php' method='POST'>
                    <input type='hidden' name='alias' value=''>
                    <input type='number' name='balance' value='0'>
                    <input type='submit' value='Modifier'>
                </form>
            </div>
            <div class='popupFooterContainer'>
            </div>
        </div>";
    $content .= "
    <div id='playerDeleteContainer' class='popupContainer'>
            <div class='popupHeaderContainer'>
                <span>Confirmation de suppression</span>
                <button class='popupExitButton' onclick='ClosePopupAndNotifier(\"playerDeleteContainer\")'>x</button>
            </div>
            <div class='popupBodyContainer'>
                Êtes-vous sûr de vouloir supprimer cet utilisateur?
                <form action='../server/deletePlayerHandler.php' method='POST'>
                    <input type='hidden' name='alias' value=''>
                    <div class='confirmationButtonsContainer'>
                        <button type='button' class='popupCancelConfirmButton cancelButton' 
                        onclick='ClosePopup(\"playerDeleteContainer\")'>Annuler</button>
                        <input type='submit' class='popupDeleteConfirmButton confirmButton' value='Confirmer'>
                    </div>
                </form>
            </div>
            <div class='popupFooterContainer'>
            </div>
    ";

    return $content;
}