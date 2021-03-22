<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetArmorById($id)
{
    $records = executeQuery("CALL ArmureParId($id)");
    return count($records) >= 1 ? $records[0] : $records;
}