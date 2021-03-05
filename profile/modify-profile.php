<?php
$root = "../";

include_once $root."master/header.php";

//Exemple d'information reçu de la bd
$myInfosString = "JPaul61, Leblanc, Jean-Paul, 100, Password12345";

$myInfosArray = explode(", ", $myInfosString);
$alias = $myInfosArray[0];
$lastName = $myInfosArray[1];
$firstName = $myInfosArray[2];
$balance = $myInfosArray[3];
$password = $myInfosArray[4];

echo <<<HTML
<main class="modify-profile">
    <h1>Modifier mes informations</h1>
    
    <form action="">
        <fieldset>
            <label for="firstName">Nom</label>
            <input type="text" id="firstName" name="firstName" value="$firstName">
            <label for="lastName">Last name:</label>
            <input type="text" id="lastName" name="lastName" value="$lastName">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="motDePasse" value="$password">
            <label for="passwordConfirm">Confirmation du mot de passe</label>
            <input type="password" id="passwordConfirm" name="" value="$password">
            <input type="submit" value="Submit">
        </fieldset>
    </form>
</main>
HTML;

include_once $root."master/footer.php";

?>