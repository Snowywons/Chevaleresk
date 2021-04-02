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
    global $conn;

    $statement = $conn->prepare("CALL JoueurParAlias(?)");
    $statement->bindParam(1, $alias, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result;
    }
    return [];
}

function GetPlayerBalanceByAlias($alias)
{
    global $conn;

    $statement = $conn->prepare("SELECT SoldeJoueurParAlias(?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result[0];
    }
    return [];
}

function PlayerIsAuthenticated($alias, $password)
{
    //return executeQuery("SELECT JoueurEstAuthentifie('$alias', '$password')", true)[0];
    global $conn;
    
    $statement = $conn->prepare("SELECT JoueurEstAuthentifie(?,?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$password, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result[0];
    }
    return [];
}

function CreateNewPlayer($alias, $firstName, $lastName, $password)
{
    //executeQuery("CALL InscrireNouveauJoueur('$alias', '$lastName', '$firstName', '$password')");
    global $conn;
    
    $statement = $conn->prepare("CALL InscrireNouveauJoueur(?, ?, ?, ?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$firstName, PDO::PARAM_STR);
    $statement->bindParam(3,$lastName, PDO::PARAM_STR);
    $statement->bindParam(4,$password, PDO::PARAM_STR);
    $statement->execute();
}

function DeletePlayerByAlias($alias)
{
    //return executeQuery("CALL SupprimerJoueurParAlias('$alias')", true)[0];
    global $conn;
    
    $statement = $conn->prepare("CALL SupprimerJoueurParAlias(?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result[0];
    }
    return [];
}

function ModifyPlayerNamesByAlias($alias, $lastName, $firstName)
{
    //executeQuery("CALL ModifierNomPrenomJoueurParAlias('$alias', '$lastName', '$firstName')");
    global $conn;
    
    $statement = $conn->prepare("CALL ModifierNomPrenomJoueurParAlias(?, ?, ?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$lastName, PDO::PARAM_STR);
    $statement->bindParam(3,$firstName, PDO::PARAM_STR);
    $statement->execute();
}

function ModifyPlayerBalanceByAlias($alias, $balance)
{
    //executeQuery("CALL ModifierSoldeJoueurParAlias('$alias', $balance)");
    global $conn;
    
    $statement = $conn->prepare("CALL ModifierSoldeJoueurParAlias(?, ?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$balance, PDO::PARAM_INT);
    $statement->execute();
    
}

function ModifyPlayerPasswordByAlias($alias, $password)
{
    //executeQuery("CALL ModifierMotDePasseJoueurParAlias('$alias', '$password')");
    global $conn;
    
    $statement = $conn->prepare("CALL ModifierMotDePasseJoueurParAlias(?, ?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$password, PDO::PARAM_STR);
    $statement->execute();
}