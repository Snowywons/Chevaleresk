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
    //$records = executeQuery("CALL ItemParId($id)");
    //return count($records) >= 1 ? $records[0] : $records;
    global $conn;
    
    $statement = $conn->prepare("CALL ItemParId(?)");
    $statement->bindParam(1,$id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result;
    }
    return [];
}

function GetAllItems()
{
    return executeQuery("CALL Items()");
}

function DeleteItemFromStoreById($idItem)
{
    //return executeQuery("CALL SupprimerItemMagasinParId($idItem)", true)[0];
    global $conn;
    
    $statement = $conn->prepare("CALL SupprimerItemMagasinParId(?)");
    $statement->bindParam(1,$idItem, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result;
    }
    return [];
}