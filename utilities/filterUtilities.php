<?php

function CreateFilterSection() {
    echo <<<HTML
    <div class="filterContainer">
<!--        <img src="./Icons/FilterIcon.png">-->
        <span>Voir les filtres</span>
        <img src="../icons/DownArrowIcon.png">
    </div>
    <div class="filters hidden">
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