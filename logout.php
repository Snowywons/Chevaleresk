<?php
include_once "sessionCheck.php";

unset($_SESSION["Logged"]);
header("location: index.php");