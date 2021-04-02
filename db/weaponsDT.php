<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetWeaponById($id)
{
    //$records = executeQuery("CALL ArmeParId($id)");
    //return count($records) >= 1 ? $records[0] : $records;
    global $conn;
    
    $statement = $conn->prepare("CALL ArmeParId(?)");
    $statement->bindParam(1,$id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result;
    }
    return [];
}

function AddWeaponStore($name, $quantity, $price, $pictureCode, $type, $efficiency, $gender, $description)
{
    //return executeQuery("CALL AjouterArmeMagasin('$name', $quantity, $price, '$pictureCode',
                           // '$type', $efficiency, '$gender', '$description')", true)[0];
    global $conn;

    $statement = $conn->prepare("CALL AjouterArmeMagasin(?, ?, ?, ?, ?, ?, ?, ?)");
    $statement->bindParam(1,$name, PDO::PARAM_STR);
    $statement->bindParam(2,$quantity, PDO::PARAM_INT);
    $statement->bindParam(3,$price, PDO::PARAM_INT);
    $statement->bindParam(4,$pictureCode, PDO::PARAM_STR);
    $statement->bindParam(5,$type, PDO::PARAM_STR);
    $statement->bindParam(6,$efficiency, PDO::PARAM_STR);
    $statement->bindParam(7,$gender, PDO::PARAM_STR);
    $statement->bindParam(8,$description, PDO::PARAM_STR);
    $statement->execute();
}