<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetArmorById($id)
{
    $records = executeQuery("CALL ArmureParId($id)");
    return count($records) >= 1 ? $records[0] : $records;
}

function AddArmorStore($name, $quantity, $price, $pictureCode, $type, $material, $weigth, $size)
{
    return executeQuery("CALL AjouterArmureMagasin('$name', $quantity, $price, '$pictureCode',
                            '$type', '$material', $weigth, '$size')", true)[0];
}