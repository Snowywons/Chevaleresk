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
function GetItemByName($name){
    global $conn;
    
    $statement = $conn->prepare("CALL ItemParNom(?)");
    $statement->bindParam(1,$name, PDO::PARAM_STR);
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

function UpdateItemById($idItem, $nomItem, $codeType, $quantiteStock, $prixItem)
{
    global $conn;
    $statement = $conn->prepare("update Items set nomItem=?, quantiteStock=?, prixItem=?, codeType=? where idItem=?");
    $statement->bindParam(1,$nomItem, PDO::PARAM_STR);
    $statement->bindParam(2,$quantiteStock, PDO::PARAM_INT);
    $statement->bindParam(3,$prixItem, PDO::PARAM_INT);
    $statement->bindParam(4,$codeType, PDO::PARAM_STR);
    $statement->bindParam(5,$idItem, PDO::PARAM_INT);
    $statement->execute(); 
}
function UpdatePictureItemById($idItem, $codePhoto)
{
    global $conn;
    $statement = $conn->prepare("update Items set codePhoto=? where idItem=?");
    $statement->bindParam(1,$codePhoto, PDO::PARAM_STR);
    $statement->bindParam(2,$idItem, PDO::PARAM_STR);
    $statement->execute(); 
}