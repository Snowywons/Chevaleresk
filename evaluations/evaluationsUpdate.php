<?php
$root = "../";

global $conn;

/*
 * $records est une array d'items de la forme suivante:
 * [idItem,
 *  nomItem,
 *  quantiteStock,
 *  prixItem,
 *  codePhoto,
 *  codeType]
*/

function CreateEvaluationsContainer($records) {
    global $root;

    $content = "
    <div class='evaluationsContainer'>";

        foreach ($records as $data) {
        $idItem = $data[0];
        $name = $data[1];
        $photoURL = $data[2];
        $starsAvg = $data[3];
        $content .= "
            <!-- Image -->
            <div id='" . $idItem . "_showEvaluations' class='itemEvaluationPreviewContainer fadeIn showEvaluations'>
                <div class='itemEvaluationPreviewImageBackgroundContainer'>
                    <div class='itemEvaluationPreviewImageContainer'>
                        <div class='itemIconContainer'>
                            <img src='" . $root . "/icons/$photoURL.png'/>
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
                            $content .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";
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

function CreateEvaluationContainer($records) {
    global $root;

    if (count($records) > 0) {

        $idItem = $records[0];
        $name = $records[1];
        $photoURL = $records[2];
        $starsAvg = $records[3];


        $starsCount = explode(",", GetEvaluationCountForEachStarByIdItem($idItem));

        $content = "
        <div class='evaluationContainer'>
            <!-- Image et Barre d'étoiles -->
            <div class='evaluationItemContainer'>
            
                <!-- Image -->
            <div id='" . $idItem . "_showEvaluations' class='itemEvaluationPreviewContainer'>
                <div class='itemEvaluationPreviewImageBackgroundContainer'>
                    <div class='itemEvaluationPreviewImageContainer'>
                        <div class='itemIconContainer'>
                            <img src='" . $root . "/icons/$photoURL.png'/>
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
                            $content .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";
                    } else {
                        $content .= "<div class='itemStarbar'>Aucune évaluation</div>";
                    }
                    $content .= "
                </div>
            </div>
                
                <div class='allItemStarbarContainer'>
                    <h4>Nombre d'évaluations par étoiles</h4>
                    <hr style='width: 90%'>
                    <div class='itemStarbarContainer'>";
                        for ($i = 0; $i < 5; $i++)
                            $content .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";
                        $content .= "<div class='itemStarbar'>($starsCount[4])</div>
                    </div>
                    <div class='itemStarbarContainer'>";
                        for ($i = 0; $i < 4; $i++)
                            $content .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";
                        $content .= "<div class='itemStarbar'>($starsCount[3])</div>
                    </div>
                    <div class='itemStarbarContainer'>";
                        for ($i = 0; $i < 3; $i++)
                            $content .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";
                        $content .= "<div class='itemStarbar'>($starsCount[2])</div>
                    </div>
                    <div class='itemStarbarContainer'>";
                        for ($i = 0; $i < 2; $i++)
                            $content .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";
                        $content .= "<div class='itemStarbar'>($starsCount[1])</div>
                    </div>
                    <div class='itemStarbarContainer'>";
                        $content .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";
                        $content .= "<div class='itemStarbar'>($starsCount[0])</div>
                    </div>
                </div>
            </div>";

        $records = GetEvaluationsByIdItem($idItem);

        foreach ($records as $data) {
            $name = $data[0];
            $starsCount = intval($data[1]);
            $comment = $data[2];

            $starBar = "";
            for ($i = 0; $i < $starsCount; $i++)
                $starBar .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";

            $content .= "
            <div class='playerEvaluationContainer'>
                <div>
                    <div class='itemStarbarContainer'>
                        $starBar
                    </div>
                </div>
                <div>$comment</div>
                <div><i>$name</i></div>
            </div>";
        }

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
                <div id='" . $idItem . "_evaluationSendButton' class='mediumButton evaluationSendButton'>
                    <span>Envoyer</span>
                </div>
            </form>
        </div>
    </div>";

        return $content;
    }
}

/*function CreateEvaluationContainer($records) {
    global $root;

    if (count($records) > 0) {

        $idItem = $records[0];
        $name = $records[1];
        $photoURL = $records[2];
        $starsAvg = $records[3];


        $starsCount = explode(",", GetEvaluationCountForEachStarByIdItem($idItem));

        $content = "
        <div class='evaluationContainer'>
            <!-- Image et Barre d'étoiles -->
            <div class='evaluationItemContainer'>

                <div class='evaluationItemImageContainer'>
                    <div class='itemIconContainer'>
                        <img src='" . $root . "/icons/$photoURL.png'/>
                    </div>
                    <div class='titleContainer'>
                        <div>" . $name . "</div>
                    </div>
                </div>

                <div class='allItemStarbarContainer'>
                    <div class='itemStarbarContainer'>";
                        for ($i = 0; $i < 5; $i++)
                            $content .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";
                        $content .= "<div class='itemStarbar'>($starsCount[4])</div>
                    </div>
                    <div class='itemStarbarContainer'>";
                        for ($i = 0; $i < 4; $i++)
                            $content .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";
                        $content .= "<div class='itemStarbar'>($starsCount[3])</div>
                    </div>
                    <div class='itemStarbarContainer'>";
                        for ($i = 0; $i < 3; $i++)
                            $content .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";
                        $content .= "<div class='itemStarbar'>($starsCount[2])</div>
                    </div>
                    <div class='itemStarbarContainer'>";
                        for ($i = 0; $i < 2; $i++)
                            $content .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";
                        $content .= "<div class='itemStarbar'>($starsCount[1])</div>
                    </div>
                    <div class='itemStarbarContainer'>";
                        $content .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";
                        $content .= "<div class='itemStarbar'>($starsCount[0])</div>
                    </div>
                </div>
            </div>";

        $records = GetEvaluationsByIdItem($idItem);

        foreach ($records as $data) {
            $name = $data[0];
            $starsCount = intval($data[1]);
            $comment = $data[2];

            $starBar = "";
            for ($i = 0; $i < $starsCount; $i++)
                $starBar .= "<div class='itemStarbar'><img src='" . $root . "icons/StarIcon.png'></div>";

            $content .= "
            <div class='playerEvaluationContainer'>
                <div>
                    <div class='itemStarbarContainer'>
                        $starBar
                    </div>
                </div>
                <div>$comment</div>
                <div><i>$name</i></div>
            </div>";
        }

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
                <input id='" . $idItem . "_evaluationSendButton' type='submit' class='evaluationSendButton'>
            </form>
        </div>
    </div>";

        return $content;
    }
}*/