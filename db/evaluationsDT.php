<?php
global $root;

include_once $root . "utilities/dbUtilities.php";

global $conn;

function GetEvaluationsByIdItem($idItem)
{
    return executeQuery("CALL EvaluationsParIdItem($idItem)");
}

function GetFilteredEvaluationsByIdItem($filter, $idItem)
{
    return executeQuery("CALL EvaluationsParFiltreEtIdItem($filter, $idItem)");
}

function GetFilteredEvaluations($filter) {
    return executeQuery("CALL EvaluationsParFiltre($filter)");
}

function GetAllEvaluationsPreviews()
{
    return executeQuery("CALL EvaluationsSommaires()");
}

function GetEvaluationPreviewByIdItem($idItem)
{
    return executeQuery("CALL EvaluationSommaireParIdItem($idItem)", true);
}

function GetEvaluationCountForEachStarByIdItem($idItem)
{
    return executeQuery("CALL NombreEvaluationsParEtoileParIdItem($idItem)", true)[0];
}

function AddEvaluationByIdItem($id, $alias, $stars, $comment)
{
    global $conn;

    $statement = $conn->prepare("CALL AjouterEvaluationParIdItemEtAliasJoueur(?, ?, ?, ?)");
    $statement->bindParam(1, $id, PDO::PARAM_INT);
    $statement->bindParam(2, $alias, PDO::PARAM_STR);
    $statement->bindParam(3, $stars, PDO::PARAM_INT);
    $statement->bindParam(4, $comment, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch();

    return count($result) > 0 ? $result[0] : "";
}

function DeleteEvaluationByIdItemAndAlias($id, $alias) {
    global $conn;

    $statement = $conn->prepare("CALL SupprimerEvaluationParIdItemEtAliasJoueur(?, ?)");
    $statement->bindParam(1, $id, PDO::PARAM_INT);
    $statement->bindParam(2, $alias, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch();

    return count($result) > 0 ? $result[0] : "";
}