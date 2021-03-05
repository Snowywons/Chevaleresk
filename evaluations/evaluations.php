<?php
$root = "../";

include_once $root . "master/header.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "utilities/filterUtilities.php";


global $conn;

$itemId = isset($_GET["idItem"]) ? $_GET["idItem"] : null;

$itemName = "";
$itemImage = "";
$typeCode = "";

$records = executeQuery("SELECT * FROM Items WHERE idItem=$itemId;", true);

if (count($records) > 0) {
    $itemName = $records[1];
    $itemImage = $records[4];
    $typeCode = $records[5];
}

echo <<<HTML
<main class="evaluations">
    <h1>Évaluations</h1>
HTML;

if ($itemId == null) {
    CreateFilterSection();

    $records = executeQuery("SELECT * FROM Items;");

    /* Affichage de tous les items  */
    echo "<div class='itemEvaluationsContainer'>";
    foreach ($records as $data) {
        $idItem = $data[0];
        $itemName = $data[1];
        echo "
            <!-- Image -->
            <div id='" . $idItem . "_showEvaluations' class='itemEvaluationPreviewContainer'>
                <img src='" . $root . "icons/ChevalereskIcon.png'/>
                <!-- Nom item -->
                <div>" . $itemName . "</div>
                <!-- Barre d'étoiles -->
                <div class='itemStarbarContainer'>
                    <div class='itemStarbar'>
                        <img src='" . $root . "icons/StarIcon.png'>
                        <img src='" . $root . "icons/StarIcon.png'>
                        (99)
                    </div>
                </div>
            </div>";
    }
    echo "</div>";
} else {
    /* Affichage des évaluations pour un item sélectionné */
    echo "
        <div class='evaluationsListButtonContainer'>
            <button class='evaluationsListButton'>Retour à la liste</button>
        </div>
        
        <div class='evaluationContainer'>
            <!-- Image et Barre d'étoiles -->
            <div class='evaluationItemContainer'>
                <div class='evaluationItemImageContainer'>
                    <img src='" . $root . "icons/ChevalereskIcon.png'/>
                    <div>" . $itemName . "</div>
                    <div class='itemStarbarContainer'>
                        <div class='itemStarbar'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            (99)
                        </div>
                        <div class='itemStarbar'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            (99)
                        </div>
                        <div class='itemStarbar'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            (99)
                        </div>
                        <div class='itemStarbar'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            (99)
                        </div>
                        <div class='itemStarbar'>
                            <img src='" . $root . "icons/StarIcon.png'>
                            (99)
                        </div>
                    </div>
                </div>
            </div>";

    $records = executeQuery("SELECT idEvaluation, noteEvaluation, commentaireEvaluation, idJoueur FROM Evaluations E WHERE E.idItem = $itemId;");

    foreach ($records as $data) {
        $starsCount = intval($data[1]);
        $starBar = "";
        for ($i = 0; $i < $starsCount; $i++)
            $starBar .= "<img src='" . $root . "icons/StarIcon.png'>";
        echo "
            <div class='playerEvaluationContainer'>
                <div>$starBar</div>
                <div>$data[2]</div>
                <div>Nom joueur</div>
            </div>";
    }

    echo <<<HTML
        <div class='playerEvaluationContainer'>
            <div class="starBar"><img src='$root/icons/StarIcon.png'></div>
            <form action="" method="post">
                <textarea placeholder="Nouveau commentaire"></textarea>
                <input type="submit">
            </form>
        </div>
    </div>
HTML;
}

echo "</main>";

include_once $root . "master/footer.php";

echo "
    <script type='text/javascript' src='" . $root . "js/filter.js' defer></script>
    <script type='text/javascript' src='" . $root . "js/evaluations.js' defer></script>";
?>
