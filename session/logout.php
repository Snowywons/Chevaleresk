<?php
session_start();

$root = "../";

unset($_SESSION["Logged"]);
header("location: ".$root."session/login.php");
