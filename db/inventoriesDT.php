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
    return executeQuery("CALL ItemsInventaireParAliasJoueur('$alias')");
}

function AddItemInventoryByAlias($alias, $idItem, $quantity)
{
    return executeQuery("CALL AjouterItemPanierParAliasJoueur('$alias', $idItem, $quantity)", true)[0];
}

function ModifyItemQuantityInventoryByAlias($alias, $idItem, $quantity)
{
    return executeQuery("CALL ModifierQuantiteItemInventaireParAliasJoueur('$alias', $idItem, $quantity)", true)[0];
}

function DeleteItemFromInventoryByAlias($alias, $idItem)
{
    return executeQuery("CALL SupprimerItemInventaireParAliasJoueur('$alias', $idItem)", true)[0];
}