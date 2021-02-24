<?php
echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NavBar</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="navbar.js" defer></script>
</head>
<body>
<header>
    <nav>
        <nav id="index">
            <p onclick="redirect('index.php')"></p>
            Magasin
        </nav>
HTML;
if (!isset($_SESSION["Logged"]) || !$_SESSION["Logged"])
{
    echo <<<HTML
            <nav id="login">
                <p onclick="redirect('login.php')"></p>
                Connexion
            </nav>
            <nav id="register">
                <p onclick="redirect('register.php')"></p>
                Inscription
            </nav>
HTML;
}
else
{
    echo <<<HTML
            <nav id="profile">
                <img src="./Icons/ProfileIcon.png"/>
                <p onclick="redirect('profile.php')"></p>
                Profil
                <ul>
                    <li id="modify" onclick="redirect('modify.php')">
                        Modifier
                    </li>
                    <li id="inventory" onclick="redirect('inventory.php')">
                        Inventaire
                    </li>
                    <li id="logout" onclick="redirect('logout.php')">
                        Déconnexion
                    </li>
                </ul>
            </nav>
            <nav id="shoppingcart" class="IconOnly">
                <img src="./Icons/ShoppingCartIcon.png"/>
                <p onclick="redirect('shoppingcart.php')"></p>
            </nav>
HTML;
}
echo <<<HTML
    </nav>
</header>
HTML;
?>