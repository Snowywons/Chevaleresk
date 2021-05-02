<?php
$root = "../";

global $conn;

//Premet d'afficher les évaluations miniatures (frame)
function CreateEvaluationsContainer($records)
{
    global $root;

    $content = "
    <div class='evaluationsContainer'>";

    foreach ($records as $data) {
        $idItem = $data[0];
        $name = $data[1];
        $stock = $data[2];
        $price = $data[3];
        $photoURL = $data[4];
        $codeType = $data[5];
        $starsAvg = $data[6];
        $evaluationCount = $data[7];

        $content .= "
            <!-- Image -->
            <div id='" . $idItem . "_showEvaluations' 
                class='itemEvaluationPreviewContainer fadeIn'
                onClick='Redirect(\"../evaluations/evaluations\",\"idItem=" .$idItem."\")'>
                <div class='itemEvaluationPreviewImageBackgroundContainer'>
                    <div class='itemEvaluationPreviewImageContainer'>
                        <div class='itemIconContainer'>
                            <img src='" . $root . "/icons/$photoURL'/>
                        </div>
                        <div class='titleContainer'>
                            <div>" . $name . "</div>
                        </div>
                    </div>
                </div>
                <!-- Barre d'étoiles -->
                <div class='itemStarbarContainer'>";
        if ($starsAvg != 0) {
            for ($i = 0; $i < $starsAvg; $i++)
                $content .= "<div class='itemStarbar'><img src='" . $root . "/icons/StarIcon.png'></div>";
            $content .= "<div class='itemStarbar'>&nbsp($evaluationCount)</div>";
        } else {
            $content .= "<div class='itemStarbar'>Aucune évaluation</div>";
        }
        $content .= "
                </div>
            </div>";
    }

    $content .= "</div>";

    return $content;
}

//Permet d'afficher toutes les évaluations d'un item en particulier
function CreateEvaluationContainer($records)
{
    global $root;

    $isAdmin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : false;
    $content = "";

    if (count($records) > 0) {

        $idItem = $records[0];
        $name = $records[1];
        $stock = $records[2];
        $price = $records[3];
        $photoURL = $records[4];
        $codeType = $records[5];
        $starsAvg = $records[6];
        $evaluationCount = $records[7];


        $starsCount = explode(",", GetEvaluationCountForEachStarByIdItem($idItem));

        $content .= "
        <div class='evaluationContainer'>
            <!-- Image et Barre d'étoiles -->
            <div class='evaluationItemContainer'>
            
            <!-- Image -->
            <div id='" . $idItem . "_showEvaluations' class='itemEvaluationPreviewContainer'>
                <div class='itemEvaluationPreviewImageBackgroundContainer'>
                    <div class='itemEvaluationPreviewImageContainer'>
                        <div class='itemIconContainer'>
                            <img src='" . $root . "/icons/$photoURL'/>
                        </div>
                        <div class='titleContainer'>
                            <div>" . $name . "</div>
                        </div>
                    </div>
                </div>";

        $starBar = "";

        if ($starsAvg != 0) {
            for ($i = 0; $i < $starsAvg; $i++)
                $starBar .= "<div class='itemStarbar'><img src='" . $root . "/icons/StarIcon.png'></div>";
            $starBar .= "<div class='itemStarbar'>&nbsp($evaluationCount)</div>";
        } else {
            $starBar .= "<div class='itemStarbar'>Aucune évaluation</div>";
        }

        $content .= "
                <div class='itemStarbarContainer'>$starBar</div>
            </div>
                
                <div class='allItemStarbarContainer'>
                    <h4>Nombre d'évaluations par note</h4>
                    <hr style='width: 90%'>
                    <div class='itemStarbarContainer'>";
        for ($i = 0; $i < 5; $i++)
            $content .= "<div class='itemStarbar'><img src='" . $root . "/icons/StarIcon.png'></div>";
        $content .= "<div class='itemStarbar'>($starsCount[4])</div>
                    </div>
                    <div class='itemStarbarContainer'>";
        for ($i = 0; $i < 4; $i++)
            $content .= "<div class='itemStarbar'><img src='" . $root . "/icons/StarIcon.png'></div>";
        $content .= "<div class='itemStarbar'>($starsCount[3])</div>
                    </div>
                    <div class='itemStarbarContainer'>";
        for ($i = 0; $i < 3; $i++)
            $content .= "<div class='itemStarbar'><img src='" . $root . "/icons/StarIcon.png'></div>";
        $content .= "<div class='itemStarbar'>($starsCount[2])</div>
                    </div>
                    <div class='itemStarbarContainer'>";
        for ($i = 0; $i < 2; $i++)
            $content .= "<div class='itemStarbar'><img src='" . $root . "/icons/StarIcon.png'></div>";
        $content .= "<div class='itemStarbar'>($starsCount[1])</div>
                    </div>
                    <div class='itemStarbarContainer'>";
        $content .= "<div class='itemStarbar'><img src='" . $root . "/icons/StarIcon.png'></div>";
        $content .= "<div class='itemStarbar'>($starsCount[0])</div>
                    </div>
                </div>
            </div>";


        //COMMENTAIRES
        $records = GetEvaluationsByIdItem($idItem);
        $alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
        $playerHasItem = PlayerHasItem($alias, $idItem);

        foreach ($records as $data) {
            $name = $data[0];
            $starsCount = intval($data[1]);
            $comment = $data[2];
            $date = $data[3];

            $starBar = "";
            for ($i = 0; $i < $starsCount; $i++)
                $starBar .= "<div class='itemStarbar'><img src='" . $root . "/icons/StarIcon.png'></div>";

            $content .= "
            <div class='playerEvaluationContainer'>
                <div>
                    <div class='itemStarbarContainer'>$starBar</div>";

            if ($isAdmin || ($name == $alias)) {
                $content .= "
                    <div class='adminButtonsContainer'>
                        <button type='button' class='deleteButton' onclick='DeleteItem(\"".$idItem."\",\"".$name."\")'>
                            <img src='" . $root . "/icons/DeleteIcon.png'/>
                        </button>
                    </div>";
            }

            $content .= "
                </div>
                <div>$comment</div>
                <div><i>$name</i>, $date</div>
            </div>";
        }

        if ($playerHasItem) {
            $content .= "
                <div class='playerEvaluationContainer'>
                    <form action='' method='post'>
                        <fieldset>
                            <div class='rating'>
                                <input id='1_star' name='star' type='radio' value='5' hidden/>
                                <label id='1_starLabel' for='1_star'></label>
                                
                                <input id='2_star' name='star' type='radio' value='5' hidden/>
                                <label id='2_starLabel' for='2_star'></label>
                                
                                <input id='3_star' name='star' type='radio' value='5' hidden/>
                                <label id='3_starLabel' for='3_star'></label>
                                
                                <input id='4_star' name='star' type='radio' value='5' hidden/>
                                <label id='4_starLabel' for='4_star'></label>
                                
                                <input id='5_star' name='star' type='radio' value='5' hidden/>
                                <label id='5_starLabel' for='5_star'></label>
                            </div>
                            <textarea id='commentArea' placeholder='Nouveau commentaire'></textarea>
                        </fieldset>
                        <div id='" . $idItem . "_evaluationSendButton' 
                        class='mediumButton evaluationSendButton' onclick='SendEvaluation($idItem)'>
                            <span>Envoyer</span>
                        </div>
                    </form>
                </div>";
        } else {
            $content .= "<div class='playerEvaluationContainer'>Vous devez d'abord acheter l'item pour pouvoir le commenter. &#128540;</div>";
        }

        $content .= "</div>";
    }

    return $content;
}