<?php
$root = "../";

include_once $root . "db/playersDT.php";

$alias = "";
$firstName = "";
$lastName = "";

if (isset($_POST["submit"])) {
    $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";
    $firstName = isset($_POST["lastName"]) ? $_POST["lastName"] : "";
    $lastName = isset($_POST["firstName"]) ? $_POST["firstName"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $passwordConfirm = isset($_POST["passwordConfirm"]) ? $_POST["passwordConfirm"] : "";

    if ($alias && $firstName && $lastName &&
        $password && $passwordConfirm &&
        $password === $passwordConfirm &&
        count(GetPlayerByAlias($alias)) == 0) {
        CreateNewPlayer($alias, $firstName, $lastName, $password);
        header("location: ../session/login.php");
        exit;
    }
}

include_once $root . "master/header.php";

echo <<<HTML
<main class="register">
    <h1>Inscription</h1>
    
    <form action="register.php" method="post">
        <fieldset>
            <label for="alias">Alias</label>
            <input type="text" id="alias" name="alias" value="$alias" onblur="notEmpty('alias')">
            <div id="aliasValidation" style="color:red"></div>
            <label for="lastName">Nom</label>
            <input type="text" id="lastName" name="lastName" value="$lastName" onblur="notEmpty('lastName')">
            <div id="lastNameValidation" style = "color:red"></div>
            <label for="firstName">Prenom</label>
            <input type="text" id="firstName" name="firstName" value="$firstName" onblur="notEmpty('firstName')">
            <div id="firstNameValidation" style = "color:red"></div>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" value="" onblur="notEmpty('password')">
            <div id="passwordValidation" style = "color:red"></div>
            <label for="passwordConfirm">Confirmation du mot de passe</label>
            <input type="password" id="passwordConfirm" name="passwordConfirm" value="" onblur="PasswordConfirm()">
            <div id="confirmValidation" style = "color:red"></div>
            <input type="submit" name="submit" value="Enregistrer">
        </fieldset>
    </form>
</main>
HTML;

include_once $root . "master/footer.php";
?>