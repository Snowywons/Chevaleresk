<?php
session_start();

$root = "../";

$_SESSION["logged"] = true;
$_SESSION["admin"] = true;
$_SESSION["filters"] = "'AR','AM','PO','RS'";

header("location: ".$root."store/store.php");