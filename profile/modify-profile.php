<?php
$root = "../";

include_once $root . "master/header.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "db/playersDT.php";

//Accès interdit
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false) {
    header("location: ../session/login.php");
    exit;
}

$alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
$targetAlias = isset($_GET["alias"]) ? $_GET["alias"] : $alias;
$isAdmin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : false;

//Accès interdit
if (!$isAdmin && $alias !== $targetAlias) {
    header("location: ../profile/profile.php");
    exit;
}

$records = GetPlayerByAlias($targetAlias);

$lastName = "";
$firstName = "";
$balance = "";
$password = "";

if (count($records) > 0) {
    $alias = $records[0];
    $lastName = $records[1];
    $firstName = $records[2];
    $balance = $records[3];
    $password = "default";
}

echo "
    <main class='modify-profile'>
        <h1>Modifier les informations</h1>
        
        <form action='modify-profile.php' method='POST'>
            <fieldset>
                <input type='text' id='alias' value='$alias' hidden disabled>
                
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
                <input type='password' id='password' name='password' value='$password' onblur='validateNotEmpty(\"password\")'>
    
                <label for='passwordConfirm'>
                    <span>Confirmation du mot de passe</span>
                    <abbr title='Obligatoire' style='color:red'>*</abbr>
                </label>
                <input type='password' id='passwordConfirm' name='passwordConfirm' value='$password' onblur='validatePassword()'>
                <div id='passwordConfirmValidation' style='color:red'></div>
                <input type='submit' name='submit' value='Enregistrer' class='saveChanges'>
            </fieldset>
        </form>
    </main>";
//---------------------------------------------------------------------------------------------------------------------

include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/administration.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/register.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/popups.js' defer></script>";
?>