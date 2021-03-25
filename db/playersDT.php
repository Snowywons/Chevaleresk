<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetPlayerByAlias($alias)
{  
    $records = executeQuery("CALL JoueurParAlias('$alias')");
    return count($records) >= 1 ? $records[0] : NULL;
}

function CreatePlayer($alias, $firstName, $lastName, $password)
{
    executeQuery("CALL InscrireNouveauJoueur('$alias', '$lastName', '$firstName', '$password')");
}