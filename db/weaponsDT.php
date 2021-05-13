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

function UpdateWeaponById($idItem, $efficacite, $genres, $description)
{
    global $conn;
    $weapon = GetWeaponById($idItem);
    $query = "";
    if(!empty($weapon))
        $query = "update Armes set efficaciteArme=?, genreArme=?, descArme=? where idItem=?";
    else
        $query = "insert into Armes (efficaciteArme, genreArme, descArme, idItem) values (?, ?, ?, ?)";

    $statement = $conn->prepare($query);
    $statement->bindParam(1,$efficacite, PDO::PARAM_STR);
    $statement->bindParam(2,$genres, PDO::PARAM_STR);
    $statement->bindParam(3,$description, PDO::PARAM_STR);
    $statement->bindParam(4,$idItem, PDO::PARAM_STR);
    $statement->execute();
}

function DeleteWeaponById($idItem)
{
    global $conn;
    $query = "DELETE FROM Armes WHERE idItem=?";

    $statement = $conn->prepare($query);
    $statement->bindParam(1,$idItem, PDO::PARAM_INT);
    $statement->execute();
}