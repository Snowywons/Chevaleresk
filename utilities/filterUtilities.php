<?php

function CreateFilterSection()
{
    global $root;

    $checkeds = [];
    $filters = isset($_SESSION["filters"]) ? explode(',', $_SESSION["filters"]) : [];
    foreach ($filters as $filter)
        array_push($checkeds, strlen($filter) > 2);

    //Tous les filtres seront sélectionnés si la variable de session ne contient pas de filtre
    $all = count($filters) < 4;

    echo "
    <!-- Bouton de filtre -->
    <div class='filterWrapper'>
        <div id='filterContainer' class='filterContainer'>
            <span>Voir les filtres</span>
            <img src='" . $root . "icons/DownArrowIcon.png'>
        </div>
        <div id='resetFilterContainer' class='resetFilterContainer'>
            <img src='" . $root . "/icons/resetIcon.png'>
        </div>
    </div>
    <!-- Filtre individuel -->
    <div id='filters' class='filters hidden'>
        <label for='AR'>Arme</label>
        <input type='checkbox' id='AR' name='arme'" . ($all || $checkeds[0] ? "checked" : "") . ">
        <label for='AM'>Armure</label>
        <input type='checkbox' id='AM' name='armure'" . ($all || $checkeds[1] ? "checked" : "") . ">
        <label for='PO'>Potion</label>
        <input type='checkbox' id='PO' name='potion'" . ($all || $checkeds[2] ? "checked" : "") . ">
         <label for='RS'>Ressource</label>
        <input type='checkbox' id='RS' name='ressource'" . ($all || $checkeds[3] ? "checked" : "") . ">
    </div>
    <br>";
}

?>