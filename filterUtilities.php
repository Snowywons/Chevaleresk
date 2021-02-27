<?php

function CreateFilterSection() {
    echo <<<HTML
    <div class="filter">
<!--        <img src="./Icons/FilterIcon.png">-->
        <span>Voir les filtres</span>
        <img src="./Icons/DownArrowIcon.png">
    </div>
    <div class="filterSelect hidden">
            <label for="potion">Potion</label>
            <input type="checkbox" id="potion" name="potion">
            <label for="armure">Armure</label>
            <input type="checkbox" id="armure" name="armure">
            <label for="arme">Arme</label>
            <input type="checkbox" id="arme" name="arme">
        </div>
    </div>
HTML;
}
?>