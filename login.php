<?php
include_once "sessionCheck.php";
include_once "header.php";

//Exemple d'information reçu de la bd


$alias = isset($_GET["alias"]) ? $_GET["alias"] : "";

echo <<<HTML
<main class="loginPage">
    <h1>Connexion</h1>
    
    <form action="./loginCheck.php">
        <fieldset>
            <label for="alias">Alias</label>
            <input type="text" id="alias" name="alias" value="$alias">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="motDePasse" value="">
            <input type="submit" value="Submit">
        </fieldset>
    </form>
    <a href="./register.php">S'inscrire</a>
</main>
HTML;

include_once "footer.php";