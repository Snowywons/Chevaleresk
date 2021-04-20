<?php
session_start();

$root = "../";

include_once $root . "db/playersDT.php";

$_SESSION["logged"] = false;

if (isset($_POST["submit"])) {
    $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if (PlayerIsAuthenticated($alias, $password)) {
        $records = GetPlayerByAlias($alias);

        $_SESSION["logged"] = true;
        $_SESSION["alias"] = $records[0];
        $_SESSION["lastName"] = $records[1];
        $_SESSION["firstName"] = $records[2];
        $_SESSION["balance"] = $records[3];
        $_SESSION["admin"] = $records[4];
        header("location: " . $root . "store/store.php");
    } else {
        header("location: " . $root . "session/login.php?alias=$alias");
    }
} else {
    header("location: " . $root . "index.php");
}