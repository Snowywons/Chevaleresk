<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetPotionById($id)
{
    //$records = executeQuery("CALL PotionParId($id)");
    //return count($records) >= 1 ? $records[0] : $records;
    global $conn;
    
    $statement = $conn->prepare("CALL PotionParId(?)");
    $statement->bindParam(1,$id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result;
    }
    return [];
}

function AddPotionStore($name, $quantity, $price, $pictureCode, $type, $effect, $duration)
{
    //return executeQuery("CALL AjouterPotionMagasin('$name', $quantity, $price, '$pictureCode',
                                                        //'$type', '$effect', $duration)", true)[0];
    global $conn;

    $statement = $conn->prepare("CALL AjouterPotionMagasin(?, ?, ?, ?, ?, ?, ?)");
    $statement->bindParam(1,$name, PDO::PARAM_STR);
    $statement->bindParam(2,$quantity, PDO::PARAM_INT);
    $statement->bindParam(3,$price, PDO::PARAM_INT);
    $statement->bindParam(4,$pictureCode, PDO::PARAM_STR);
    $statement->bindParam(5,$type, PDO::PARAM_STR);
    $statement->bindParam(6,$effect, PDO::PARAM_STR);
    $statement->bindParam(7,$duration, PDO::PARAM_STR);
    $statement->execute();                                                    
}

function updatePotionById($idItem, $effet, $duree)
{
    global $conn;
    $potion = GetPotionById($idItem);
    $query = "";
    if(!empty($potion))
        $query = "update Potions set effetPotion=?, dureePotion=? where idItem=?";
    else
        $query = "insert into Potions (effetPotion, dureePotion, idItem) values (?, ?, ?)";

    $statement = $conn->prepare($query);
    $statement->bindParam(1,$effet, PDO::PARAM_STR);
    $statement->bindParam(2,$duree, PDO::PARAM_STR);
    $statement->bindParam(3,$idItem, PDO::PARAM_STR);
    $statement->execute();
}