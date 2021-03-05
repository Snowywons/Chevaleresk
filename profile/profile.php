<?php
if (!defined("ROOT"))
    define("ROOT", $_SERVER['DOCUMENT_ROOT']."/Chevaleresk/");

$root = "../";

include_once $root."master/header.php";
include_once $root."utilities/dbUtilities.php";

global $conn;

$records = executeQuery("SELECT * FROM Joueurs;");

//Exemple d'information reçu de la bd
$myInfosString = "JPaul61, Leblanc, Jean-Paul, 100, Password12345";

$myInfosArray = explode(", ", $myInfosString);
$alias = $myInfosArray[0];
$lastName = $myInfosArray[1];
$firstName = $myInfosArray[2];
$balance = $myInfosArray[3];

echo <<<HTML
    <main class='profile'>
        <h1>Mes informations</h1>
        <form action="">
            <fieldset>
                <label for="alias">Alias</label>
                <input type="text" id="alias" name="alias" value="$alias" disabled>
                <label for="firstName">Nom</label>
                <input type="text" id="firstName" name="firstName" value="$firstName" disabled>
                <label for="lastName">Last name:</label>
                <input type="text" id="lastName" name="lastName" value="$lastName" disabled>
                <label for="balance">Solde</label>
                <input type="text" id="balance" name="balance" value="$balance" disabled>
            </fieldset>
        </form>
    </main>
HTML;

include_once $root."master/footer.php";

?>