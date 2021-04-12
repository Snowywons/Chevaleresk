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

$alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
$targetAlias = isset($_GET["alias"]) ? $_GET["alias"] : $alias;
$isAdmin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : false;

//Accès interdit
if (!$isAdmin && $alias !== $targetAlias) {
    header("location: ../profile/profile.php");
    exit;
}

if(isset($_POST['alias']) && isset($_POST['balance'])) {
    ModifyPlayerBalanceByAlias($_POST['alias'], $_POST['balance']);
}

header("location: administration.php");
?>