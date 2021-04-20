<?php

function CreateFilterSection()
{
    global $root;

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

            <div>
                <!-- Type d'items -->
                <div class='category'>Type</div>
                <label for='AE'>Arme</label>
                <input type='checkbox' id='AE' name='arme' checked>
                <label for='AM'>Armure</label>
                <input type='checkbox' id='AM' name='armure' checked>
                <label for='PO'>Potion</label>
                <input type='checkbox' id='PO' name='potion' checked>
                <label for='RS'>Ressource</label>
                <input type='checkbox' id='RS' name='ressource' checked>
            </div>

            <div>
                <!-- Nombre d'étoiles -->
                <div class='category'>Évaluation</div>
                <label for='0'>Aucune</label>
                <input type='checkbox' id='0' name='etoile0' checked>
                <label for='1'>1 Étoile</label>
                <input type='checkbox' id='1' name='etoile1' checked>
                <label for='2'>2 Étoiles</label>
                <input type='checkbox' id='2' name='etoile2' checked>
                <label for='3'>3 Étoiles</label>
                <input type='checkbox' id='3' name='etoile3' checked>
                <label for='4'>4 Étoiles</label>
                <input type='checkbox' id='4' name='etoile4' checked>
                <label for='5'>5 Étoiles</label>
                <input type='checkbox' id='5' name='etoile5' checked>
            </div>
        </div>
        <br>";
}

?>