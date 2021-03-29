<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetFilteredItems($filter)
{
    return executeQuery("CALL ItemsParFiltre($filter)");
}

function GetItemById($id)
{
    $records = executeQuery("CALL ItemParId($id)");
    return count($records) >= 1 ? $records[0] : $records;
}

function GetAllItems()
{
    return executeQuery("CALL Items()");
}

function DeleteItemFromStoreById($idItem)
{
    return executeQuery("CALL SupprimerItemMagasinParId($idItem)", true)[0];
}