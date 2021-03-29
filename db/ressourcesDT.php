<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetRessourceById($id)
{
    $records = executeQuery("CALL RessourceParId($id)");
    return count($records) >= 1 ? $records[0] : $records;
}

function AddRessourceStore($name, $quantity, $price, $pictureCode, $type, $description)
{
    return executeQuery("CALL AjouterRessourceMagasin('$name', $quantity, $price, '$pictureCode',
                                                        '$type', '$description')", true)[0];
}