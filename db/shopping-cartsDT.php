<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetFilteredShoppingCartItemsByAlias($filter, $alias)
{
    return executeQuery("CALL ItemsParFiltreEtAliasJoueur($filter, '$alias')");
}

function GetAllShoppingCartItemsByAlias($alias)
{
    return executeQuery("CALL ItemsParAliasJoueur('$alias')");
}

function AddItemToShoppingCartByAlias($alias, $idItem, $quantity)
{
    executeQuery("CALL AjouterItemPanierParAliasJoueur('$alias', $idItem, $quantity)");
}