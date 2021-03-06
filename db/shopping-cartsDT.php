<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetFilteredShoppingCartItemsByAlias($filter, $alias)
{
    return executeQuery("CALL ItemsPanierParFiltreEtAliasJoueur($filter, '$alias')");
}

function GetAllShoppingCartItemsByAlias($alias)
{
    return executeQuery("CALL ItemsPanierParAliasJoueur('$alias')");
}

function AddItemShoppingCartByAlias($alias, $idItem, $quantity)
{
    return executeQuery("CALL AjouterItemPanierParAliasJoueur('$alias', $idItem, $quantity)", true)[0];
}

function ModifyItemQuantityShoppingCartByAlias($alias, $idItem, $quantity)
{
    return executeQuery("CALL ModifierQuantiteItemPanierParAliasJoueur('$alias', $idItem, $quantity)", true)[0];
}

function DeleteItemFromShoppingCartByAlias($alias, $idItem)
{
    return executeQuery("CALL SupprimerItemPanierParAliasJoueur('$alias', $idItem)", true)[0];
}

function PayShoppingCartByAlias($alias)
{
    return executeQuery("CALL PayerPanierParAliasJoueur('$alias')", true)[0];
}

function CalculateShoppingCartTotalByAlias($alias)
{
    return executeQuery("SELECT CalculerMontantPanierParAliasJoueur('$alias')", true)[0];
}