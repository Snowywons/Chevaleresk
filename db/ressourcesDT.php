<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetRessourceById($id)
{
    $records = executeQuery("CALL RessourceParId($id)");
    return count($records) >= 1 ? $records[0] : $records;
}