<?php
global $root;
global $script;

include_once $root . "utilities/sessionUtilities.php";

$indexPageLink = $root . "index.php";

$storePageLink = $root . "store/store.php";
$addItemPageLink = $root . "store/add-item.php";
$modifyItemPageLink = $root . "store/modify-item.php";
$deleteItemPageLink = $root . "store/delete-item.php";
$shoppingCartPageLink = $root . "store/shopping-cart.php";

$evaluationsPageLink = $root . "evaluations/evaluations.php";

$loginPageLink = $root . "session/login.php";
$logoutPageLink = $root . "session/logout.php";

$profilePageLink = $root . "profile/profile.php";
$administrationPageLink = $root . "profile/administration.php";
$modifyProfilePageLink = $root . "profile/modify-profile.php";
$inventoryPageLink = $root . "profile/inventory.php";
$registerPageLink = $root . "profile/register.php";

echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Chevaleresk</title>
    <link rel='stylesheet' type='text/css' href='" . $root . "css/style.css'>
    <script type='text/javascript' src='" . $root . "js/functions.js'></script>
    <script type='text/javascript' src='" . $root . "js/navbar.js' defer></script>";
if(isset($script)) {
    echo "<script type='text/javascript' src='" . $root . $script . "'></script>";
}
echo "
</head>
<body>
<header>
    <nav>
        <nav class='title'>
            <img src='" . $root . "icons/ChevalereskIcon.png'>";

//Onglets par défaut
echo <<<HTML
            <p onclick="redirect('$indexPageLink')"></p>
            Chevaleresk
        </nav>
        <nav id="index">
            <p onclick="redirect('$indexPageLink')"></p>
            Accueil
        </nav>
        <nav id="store">
            <p onclick="redirect('$storePageLink')"></p>
            Magasin
            <ul class="hidden">
                <li id="add-item" onclick="redirect('$addItemPageLink')">
                    Ajouter
                </li>
                <li id="modify-item" onclick="redirect('$modifyItemPageLink')">
                    Modifier
                </li>
                <li id="delete-item" onclick="redirect('$deleteItemPageLink')">
                    Supprimer
                </li>
            </ul>
        </nav>
        <nav id="evaluations">
            <p onclick="redirect('$evaluationsPageLink')"></p>
            Évaluations
        </nav>
HTML;

//Onglets si l'usager N'EST PAS connecté
if (!UserIsLogged()) {
    echo <<<HTML
            <nav id="login">
                <p onclick="redirect('$loginPageLink')"></p>
                Connexion
            </nav>
            <nav id="register">
                <p onclick="redirect('$registerPageLink')"></p>
                Inscription
            </nav>
HTML;
} else //Onglets si l'usager EST connecté
{
    //Onglets si l'usager EST un administrateur
    if (UserIsAdmin()) {

        echo <<<HTML
        <nav id="administration">
            <p onclick="redirect('$administrationPageLink')"></p>
            Administration
        </nav>
HTML;
    }

    echo <<<HTML
        <nav id="profile">
            <p onclick="redirect('$profilePageLink')"></p>
            Profil
            <ul>
                <li id="modify-profile" onclick="redirect('$modifyProfilePageLink')">
                    Modifier
                </li>
                <li id="inventory" onclick="redirect('$inventoryPageLink')">
                    Inventaire
                </li>
                <li id="logout" onclick="redirect('$logoutPageLink')">
                    Déconnexion
                </li>
            </ul>
        </nav>
        <nav id="shopping-cart" class="iconOnly">
HTML;
    echo "<img src='". $root . "icons/ShoppingCartIcon.png'/>";
    echo <<<HTML
            <p onclick="redirect('$shoppingCartPageLink')"></p>
        </nav>
HTML;
}
echo <<<HTML
    </nav>
</header>
HTML;
?>