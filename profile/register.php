<?php
$root = "../";

include_once $root."master/header.php";

//Exemple d'information envoyé à la bd
$myInfosString = "JPaul61, Leblanc, Jean-Paul, 100, Password12345";

//$picture = "";
$alias = "";
$firstName = "";
$lastName = "";

//Récupérer les informations du client (sauf pdw) en cas d'invalidité du formulaire
//if (isset($_POST["photoJoueur"]))
//    $picture = $_POST["photoJoueur"];
if (isset($_POST["aliasJoueur"]))
    $alias = $_POST["aliasJoueur"];
if (isset($_POST["nomJoueur"]))
    $firstName = $_POST["nomJoueur"];
if (isset($_POST["prenomJoueur"]))
    $lastName = $_POST["prenomJoueur"];

    

echo <<<HTML
<main class="register">
    <h1>Inscription</h1>
    
    <form action="register.php" method="post">
        <fieldset>
            <label for="alias">Alias</label>
            <input type="text" id="alias" name="aliasJoueur" value="$alias" onblur="notEmpty('alias')">
            <div id="aliasValidation" style="color:red"></div>
            <label for="lastName">Nom</label>
            <input type="text" id="lastName" name="nomJoueur" value="$lastName" onblur="notEmpty('lastName')">
            <div id="lastNameValidation" style = "color:red"></div>
            <label for="firstName">Prenom</label>
            <input type="text" id="firstName" name="prenomJoueur" value="$firstName" onblur="notEmpty('firstName')">
            <div id="firstNameValidation" style = "color:red"></div>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="motDePasse" value="" onblur="notEmpty('password')">
            <div id="passwordValidation" style = "color:red"></div>
            <label for="passwordConfirm">Confirmation du mot de passe</label>
            <input type="password" id="passwordConfirm" name="" value="" onblur="PasswordConfirm()">
            <div id="confirmValidation" style = "color:red"></div>
            <input type="submit" value="Enregistrer">
        </fieldset>
    </form>
</main>
HTML;

include_once $root."master/footer.php";

?>