<?php
$root = "../";

include_once $root . "master/header.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "utilities/popupUtilities.php";

global $conn;

$records = executeQuery("SELECT * FROM Joueurs;");

$idJoueurs = [];
foreach ($records as $data) {
    array_push($idJoueurs, $data[0]);
}
CreateItemDeleteConfirmationContainers($idJoueurs);
CreateOverlay();

echo <<<HTML
    <h1 style="background-color: deeppink">PAGE ACCESSIBLE SEULEMENT PAR LES ADMINISTRATEURS</h1>
    <main class='administration'>
        <h1>Gestionnaire</h1>
        
        <div class='playerInfosContainer'>
        <div class="category">ID</div>
        <div class="category">Alias</div>
        <div class="category">Nom</div>
        <div class="category">Prénom</div>
        <div class="category">Solde (écus)</div>
        <div class="category">Actions</div>
HTML;

foreach ($records as $player) {
    $idPlayer = $player[0];
    $alias = $player[1];
    $lastName = $player[2];
    $firstName = $player[3];
    $balance = $player[4];

    echo "
            <div>$idPlayer</div>
            <div>$alias</div>
            <div>$lastName</div>
            <div>$firstName</div>
            <div>$balance</div>
            <div class='adminActionsContainer'>
                <div class='adminButtonsContainer'>
                    <button id='" . $idPlayer . "_inventoryButton' class='inventoryButton'>
                        <img src='" . $root . "/icons/EyeIcon.png'/>
                    </button>
                    <button id='" . $idPlayer . "_modifyButton' class='modifyButton'>
                        <img src='" . $root . "/icons/EditIcon.png'/>
                    </button>
                    <button id='" . $idPlayer . "_deleteButton' class='deleteButton'>
                        <img src='" . $root . "/icons/DeleteIcon.png'/>
                    </button>
                </div>
            </div>";
}

echo "
    </div>
</main>";

include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/profiles.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/popup.js' defer></script>";

?>