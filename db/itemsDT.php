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
    global $conn;
    
    $statement = $conn->prepare("CALL ItemParId(?)");
    $statement->bindParam(1,$id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    if ($result)
        return $result;
    return [];
}

function GetAllItems()
{
    return executeQuery("CALL Items()");
}

function DeleteItemFromStoreById($idItem)
{
    global $conn;
    
    $statement = $conn->prepare("CALL SupprimerItemMagasinParId(?)");
    $statement->bindParam(1,$idItem, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();

    return count($result) > 0 ? $result[0] : "";
}