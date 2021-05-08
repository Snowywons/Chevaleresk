<?php
$root = "../";
$script = "js/register.js";

include_once $root . "master/header.php";

$alias = "";
$aliasError = "";

if (isset($_GET["alias"])){
    $alias = $_GET["alias"];
    $loginError = "Les informations de connexion ne sont pas valides.";
}
else {
    $loginError = "";
    $alias = "";
} 

echo "
<main class='login'>
    <span data-shadow=\"" ."Connexion" . "\" class='pageTitle'>Connexion</span>
    <br><br>";

if ($loginError) {
    echo "<div id='loginError' style='color:red'>$loginError</div><br>";
}

    echo "
        <form action='./login-validate.php' method='POST' onsubmit='return validateLoginForm()'>
            <fieldset>
                <label for='alias'>
                    <span>Alias</span>
                    <abbr title='Obligatoire' style='color:red'>*</abbr>
                </label>
                <input type='text' id='alias' name='alias' value='$alias' onblur='validateAlias()'>
                
                <label for='password'>
                    <span>Mot de passe</span>
                    <abbr title='Obligatoire' style='color:red'>*</abbr>
                </label>
                <input type='password' id='password' name='password' value='' onblur='validateNotEmpty(\"password\")'>
                <input type='submit' name='submit' value='Connecter'>
            </fieldset>
        </form>
       <a href='" . $root . "profile/register.php'>S'inscrire</a>
    </main>";

echo "<script type='text/javascript' src='" . $root . "js/register.js' defer></script>";


include_once $root . "master/footer.php";