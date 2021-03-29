<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetWeaponById($id)
{
    $records = executeQuery("CALL ArmeParId($id)");
    return count($records) >= 1 ? $records[0] : $records;
}

function AddWeaponStore($name, $quantity, $price, $pictureCode, $type, $efficiency, $gender, $description)
{
    return executeQuery("CALL AjouterArmeMagasin('$name', $quantity, $price, '$pictureCode',
                            '$type', $efficiency, '$gender', '$description')", true)[0];
}