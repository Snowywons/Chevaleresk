<?php
session_start();

$root = "../";

unset($_SESSION["logged"]);
unset($_SESSION["admin"]);
unset($_SESSION["filters"]);

header("location: ".$root."session/login.php");
