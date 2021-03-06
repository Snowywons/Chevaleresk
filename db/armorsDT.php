<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetArmorById($id)
{
    //$records = executeQuery("CALL ArmureParId($id)");
    //return count($records) >= 1 ? $records[0] : $records;
    global $conn;
    
    $statement = $conn->prepare("CALL ArmureParId(?)");
    $statement->bindParam(1,$id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result;
    }
    return [];
}

function AddArmorStore($name, $quantity, $price, $pictureCode, $type, $material, $weight, $size)
{
    global $conn;

    $statement = $conn->prepare("CALL AjouterArmureMagasin(?, ?, ?, ?, ?, ?, ?, ?)");
    $statement->bindParam(1,$name, PDO::PARAM_STR);
    $statement->bindParam(2,$quantity, PDO::PARAM_INT);
    $statement->bindParam(3,$price, PDO::PARAM_INT);
    $statement->bindParam(4,$pictureCode, PDO::PARAM_STR);
    $statement->bindParam(5,$type, PDO::PARAM_STR);
    $statement->bindParam(6,$material, PDO::PARAM_STR);
    $statement->bindParam(7,$weight, PDO::PARAM_STR);
    $statement->bindParam(8,$size, PDO::PARAM_STR);
    $statement->execute();
}

function UpdateArmorById($idItem, $matiereArmure, $poidsArmure, $tailleArmure)
{
    global $conn;
    $armor = GetArmorById($idItem);
    $query = "";
    if(!empty($armor))
        $query = "update Armures set matiereArmure=?, poidsArmure=?, tailleArmure=? where idItem=?";
    else
        $query = "insert into Armures (matiereArmure, poidsArmure, tailleArmure, idItem) values (?, ?, ?, ?)";

    $statement = $conn->prepare($query);
    $statement->bindParam(1,$matiereArmure, PDO::PARAM_STR);
    $statement->bindParam(2,$poidsArmure, PDO::PARAM_STR);
    $statement->bindParam(3,$tailleArmure, PDO::PARAM_STR);
    $statement->bindParam(4,$idItem, PDO::PARAM_STR);
    $statement->execute();
}

function DeleteArmorById($idItem)
{
    global $conn;
    $query = "DELETE FROM Armures WHERE idItem=?";

    $statement = $conn->prepare($query);
    $statement->bindParam(1,$idItem, PDO::PARAM_INT);
    $statement->execute();
}