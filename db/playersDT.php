<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetAllPlayers()
{
    return executeQuery("CALL Joueurs()");
}

function GetPlayerByAlias($alias)
{
    return executeQuery("CALL JoueurParAlias('$alias')", true);
}

function GetPlayerBalanceByAlias($alias)
{
    return executeQuery("SELECT SoldeJoueurParAlias('$alias')", true)[0];
}

function PlayerIsAuthenticated($alias, $password)
{
    return executeQuery("SELECT JoueurEstAuthentifie('$alias', '$password')", true)[0];
}

function CreateNewPlayer($alias, $firstName, $lastName, $password)
{
    executeQuery("CALL InscrireNouveauJoueur('$alias', '$lastName', '$firstName', '$password')");
}

function DeletePlayerByAlias($alias)
{
    return executeQuery("CALL SupprimerJoueurParAlias('$alias')", true)[0];
}

function ModifyPlayerNamesByAlias($alias, $lastName, $firstName)
{
    executeQuery("CALL ModifierNomPrenomJoueurParAlias('$alias', '$lastName', '$firstName')");
}

function ModifyPlayerBalanceByAlias($alias, $balance)
{
    executeQuery("CALL ModifierSoldeJoueurParAlias('$alias', $balance)");
}

function ModifyPlayerPasswordByAlias($alias, $password)
{
    executeQuery("CALL ModifierMotDePasseJoueurParAlias('$alias', '$password')");
}