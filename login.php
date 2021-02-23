<?php
include_once "sessionCheck.php";

$_SESSION["Logged"] = true;
header("location: index.php");