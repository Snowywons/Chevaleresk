<?php
$root = "../";

include_once $root."master/header.php";
include_once $root."utilities/dbUtilities.php";

if (isset($_GET["idJoueur"])) {
    $idPlayer = $_GET["idJoueur"];
} else {
    $idPlayer = 1; //Id du joueur (à  récupérer dans la superglobal session)
}
$records = executeQuery("SELECT * FROM Joueurs WHERE idJoueur=$idPlayer;")[0];

$alias = $records[1];
$lastName = $records[2];
$firstName = $records[3];
$balance = $records[4];
//$password = $records[5];

echo <<<HTML
<!--DEV MESSAGE-->
<h1 style="background-color: deeppink">PAGE ACCESSIBLE SEULEMENT PAR LES ADMINISTRATEURS</h1>
<main class="delete-profile">
    <h1>Supprimer un profil</h1>
    
    <form action="">
        <fieldset>
                <label for="alias">Alias</label>
                <input type="text" id="alias" name="alias" value="$alias" disabled>
                <label for="firstName">Nom</label>
                <input type="text" id="firstName" name="firstName" value="$firstName" disabled>
                <label for="lastName">Last name:</label>
                <input type="text" id="lastName" name="lastName" value="$lastName" disabled>
                <label for="balance">Solde (écus)</label>
                <input type="text" id="balance" name="balance" value="$balance" disabled>
HTML;
echo <<<HTML
            <input type="submit" value="Supprimer">
        </fieldset>
    </form>
</main>
HTML;

include_once $root."master/footer.php";

?>