<?php
$root = "../";

include_once $root."master/header.php";

$nom = "NAN";

echo <<<HTML
<!--DEV MESSAGE-->
<h1 style="background-color: deeppink">CETTE PAGE DEVRA ÊTRE ACCESSIBLE SEULEMENT PAR LES ADMINISTRATEURS</h1>
<main class="delete-profile">
    <h1>Supprimer un profil</h1>
    
    <form action="">
        <fieldset>
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="$nom" disabled>
HTML;
echo <<<HTML
            <input type="submit" value="Supprimer">
        </fieldset>
    </form>
</main>
HTML;

include_once $root."master/footer.php";

?>