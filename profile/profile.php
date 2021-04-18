<?php
$root = "../";

include_once $root . "master/header.php";
include_once $root . "utilities/sessionUtilities.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "utilities/popupUtilities.php";
include_once $root . "db/playersDT.php";

//Accès interdit
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false) {
    header("location: ../session/login.php");
    exit;
}

$alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
$targetAlias = isset($_GET["alias"]) ? $_GET["alias"] : $alias;
$isAdmin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : false;

//Accès interdit
if (!$isAdmin && $alias !== $targetAlias) {
    header("location: ../profile/profile.php");
    exit;
}

$records = GetPlayerByAlias($targetAlias);

$alias = "";
$lastName = "";
$firstName = "";
$balance = "";

if (count($records) > 0) {
    $alias = $records[0];
    $lastName = $records[1];
    $firstName = $records[2];
    $balance = $records[3];
}

echo "
    <main class='profile'>
        <h1>Informations du profil</h1>
        <form>
            <fieldset>
                <label for='alias'>Alias</label>
                <input type='text' id='alias' name='alias' value='$alias' disabled>
                <label for='firstName'>Nom</label>
                <input type='text' id='firstName' name='firstName' value='$firstName' disabled>
                <label for='lastName'>Last name:</label>
                <input type='text' id='lastName' name='lastName' value='$lastName' disabled>
                <label for='balance'>Solde (écus)</label>
                <input type='text' id='balance' name='balance' value='$balance' disabled>
            </fieldset>
        </form>
    </main>";
//---------------------------------------------------------------------------------------------------------------------

include_once $root . "master/footer.php";