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
    return executeQuery("CALL AjouterItemPanierParAliasJoueur('$alias', $idItem, $quantity)", true)[0];
}

function DeleteItemFromShoppingCartByAlias($alias, $idItem)
{
    return executeQuery("CALL SupprimerItemPanierParAliasJoueur('$alias', $idItem)", true)[0];
}

function PayShoppingCartByAlias($alias)
{
    return executeQuery("CALL PayerPanierParAliasJoueur('$alias')", true)[0];
}