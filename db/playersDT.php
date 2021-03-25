<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

<<<<<<< HEAD
function RegisterNewPlayer($alias, $lastName, $firstName, $password)
{
    executeQuery("CALL InscrireNouveauJoueur('$alias', '$lastName', '$firstName', '$password')");
}

function PlayerByAlias($alias)
{
    return executeQuery("CALL JoueurParAlias('$alias')", true);
}

function PlayerIsAuthenticated($alias, $password)
{
    return executeQuery("SELECT JoueurEstAuthentifie('$alias', '$password')", true)[0];
=======
function GetPlayerByAlias($alias)
{  
    $records = executeQuery("CALL JoueurParAlias('$alias')");
    return count($records) >= 1 ? $records[0] : NULL;
}

function CreatePlayer($alias, $firstName, $lastName, $password)
{
    executeQuery("CALL InscrireNouveauJoueur('$alias', '$lastName', '$firstName', '$password')");
>>>>>>> origin/master
}