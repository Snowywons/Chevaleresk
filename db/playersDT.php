<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

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
}