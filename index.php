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
    <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
    At consequuntur ducimus ratione similique totam. A amet atque dolorem ea, eius fuga harum 
    illum impedit, iste iusto molestias sunt, suscipit ut!</div>
</main>";

include_once $root . "master/footer.php";

?>
