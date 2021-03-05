<?php
$root = "../";

include_once $root."master/header.php";

$alias = isset($_GET["alias"]) ? $_GET["alias"] : "";

echo "
<main class='login'>
    <h1>Connexion</h1>
    
    <form action='./login-validate.php'>
        <fieldset>
            <label for='alias'>Alias</label>
            <input type='text' id='alias' name='alias' value='$alias'>
            <label for='password'>Mot de passe</label>
            <input type='password' id='password' name='motDePasse' value=''>
            <input type='submit' value='Connecter'>
        </fieldset>
    </form>
    <a href='" .$root."profile/register.php'>S'inscrire</a>
</main>";

include_once $root."master/footer.php";