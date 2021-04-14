<?php
$root = "../";

include_once $root . "utilities/sessionUtilities.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "db/playersDT.php";

//Accès interdit
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false) {
    header("location: ../session/login.php");
    exit;
}

$isAdmin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : false;

//Accès interdit
if (!$isAdmin) {
    header("location: ../profile/profile.php");
    exit;
}

if(isset($_POST["alias"])){
    DeletePlayerByAlias($_POST["alias"]);
}

header("location: ../profile/administration.php");
?>