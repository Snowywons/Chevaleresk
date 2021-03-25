<?php
/*
 * $records est une array d'items de la forme suivante:
 * [idItem,
 *  nomItem,
 *  quantiteStock,
 *  prixItem,
 *  codePhoto,
 *  codeType]
*/

function CreateItemDetailsContainers($records)
{
    foreach ($records as $data) {

        $idItem = $data[0];
        $nomItem = $data[1];
        $quantiteStock = $data[2];
        $prixItem = $data[3];
        $codePhoto = "../icons/$data[4].png";
        $codeType = $data[5];

        $nomType =
            ($codeType == "AR" ? "Arme" :
                ($codeType == "AM" ? "Armure" :
                    ($codeType == "PO" ? "Potion" : "Ressource")));

        /*Création des pages de détails pour chaque item*/
        echo "
        <div id='" . $idItem . "_itemDetailsContainer' class='popupContainer itemDetailsContainer'>
            <div class='popupHeaderContainer'>
                  <span>$nomItem</span>
                  <button class='popupExitButton'>x</button>
            </div>
            <div class='popupBodyContainer'>
                <div class='itemDetailsImageContainer'>
                    <img src='$codePhoto'/>
                </div>
                
                <div class='itemDetailsBodyContainer'>
                    <span>Nom</span><span>$nomItem</span>
                    <span>Type</span><span>$nomType</span>";

        //Détails de l'item basés sur son type
        switch ($codeType) {

            //Armes
            case "AR":
                $newData = GetWeaponById($idItem);
                if (isset($newData) && count($newData) >= 4) {
                    echo "<span>Efficacité</span><span>$newData[1]</span>
                          <span>Genre</span><span>$newData[2]</span>
                          <span>Description</span><span>$newData[3]</span>";
                }
                break;

            //Armures
            case "AM":
                $newData = GetArmorById($idItem);
                if (isset($newData) && count($newData) >= 4) {
                    echo "<span>Matière</span><span>$newData[1]</span>
                          <span>Poids</span><span>$newData[2]</span>
                          <span>Taille</span><span>$newData[3]</span>";
                }
                break;

            //Potions
            case "PO":
                $newData = GetPotionById($idItem);
                if (isset($newData) && count($newData) >= 3) {
                    echo "<span>Effet</span><span>$newData[1]</span>
                          <span>Durée (secondes)</span><span>$newData[2]</span>";
                }
                break;

            //Potions
            case "RS":
                $newData = GetRessourceById($idItem);
                if (isset($newData) && count($newData) >= 2) {
                    echo "<span>Description</span><span>$newData[1]</span>";
                }
                break;

            //Autres
            default:
                break;
        }

    echo "
            </div>
        </div>
        <div class='popupFooterContainer'>
            <div class='itemDetailsFooter'>
                <div class='itemStarbar'>
                    <img src='../icons/StarIcon.png'>
                    <img src='../icons/StarIcon.png'>
                </div>
                <button id='" . $idItem . "_showEvaluations' class='itemDetailsContainerEvaluationButton showEvaluations'>
                Voir les évaluations</button>
            </div>
        </div>
      </div>";
    }
}

function CreateItemDeleteConfirmationContainers($records)
{
    foreach ($records as $data) {

        $idItem = $data[0];

        /*Création des pages de confirmation de suppression pour chaque item*/
        echo "
        <div id='" . $idItem . "_itemDeleteConfirmationContainer' class='popupContainer itemDeleteConfirmationContainer'>
            <div class='popupHeaderContainer'>
                  <span>Attention!</span>
                  <button class='popupExitButton'>x</button>
            </div>
            <div class='popupBodyContainer'>
                <br>
                <div>
                    Êtes-vous sûr de vouloir supprimer cet item?
                </div>
            </div>
            <div class='popupFooterContainer'>
                <div class='confirmationButtonsContainer'>
                    <button class='cancelButton'>Annuler</button>
                    <button class='confirmButton'>Confirmer</button>
                </div>
            </div>
        </div>";
    }
}

function CreateNotificationContainer()
{
        /*Création du conteneur de notification*/
        echo "
        <div id='notificationContainer' class='popupContainer notificationContainer'>
            <div class='popupHeaderContainer'>
                <span>Notification</span>
                <button class='popupExitButton'>x</button>
            </div>
            <div class='popupBodyContainer'>
                <br>
                <div id='notificationMessageContainer'></div>
                <br>
            </div>
            <div class='popupFooterContainer'>
            </div>
        </div>";
}

function CreateOverlay()
{
    echo "<div id='overlay'></div>";
}
