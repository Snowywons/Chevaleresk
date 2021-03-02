<?php
include_once "header.php";
include_once "dbConnect.php";
include_once "dbUtilities.php";
include_once "filterUtilities.php";

global $conn;

$idItem = isset($_GET["idItem"]) ? $_GET["idItem"] : null;

$nomItem = "";
$photoItem = "";
$codeType = "";

$records = executeQuery("SELECT * FROM Items WHERE idItem=$idItem;", true);

if (count($records) > 0)
{
    $nomItem = $records[1];
    $photoItem = $records[4];
    $codeType = $records[5];
}

echo <<<HTML
<main class="evaluationsPage">
    <h1>Évaluations</h1>
HTML;

if ($idItem == null)
{
    CreateFilterSection();

    $records = executeQuery("SELECT * FROM Items;");

    echo "<div class='itemEvaluationsContainer'>";
    foreach ($records as $data) {
        $idItem = $data[0];
        $nomItem = $data[1];
        echo "
            <div id='".$idItem."_showEvaluations' class='itemEvaluationPreviewContainer'>
                <img src='./Icons/ChevalereskIcon.png'/>
                <div>" . $nomItem . "</div>
                <div class='itemDetailsStarbar'>
                    <img src='./Icons/StarIcon.png'>
                    <img src='./Icons/StarIcon.png'>
                </div>
            </div>";
    }

    echo "</div>";
}
else {
    echo "
        <div class='evaluationsListButtonContainer'>
            <button class='evaluationsListButton'>Retour à la liste</button>
        </div>
        
        <div class='evaluationContainer'>
            <div class='evaluationItemImageContainer'>
                <img src='./Icons/ChevalereskIcon.png'/>
                <div>" . $nomItem . "</div>
                <div class='itemDetailsStarbar'>
                    <img src='./Icons/StarIcon.png'>
                    <img src='./Icons/StarIcon.png'>
                </div>
            </div>";

    $records = executeQuery("SELECT idEvaluation, noteEvaluation, commentaireEvaluation, idJoueur FROM Evaluations E WHERE E.idItem = $idItem;");

    foreach ($records as $data) {
        $starsCount = intval($data[1]);
        $starBar = "";
        for ($i = 0; $i < $starsCount; $i++)
            $starBar .= "<img src='./Icons/StarIcon.png'>";
        echo "
            <div class='playerEvaluationContainer'>
                <div>$starBar</div>
                <div>$data[2]</div>
                <div>Nom joueur</div>
            </div>";
    }

    echo <<<HTML
        <div class='playerEvaluationContainer'>
            <div class="starBar"><img src='./Icons/StarIcon.png'></div>
            <form action="" method="post">
                <textarea placeholder="Nouveau commentaire"></textarea>
                <input type="submit">
            </form>
        </div>
    </div>
HTML;
}

echo "</main>";

include_once "footer.php";

echo <<<HTML
    <script type="text/javascript" src="filter.js" defer></script>
    <script type="text/javascript" src="evaluation.js" defer></script>
HTML;
?>
