<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetPlayerByAlias($alias)
{
    return executeQuery("CALL JoueurParAlias('$alias')", true);
}

function PlayerIsAuthenticated($alias, $password)
{
    return executeQuery("SELECT JoueurEstAuthentifie('$alias', '$password')", true)[0];
}

function CreateNewPlayer($alias, $firstName, $lastName, $password)
{
    executeQuery("CALL InscrireNouveauJoueur('$alias', '$lastName', '$firstName', '$password')");
}