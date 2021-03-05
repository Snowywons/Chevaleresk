<?php
if (!defined("ROOT"))
    define("ROOT", $_SERVER['DOCUMENT_ROOT']."/Chevaleresk/");

$root = "../";

include_once $root."master/header.php";
include_once $root."utilities/dbUtilities.php";
include_once $root."utilities/filterUtilities.php";


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
<main class="evaluations">
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
            <div id='".$idItem. "_showEvaluations' class='itemEvaluationPreviewContainer'>
                <img src='".$root."icons/ChevalereskIcon.png'/>
                <div>" . $nomItem . "</div>
                <div class='itemDetailsStarbar'>
                    <img src='".$root."icons/StarIcon.png'>
                    <img src='".$root."icons/StarIcon.png'>
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
                <img src='".$root."icons/ChevalereskIcon.png'/>
                <div>" . $nomItem . "</div>
                <div class='itemDetailsStarbar'>
                    <img src='".$root."icons/StarIcon.png'>
                    <img src='".$root."icons/StarIcon.png'>
                </div>
            </div>";

    $records = executeQuery("SELECT idEvaluation, noteEvaluation, commentaireEvaluation, idJoueur FROM Evaluations E WHERE E.idItem = $idItem;");

    foreach ($records as $data) {
        $starsCount = intval($data[1]);
        $starBar = "";
        for ($i = 0; $i < $starsCount; $i++)
            $starBar .= "<img src='".$root."icons/StarIcon.png'>";
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

include_once $root."master/footer.php";

echo "
    <script type='text/javascript' src='".$root."js/filter.js' defer></script>
    <script type='text/javascript' src='".$root."js/evaluations.js' defer></script>";
?>
