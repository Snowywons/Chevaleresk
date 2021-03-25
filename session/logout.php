<?php
session_start();

$root = "../";

unset($_SESSION["logged"]);
unset($_SESSION["filters"]);
unset($_SESSION["alias"]);
unset($_SESSION["lastName"]);
unset($_SESSION["firstName"]);
unset($_SESSION["balance"]);
unset($_SESSION["admin"]);

header("location: ".$root."session/login.php");
