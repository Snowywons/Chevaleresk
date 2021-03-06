<?php
/*
 * $records est une array d'items de la forme suivante:
 * [idItem,
 *  nomItem,
 *  quantiteStock,
 *  prixItem,
 *  codePhoto,
 *  codeType,
 *  starsAvg
 *  starsCount]
*/

//Popup des détails d'un item
function CreateItemDetailsContainers($records)
{
    global $root;

    $isAdmin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : false;

    $content = "<div>";

    foreach ($records as $data) {

        $idItem = $data[0];
        $nomItem = $data[1];
        $quantiteStock = $data[2];
        $prixItem = $data[3];
        $codePhoto = "../icons/$data[4]";
        $codeType = $data[5];

        $nomType =
            ($codeType == "AE" ? "Arme" :
                ($codeType == "AM" ? "Armure" :
                    ($codeType == "PO" ? "Potion" : "Ressource")));

        /*Création des pages de détails pour chaque item*/
        $content .= "
            <div id='" . $idItem . "_itemDetailsContainer' class='popupContainer itemDetailsContainer'>
                <div class='popupHeaderContainer'>
                    <span>$nomItem</span>
                    <button class='popupExitButton' onclick='
                    ClosePopup(\"" . $idItem . "_itemDetailsContainer\");
                    CloseNotifier();
                    CloseOverlay();'>x</button>
                </div>
                <div class='popupBodyContainer'>";

        if ($isAdmin) {
            $content .= "
                <div class='adminButtonsContainer'>
                    <button type='button' class='modifyButton' onclick='Redirect(\"../store/modify-item\",\"idItem=" . $idItem . "\")'>
                        <img src='" . $root . "/icons/EditIcon.png'/>
                    </button>
                    <button type='button' class='deleteButton' onclick='DeleteItem($idItem)'>
                        <img src='" . $root . "/icons/DeleteIcon.png'/>
                    </button> 
                </div>";
        }

        $content .= "
                <div class='itemDetailsImageContainer'>
                    <img src='$codePhoto'/>
                </div>
                
                <div class='itemDetailsBodyContainer'>
                    <span>Nom</span><span>$nomItem</span>
                    <span>Type</span><span>$nomType</span>";

        //Détails de l'item basés sur son type
        switch ($codeType) {

            //Armes
            case "AE":
                $newData = GetWeaponById($idItem);
                if (isset($newData) && count($newData) >= 4) {
                    $content .= "
                        <span>Efficacité</span><span>$newData[1]</span>
                        <span>Genre</span><span>$newData[2]</span>
                        <span>Description</span><span>$newData[3]</span>";
                }
                break;

            //Armures
            case "AM":
                $newData = GetArmorById($idItem);
                if (isset($newData) && count($newData) >= 3) {
                    $content .= "
                        <span>Matière</span><span>$newData[1]</span>
                        <span>Poids</span><span>$newData[2]</span>
                        <span>Taille</span><span>$newData[3]</span>";
                }
                break;

            //Potions
            case "PO":
                $newData = GetPotionById($idItem);
                if (isset($newData) && count($newData) >= 2) {
                    $content .= "
                        <span>Effet</span><span>$newData[1]</span>
                        <span>Durée (secondes)</span><span>$newData[2]</span>";
                }
                break;

            //Potions
            case "RS":
                $newData = GetRessourceById($idItem);
                if (isset($newData) && count($newData) >= 1) {
                    $content .= "<span>Description</span><span>$newData[1]</span>";
                }
                break;

            //Autres
            default:
                break;
        }

        $content .= "
                <br>
            </div>
        </div>
        <div class='popupFooterContainer'>
            <div class='itemDetailsFooter'>";

        $evaluation = GetEvaluationPreviewByIdItem($idItem);
        $starsAvg = round($evaluation[6], 1);
        $evaluationCount = $evaluation[7];
        $starBar = "";

        $starBar .= "<div class='fiveStarsContainer'>
            <div class='fiveStarsImgContainer'><img class='fiveStarsImg' src='" . $root . "icons/StarBarEmpty.png'></div>
            <div class='fiveStarsImgContainer' style='width:" . $starsAvg * 20 . "%'><img class='fiveStarsImg' src='" . $root . "icons/StarBarFull.png'></div>
        </div>";

        $starBar .= "<div class='itemStarbar'>&nbsp$starsAvg ($evaluationCount)</div>";

        $content .= "
                <div class='itemStarbarContainer'>$starBar</div>
                <div id='" . $idItem . "_showEvaluations' 
                    class='mediumButton itemDetailsContainerEvaluationButton'
                    onClick='Redirect(\"../evaluations/evaluations\",\"idItem=" . $idItem . "\")'>
                    <span>Voir les évaluations</span>
                </div>
            </div>
        </div>
      </div>";
    }

    $content .= "</div>";

    echo $content;
}

//Popup de notification quelconque
function CreateNotificationContainer()
{
    /*Création du conteneur de notification*/
    echo "
        <div id='notificationContainer' class='popupContainer notificationContainer'>
            <div class='popupHeaderContainer'>
                <span>Notification</span>
                <button id='notificationExitButton' class='popupExitButton' onclick='
                ClosePopup(\"notificationContainer\");
                CloseNotifier();
                CloseOverlay();'>x</button>
            </div>
            <div class='popupBodyContainer'>
                <br>
                <div id='notificationMessageContainer'></div>
                <br>
                <div id='confirmationButtonsContainer' class='confirmationButtonsContainer'>
                    <button id='notificationContinueButton' class='confirmButton'
                        onclick='{ ClosePopup(\"notificationContainer\"); CloseNotifier(); CloseOverlay(); }'>
                        Continuer</button>
                </div>
            </div>
            <div class='popupFooterContainer'>
            </div>
        </div>";
}

//Popup vide
function CreatePopup($title, $body, $onConfirm)
{
    $content = "
    <div id='popupContainer' class='popupContainer popupConfirmationContainer active'>
        <!-- Popup Header -->
        <div class='popupHeaderContainer'>
            <span>$title</span>
            <button class='popupExitButton' onclick='
            ClosePopup(\"popupContainer\");
            CloseNotifier();
            CloseOverlay();'>x</button>
        </div>
        
        <!-- Popup Body -->
        <div class='popupBodyContainer'>";
    $content .= $body;
    $content .= "</div>

        <!-- Popup Footer -->
        <div class='popupFooterContainer'>
            <div class='confirmationButtonsContainer'>
                <button class='popupCancelConfirmButton cancelButton' onclick='
                ClosePopup(\"popupContainer\");
                CloseNotifier();
                CloseOverlay();'>Annuler</button>";

    $content .= <<<HTML
                <button id='' 
                        class='popupQuantityConfirmButton confirmButton'
                        onclick='{ 
                    ClosePopup("popupContainer"); 
                    $onConfirm;
                    CloseNotifier();
                    CloseOverlay();}'>Confirmer</button>
HTML;

    $content .= "
            </div>
        </div>
    </div>";

    return $content;
}

//L'écran noir derrière un popup
function CreateOverlay()
{
    echo "<div id='overlay'></div>";
}