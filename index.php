<?php

//var_dump($_SERVER['DOCUMENT_ROOT']);echo "<br>"; //<--------------------------- "/var/www/html"
//var_dump(__DIR__);echo "<br>"; //<------------------------------------ "/home/chevaleresk13/public_html"
//var_dump(__FILE__);echo "<br>"; //<----------------------------------- "/home/chevaleresk13/public_html/index.php"

$root = "./";

include_once $root . "master/header.php";

echo "
<main class='index'>
    <h1>Chevaleresk… des items pour des chevaliers…</h1>
    <img src='" . $root . "icons/ChevalereskIcon.png'>
    <div>Bienvenue sur votre site favori d'échange d'items médiévales.
    Inscrivez-vous ou connectez-vous pour profiter de toutes les fonctionnalités du site!</div>
</main>";

include_once $root . "master/footer.php";

?>
