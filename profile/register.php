<?php
$root = "../";

include_once $root . "db/playersDT.php";

$alias = "";
$firstName = "";
$lastName = "";
$aliasError = "";

if (isset($_POST["submit"])) {
    $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";
    $firstName = isset($_POST["lastName"]) ? $_POST["lastName"] : "";
    $lastName = isset($_POST["firstName"]) ? $_POST["firstName"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $passwordConfirm = isset($_POST["passwordConfirm"]) ? $_POST["passwordConfirm"] : "";

    if ($alias && $firstName && $lastName &&
        $password && $passwordConfirm &&
        $password === $passwordConfirm) {
            if(count(GetPlayerByAlias($alias)) == 0){
                CreateNewPlayer($alias, $firstName, $lastName, $password);
                header("location: ../session/login.php");
                exit;
            }
            $aliasError= "Nom d'utilisateur non-disponible.";
    }
}

include_once $root . "master/header.php";

echo "
    <main class='register'>
        <span data-shadow=\"" ."Inscription" . "\" class='pageTitle'
        style='left: 50%;transform: translateX(-60%)'>Inscription</span>
        <br><br>
        
        <form action='register.php' method='post' onsubmit='return validateRegisterForm()'>
            <fieldset>
                <label for='alias'>
                    <span>Alias</span>
                    <abbr title='Obligatoire' style='color:red'>*</abbr>
                </label>
                <input type='text' id='alias' name='alias' value='$alias' onblur='validateAlias()'>
                <div id='aliasValidation' style='color:red'>$aliasError</div>
    
                <label for='lastName'>
                    <span>Nom</span>
                    <abbr title='Obligatoire' style='color:red'>*</abbr>            
                </label>
                <input type='text' id='lastName' name='lastName' value='$lastName' onblur='validateLastName()'>
                <div id='lastNameValidation' style='color:red'></div>
    
                <label for='firstName'>
                    <span>Prenom</span>
                    <abbr title='Obligatoire' style='color:red'>*</abbr>
                </label>
                <input type='text' id='firstName' name='firstName' value='$firstName' onblur='validateFirstName()'>
                <div id='firstNameValidation' style='color:red'></div>
    
                <label for='password'>
                    <span>Mot de passe</span>
                    <abbr title='Obligatoire' style='color:red'>*</abbr>
                </label>
                <input type='password' id='password' name='password' onblur='validateNotEmpty(\"password\")'>
    
                <label for='passwordConfirm'>
                    <span>Confirmation du mot de passe</span>
                    <abbr title='Obligatoire' style='color:red'>*</abbr>
                </label>
                <input type='password' id='passwordConfirm' name='passwordConfirm' onblur='validatePassword()'>
                <div id='passwordConfirmValidation' style='color:red'></div>
                <input type='submit' name='submit' value='Enregistrer'>
            </fieldset>
        </form>
        <a href='" . $root . "session/login.php'>Se connecter</a>
    </main>";

echo "<script type='text/javascript' src='" . $root . "js/register.js' defer></script>";

include_once $root . "master/footer.php";
?>