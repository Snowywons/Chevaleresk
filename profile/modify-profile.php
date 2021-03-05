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
$password = $records[5];

echo <<<HTML
<h1 style="background-color: deeppink">MODIFICATION DU SOLDE DISPONIBLE SEULEMENT POUR LES ADMINISTRATEURS</h1>
<main class="modify-profile">
    <h1>Modifier les informations</h1>
    
    <form action="">
        <fieldset>
            <label for="firstName">Nom</label>
            <input type="text" id="firstName" name="firstName" value="$firstName">
            <label for="lastName">Last name:</label>
            <input type="text" id="lastName" name="lastName" value="$lastName">
            <label for="balance">Solde (écus)</label>
            <input type="number" id="balance" name="balance" value="$balance">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="motDePasse" value="$password">
            <label for="passwordConfirm">Confirmation du mot de passe</label>
            <input type="password" id="passwordConfirm" name="" value="$password">
            <input type="submit" value="Enregistrer">
        </fieldset>
    </form>
</main>
HTML;

include_once $root."master/footer.php";

?>