<?php
$root = "../";

include_once $root."master/header.php";
include_once $root . "utilities/sessionUtilities.php";
include_once $root."utilities/dbUtilities.php";
include_once $root."utilities/popupUtilities.php";
include_once $root . "db/playersDT.php";

//Accès interdit
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false) {
    header("location: ../session/login.php");
    exit;
}

$alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
$targetAlias = isset($_GET["alias"]) ? $_GET["alias"] : "";
$isAdmin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : false;

//Accès interdit
if (!$isAdmin && $alias !== $targetAlias) {
    header("location: ../profile/profile.php");
    exit;
}

$records = GetPlayerByAlias($targetAlias);
CreateNotificationContainer();
CreateOverlay();

$alias = "";
$lastName = "";
$firstName = "";
$balance = "";
$password = "";

if (count($records) > 0) {
    $alias = $records[0];
    $lastName = $records[1];
    $firstName = $records[2];
    $balance = $records[3];
    $password = "default";
}

echo <<<HTML
<main class="modify-profile">
    <h1>Modifier les informations</h1>
    
    <form method="POST">
        <fieldset>
            <input type="text" id="alias" name="alias" value="$alias" hidden disabled">
            <label for="lastName">Nom</label>
            <input type="text" id="lastName" name="lastName" value="$lastName" onblur="notEmpty('lastName')">
            <div id="lastNameValidation" style = "color:red"></div>
            <label for="firstName">Prénom</label>
            <input type="text" id="firstName" name="firstName" value="$firstName" onblur="notEmpty('firstName')">
            <div id="firstNameValidation" style = "color:red"></div>
            <label for="balance">Solde (écus)</label>
            <input type="number" id="balance" name="balance" value="$balance">
            <div id="balanceValidation" style = "color:red"></div>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="motDePasse" value="$password" onblur="notEmpty('password')">
            <div id="passwordValidation" style = "color:red"></div>
            <label for="passwordConfirm">Confirmation du mot de passe</label>
            <input type="password" id="passwordConfirm" name="" value="$password" onblur="PasswordConfirm()">
            <div id="confirmValidation" style = "color:red"></div>
            <input type="submit" name="modifyProfileInformations" class="saveChanges" value="Enregistrer">
        </fieldset>
    </form>
</main>
HTML;
echo "<div id='deleteConfirmReference'></div>";
//---------------------------------------------------------------------------------------------------------------------

include_once $root."master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/administration.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>";
?>