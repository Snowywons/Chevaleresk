<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetRessourceById($id)
{
    //$records = executeQuery("CALL RessourceParId($id)");
    //return count($records) >= 1 ? $records[0] : $records;
    global $conn;
    
    $statement = $conn->prepare("CALL RessourceParId(?)");
    $statement->bindParam(1,$id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result;
    }
    return [];
}

function AddRessourceStore($name, $quantity, $price, $pictureCode, $type, $description)
{
    //return executeQuery("CALL AjouterRessourceMagasin('$name', $quantity, $price, '$pictureCode',
                                                        //'$type', '$description')", true)[0];
    global $conn;

    $statement = $conn->prepare("CALL AjouterRessourceMagasin(?, ?, ?, ?, ?, ?)");
    $statement->bindParam(1,$name, PDO::PARAM_STR);
    $statement->bindParam(2,$quantity, PDO::PARAM_INT);
    $statement->bindParam(3,$price, PDO::PARAM_INT);
    $statement->bindParam(4,$pictureCode, PDO::PARAM_STR);
    $statement->bindParam(5,$type, PDO::PARAM_STR);
    $statement->bindParam(6,$description, PDO::PARAM_STR);
    $statement->execute();
}