<?php
session_start();

$root = "../";

$_SESSION["Logged"] = true;
header("location: ".$root."store/store.php");