<?php
global $root;

include_once $root . "utilities/sessionUtilities.php";
include_once $root . "utilities/popupUtilities.php";

$indexPageLink = $root . "index";

$storePageLink = $root . "store/store";
$addItemPageLink = $root . "store/add-item";
$modifyItemPageLink = $root . "store/modify-item";
$deleteItemPageLink = $root . "store/delete-item";
$shoppingCartPageLink = $root . "store/shopping-cart";

$evaluationsPageLink = $root . "evaluations/evaluations";

$loginPageLink = $root . "session/login";
$logoutPageLink = $root . "session/logout";

$profilePageLink = $root . "profile/profile";
$administrationPageLink = $root . "profile/administration";
$modifyProfilePageLink = $root . "profile/modify-profile";
$inventoryPageLink = $root . "profile/inventory";
$registerPageLink = $root . "profile/register";

echo "
    <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>Chevaleresk</title>
            <link rel='stylesheet' type='text/css' href='" . $root . "css/style.css'>
            <script type='text/javascript' src='" . $root . "js/functions.js'></script>
            <script type='text/javascript' src='" . $root . "js/navbar.js' defer></script>
            <script type='text/javascript' src='" . $root . "js/jquery-3.6.0.min.js'></script>
            <script type='text/javascript' src='" . $root . "js/jquery.validate.min.js'></script>
            <script type='text/javascript' src='" . $root . "js/additional-methods.min.js'></script>";

CreateOverlay();

    echo "
        </head>
        <body>
        <header>
            <nav>
                <nav class='title'>";

//Onglets par défaut
echo <<<HTML
            <p onclick="Redirect('$indexPageLink')"></p>
            Chevaleresk
        </nav>
        <nav id="index">
            <p onclick="Redirect('$indexPageLink')"></p>
            Accueil
        </nav>
        <nav id="store">
            <p onclick="Redirect('$storePageLink')"></p>
            Magasin
            <ul class="hidden">
                <li id="add-item" onclick="Redirect('$addItemPageLink')">
                    Ajouter
                </li>
                <li id="modify-item" onclick="Redirect('$modifyItemPageLink')">
                    Modifier
                </li>
                <li id="delete-item" onclick="Redirect('$deleteItemPageLink')">
                    Supprimer
                </li>
            </ul>
        </nav>
        <nav id="evaluations">
            <p onclick="Redirect('$evaluationsPageLink')"></p>
            Évaluations
        </nav>
HTML;

//Onglets si l'usager N'EST PAS connecté
if (!UserIsLogged()) {
    echo <<<HTML
            <nav id="login">
                <p onclick="Redirect('$loginPageLink')"></p>
                Connexion
            </nav>
            <nav id="register">
                <p onclick="Redirect('$registerPageLink')"></p>
                Inscription
            </nav>
HTML;
} else //Onglets si l'usager EST connecté
{
    //Onglets si l'usager EST un administrateur
    if (UserIsAdmin()) {

        echo <<<HTML
        <nav id="administration">
            <p onclick="Redirect('$administrationPageLink')"></p>
            Administration
        </nav>
HTML;
    }

    echo <<<HTML
        <nav id="profile">
            <p onclick="Redirect('$profilePageLink')"></p>
            Profil
            <ul>
                <li id="modify-profile" onclick="Redirect('$modifyProfilePageLink')">
                    Modifier
                </li>
                <li id="inventory" onclick="Redirect('$inventoryPageLink')">
                    Inventaire
                </li>
                <li id="logout" onclick="Redirect('$logoutPageLink')">
                    Déconnexion
                </li>
            </ul>
        </nav>
        <nav id="shopping-cart" class="iconOnly">
HTML;
    echo "<img src='". $root . "icons/ShoppingCartIcon.png'/>";
    echo <<<HTML
            <p onclick="Redirect('$shoppingCartPageLink')"></p>
        </nav>
HTML;
}
echo <<<HTML
    </nav>
</header>
HTML;
?>