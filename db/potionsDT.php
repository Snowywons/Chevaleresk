<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetPotionById($id)
{
    $records = executeQuery("CALL PotionParId($id)");
    return count($records) >= 1 ? $records[0] : $records;
}