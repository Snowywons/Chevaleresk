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
    global $conn;
    $passwordhash = hash("sha256", $password);
    $statement = $conn->prepare("SELECT JoueurEstAuthentifie(?,?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$passwordhash, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result[0];
    }
    return [];
}

function CreateNewPlayer($alias, $firstName, $lastName, $password)
{
    global $conn;
    $passwordhash = hash("sha256", $password);
    $statement = $conn->prepare("CALL InscrireNouveauJoueur(?, ?, ?, ?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$firstName, PDO::PARAM_STR);
    $statement->bindParam(3,$lastName, PDO::PARAM_STR);
    $statement->bindParam(4,$passwordhash, PDO::PARAM_STR);
    $statement->execute();
}

function DeletePlayerByAlias($alias)
{
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
    global $conn;
    
    $statement = $conn->prepare("CALL ModifierNomPrenomJoueurParAlias(?, ?, ?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$lastName, PDO::PARAM_STR);
    $statement->bindParam(3,$firstName, PDO::PARAM_STR);
    $statement->execute();
}

function ModifyPlayerBalanceByAlias($alias, $balance)
{
    global $conn;
    
    $statement = $conn->prepare("CALL ModifierSoldeJoueurParAlias(?, ?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$balance, PDO::PARAM_INT);
    $statement->execute();
}

function ModifyPlayerPasswordByAlias($alias, $password)
{
    global $conn;
    $passwordhash = hash("sha256", $password);

    $statement = $conn->prepare("CALL ModifierMotDePasseJoueurParAlias(?, ?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$passwordhash, PDO::PARAM_STR);
    $statement->execute();
}