<?php
include_once "sessionCheck.php";
include_once "header.php";

//Exemple d'information reçu de la bd
$myInfosString = "JPaul61, Leblanc, Jean-Paul, 100, Password12345";

$myInfosArray = explode(", ", $myInfosString);
$alias = $myInfosArray[0];
$lastName = $myInfosArray[1];
$firstName = $myInfosArray[2];
$balance = $myInfosArray[3];

echo <<<HTML
<main class="modifyPage">
    <h1>Modifier mes informations</h1>
    
    <form action=""">
        <fieldset>
            <label for="firstName">Nom</label>
            <input type="text" id="firstName" name="firstName" value="$firstName">
            <label for="lastName">Last name:</label>
            <input type="text" id="lastName" name="lastName" value="$lastName">
            <input type="submit" value="Submit">
        </fieldset>
    </form>
</main>
HTML;

include_once "footer.php";
?>