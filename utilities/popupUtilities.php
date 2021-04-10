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
        $codePhoto = "../icons/$data[4].png";
        $codeType = $data[5];

        $nomType =
            ($codeType == "AR" ? "Arme" :
                ($codeType == "AM" ? "Armure" :
                    ($codeType == "PO" ? "Potion" : "Ressource")));

        /*Création des pages de détails pour chaque item*/
        $content .= "
            <div id='" . $idItem . "_itemDetailsContainer' class='popupContainer itemDetailsContainer'>
                <div class='popupHeaderContainer'>
                    <span>$nomItem</span>
                    <button class='popupExitButton'>x</button>
                </div>
                <div class='popupBodyContainer'>";

        if ($isAdmin) {
            $content .= "
                <div class='adminButtonsContainer'>
                    <button id='" . $idItem . "_modifyButton' class='modifyButton'>
                        <img src='" . $root . "/icons/EditIcon.png'/>
                    </button>
                    <button id='" . $idItem . "_deleteButton' class='deleteButton'>
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
            case "AR":
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
                if (isset($newData) && count($newData) >= 4) {
                    $content .= "
                        <span>Matière</span><span>$newData[1]</span>
                        <span>Poids</span><span>$newData[2]</span>
                        <span>Taille</span><span>$newData[3]</span>";
                }
                break;

            //Potions
            case "PO":
                $newData = GetPotionById($idItem);
                if (isset($newData) && count($newData) >= 3) {
                    $content .= "
                        <span>Effet</span><span>$newData[1]</span>
                        <span>Durée (secondes)</span><span>$newData[2]</span>";
                }
                break;

            //Potions
            case "RS":
                $newData = GetRessourceById($idItem);
                if (isset($newData) && count($newData) >= 2) {
                    $content .= "<span>Description</span><span>$newData[1]</span>";
                }
                break;

            //Autres
            default:
                break;
        }

        $content .= "
            </div>
        </div>
        <div class='popupFooterContainer'>
            <div class='itemDetailsFooter'>
                <div class='itemStarbar'>
                    <img src='../icons/StarIcon.png'>
                    <img src='../icons/StarIcon.png'>
                </div>
                <div id='" . $idItem . "_showEvaluations' 
                class='mediumButton itemDetailsContainerEvaluationButton showEvaluations'>
                    <span>Voir les évaluations</span>
                </div>
            </div>
        </div>
      </div>";
    }

    $content .= "</div>";
    

    echo $content;
}

//Popup de supression d'un item
function CreateItemDeleteContainer($idItem, $alias, $sender)
{
    $content = "
        <div>
            <div id='" . $idItem . "_popupConfirmationContainer' class='popupContainer popupConfirmationContainer active'>
                <div class='popupHeaderContainer'>
                      <span>Attention!</span>
                      <button class='popupExitButton'>x</button>
                </div>
                <div class='popupBodyContainer'>
                    <br>
                    <div>";

    if ($sender === "store") {
        $content .= "Êtes-vous sûr de vouloir supprimer cet item du magasin?";
    } else if ($sender === "shopping-cart") {
        $content .= "Êtes-vous sûr de vouloir supprimer cet item du panier?";
    } else if ($sender === "inventory") {
        $content .= "Êtes-vous sûr de vouloir supprimer cet item de l'inventaire?";
    } else if ($sender === "administration") {
        $content .= "Êtes-vous sûr de vouloir supprimer l'utilisateur ". $idItem . " ?";
    }

    $content .= "
                </div>
            </div>
            <div class='popupFooterContainer'>
                <div class='confirmationButtonsContainer'>
                    <button id='" . $idItem . "_' 
                            class='popupCancelConfirmButton cancelButton'>Annuler</button>
                    <button id='" . $idItem . "_" . $alias . "_" . $sender . "' 
                            class='popupDeleteConfirmButton confirmButton'>Confirmer</button>
                </div>
            </div>
        </div>
    </div>";

    return $content;
}

//Popup de modification d'une quantité
function CreateQuantityContainer($idItem, $quantity, $alias, $sender) {
    $content = "
        <div>
            <div id='" . $idItem . "_popupConfirmationContainer' class='popupContainer popupConfirmationContainer active'>
                <div class='popupHeaderContainer'>
                      <span>Modification</span>
                      <button class='popupExitButton'>x</button>
                </div>
                <div class='popupBodyContainer'>
                    <br>
                    <div>";

                    if ($sender === "shopping-cart") {
                        $content .= "Veuillez indiquer la quantité souhaitée.<br><br>";
                    } else if ($sender === "inventory") {
                        $content .= "";
                    } else if ($sender === "administration") {
                        $content .= "";
                    }

                        $content .= "
                            <div class='shoppingCartActionsContainer'>
                                <div class='shoppingCartQuantityContainer'>
                                    <button id='" . $idItem . "_removeItem' class='removeItem'>-</button>
                                    <input id='" . $idItem . "_itemQuantity' class='itemQuantity' type='number' value='$quantity'/>
                                    <button id='" . $idItem . "_addItem' class='addItem'>+</button>
                                    <br><br>
                                </div>
                            </div>";

    $content .= "
                </div>
            </div>
            <div class='popupFooterContainer'>
                <div class='confirmationButtonsContainer'>
                    <button id='" . $idItem . "_' 
                            class='popupCancelConfirmButton cancelButton'>Annuler</button>
                    <button id='" . $idItem . "_" . $alias . "_" . $sender . "' 
                            class='popupQuantityConfirmButton confirmButton'>Confirmer</button>
                </div>
            </div>
        </div>
    </div>";

    return $content;
}

//Popup de notification quelconque
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

//L'écran noir derrière un popup
function CreateOverlay()
{
    echo "<div id='overlay'></div>";
}
