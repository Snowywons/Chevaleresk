<?php
$root = "../";

include_once $root . "master/header.php";

if (isset($_GET["alias"])){
    $alias = $_GET["alias"];
    $loginError = "Les informations de connexion ne sont pas valides.";
}
else {
    $loginError = "";
    $alias = "";
} 

echo <<<HTML
<main class='login'>
    <h1>Connexion</h1>
    
    <form method='POST' action='./login-validate.php'>
        <fieldset>
            <div id='loginError' style='color:red'>$loginError</div>
            <label for='alias'>Alias</label>
            <input type='text' id='alias' name='alias' value='$alias'>
            <label for='password'>Mot de passe</label>
            <input type='password' id='password' name='password' value=''>
            <input type='submit' name='submit' value='Connecter'>
        </fieldset>
    </form>
HTML;
   echo "<a href='" . $root . "profile/register.php'>S'inscrire</a>
</main>";


include_once $root . "master/footer.php";