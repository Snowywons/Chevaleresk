<?php
include_once "sessionCheck.php";
include_once "header.php";

//Exemple de données provenant d'une bd
$items = ["potion, exemple de text, 1000, 0", "diamant, exemple de text, 800, 0"];

echo <<<HTML
<main>
<div class="subContainer">
    <h1>Magasin</h1>
    
    <div class="filter">
        <img src="./Icons/FilterIcon.png">
        <span>Voir les filtres</span>
        <img src="./Icons/DownArrowIcon.png">
    </div>
    <div class="filterSelect hidden">
        <div>
            <label for="name">Nom</label>
            <br>
            <input type="text" name="name" id="name">
        </div>
        <div>
            <label for="price">Prix</label>
            <br>
            <input type="text" name="price" id="price">
        </div>
        <div>
            <label for="material">Matériel</label>
            <br>
            <input type="text" name="material" id="material">
        </div>
        <div>
            <label for="color">Couleur</label>
            <br>
            <input type="text" name="color" id="color">
        </div>
    </div>
    
    <hr>
    
    <div class="storeContainer">
        <div class="category">Objet</div>
        <div class="category">Caractéristiques</div>
        <div class="category">Prix</div>
        <div class="category">Quantité</div>
HTML;

foreach ($items as $str) {
    $data = explode(",", $str);
    for ($i = 0; $i < count($data); $i += 4) {
        echo "<div><img src='$data[$i]' alt='Image introuvable'/></div>";
        echo "<div>" . $data[$i + 1] . "</div>";
        echo "<div>" . $data[$i + 2] . "</div>";
        echo "<div><button>-</button><input type='text' value='".$data[$i + 3]."'/><button>+</button></div>";
    }
}

echo <<<HTML
        </div>
    </div>
</main>
HTML;

include_once "footer.php";
echo <<<HTML
    <script type="text/javascript" src="filter.js" defer></script>
HTML;
?>
