<?php
include_once "header.php";
include_once "dbConnect.php";
include_once "dbUtilities.php";

global $conn;

$idItem = 0;
if (isset($_GET["idItem"]))
{
    $idItem = $_GET["idItem"];
}

$records = [];

if ($conn) {
    $query = "SELECT * FROM Items WHERE idItem=$idItem;";

    try {
        $records = $conn->query($query)->fetchall()[0];
    } catch (PDOException $e) { }
}

$nomItem = $records[1];
$photoItem = $records[4];
$codeType = $records[5];

if ($conn) {
    $query = "SELECT idEvaluation, noteEvaluation, commentaireEvaluation, idJoueur FROM Evaluations E WHERE E.idItem = $idItem;";

    try {
        $records = $conn->query($query)->fetchall();
    } catch (PDOException $e) { }
}


echo <<<HTML
<main class="evaluationPage">
    <h1>Évaluations</h1>
HTML;


echo "
<div class='evaluationContainer'>

    <div class='evaluationItemImageContainer'>
        <img src='./Icons/ChevalereskIcon.png'/>
        <div>" . $nomItem . "</div>
        <div class='itemDetailsStarbar'>
            <img src='./Icons/StarIcon.png'>
            <img src='./Icons/StarIcon.png'>
        </div>
    </div>";

foreach ($records as $data)
{
    $starsCount = intval($data[1]);
    $starBar = "";
    for($i = 0; $i < $starsCount; $i++)
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
</main>
HTML;

include_once "footer.php";
?>
