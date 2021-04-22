<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetFilteredInventoryItemsByAlias($filter, $alias)
{
    return executeQuery("CALL ItemsInventaireParFiltreEtAliasJoueur($filter, '$alias')");
}

function GetAllInventoryItemsByAlias($alias)
{
//    return executeQuery("CALL ItemsInventaireParAliasJoueur('$alias')");
    global $conn;

    $statement = $conn->prepare("CALL ItemsInventaireParAliasJoueur(?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
    if($result) {
        return $result;
    }
    return [];
}

function PlayerHasItem($alias, $idItem)
{
    global $conn;

    $statement = $conn->prepare("SELECT JoueurPossedeItem(?, ?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$idItem, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result[0];
    }
    return [];
}

function AddItemInventoryByAlias($alias, $idItem, $quantity)
{
    global $conn;
    
    $statement = $conn->prepare("SELECT AjouterItemPanierParAliasJoueur(?,?,?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$password, PDO::PARAM_INT);
    $statement->bindParam(3,$quantity, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result[0];
    }
    return [];
}

function ModifyItemQuantityInventoryByAlias($alias, $idItem, $quantity)
{
    global $conn;
    
    $statement = $conn->prepare("SELECT ModifierQuantiteItemInventaireParAliasJoueur(?,?,?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$password, PDO::PARAM_INT);
    $statement->bindParam(3,$quantity, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result[0];
    }
    return [];
}

function DeleteItemFromInventoryByAlias($alias, $idItem)
{
    global $conn;
    
    $statement = $conn->prepare("SELECT SupprimerItemInventaireParAliasJoueur(?,?)");
    $statement->bindParam(1,$alias, PDO::PARAM_STR);
    $statement->bindParam(2,$idItem, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    if($result) {
        return $result[0];
    }
    return [];
}