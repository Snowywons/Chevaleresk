<?php

/******************************************
 *              À COMPLÉTER
 ******************************************/

//Doit recevoir un array d'idItem, ex: [0, 2, 9, 18, 20]
function CreateItemDetailsContainers($idItems)
{
    global $conn;

    foreach ($idItems as $idItem) {

        $data = [];

        if ($conn) {
            $query = "SELECT nomItem, photoItem, codeType FROM Items WHERE idItem = $idItem;";
            try {
                $data = $conn->query($query)->fetchall()[0];
            } catch (PDOException $e) { }
        }

        $nomItem = $data[0];
        $photoItem = "/Chevaleresk/icons/ChevalereskIcon.png"; //devrait être $data[1]
        $codeType = $data[2];

        if ($conn) {
            $query = "SELECT nomType FROM TypesItem WHERE codeType='$codeType';";
            try {
                $data = $conn->query($query)->fetchall()[0];
            } catch (PDOException $e) { }
        }

        $nomType = $data[0];

        /*Création des pages de détails pour chaque item*/
        echo "
      <div id='" . $idItem . "_details' class='itemDetailsContainer'>
            <div class='itemDetailsHeader'>
                  <span>$nomItem</span>
                  <button class='itemDetailsContainerExitButton'>x</button>
            </div>
            
            <div class='itemDetailsImageContainer'>
                <img src='$photoItem'/>
            </div>
            
            <div class='itemDetailsBodyContainer'>
                <span>Nom</span><span>$nomItem</span>
                <span>Type</span><span>$nomType</span>
            ";

        //Détails de l'item basés sur son type
        switch($codeType)
        {
            //Potions
            case "PO":

                if ($conn) {
                    $query = "SELECT effetPotion, dureePotion FROM Potions P WHERE P.idItem = $idItem;";
                    try {
                        $data = $conn->query($query)->fetchall()[0];
                    } catch (PDOException $e) { }
                }

                $effetPotion = $data[0];
                $dureePotion = $data[1];

                echo "
                        <span>Effet</span><span>$effetPotion</span>
                        <span>Durée</span><span>$dureePotion</span>";
                break;

            //Armures
            case "AU":

                if ($conn) {
                    $query = "SELECT matiereArmure, poidsArmure, tailleArmure FROM Armures A WHERE A.idItem = $idItem;";
                    try {
                        $data = $conn->query($query)->fetchall()[0];
                    } catch (PDOException $e) { }
                }

                $matiereArmure = $data[0];
                $poidsArmure = $data[1];
                $tailleArmure = $data[2];

                echo "
                        <span>Matière</span><span>$matiereArmure</span>
                        <span>Poids</span><span>$poidsArmure</span>
                        <span>Taille</span><span>$tailleArmure</span>";
                break;

            //Armes
            case "AE":

                if ($conn) {
                    $query = "SELECT efficaciteArme, genreArme, descriptionArme FROM Armes A WHERE A.idItem = $idItem;";
                    try {
                        $data = $conn->query($query)->fetchall()[0];
                    } catch (PDOException $e) { }
                }

                $efficaciteArme = $data[0];
                $genreArme = $data[1];
                $descriptionArme = $data[2];

                echo "
                        <span>Efficacité</span><span>$efficaciteArme</span>
                        <span>Genre</span><span>$genreArme</span>
                        <span>Description</span><span>$descriptionArme</span>";
                break;

            //Autres
            default:
                break;
        }

        echo "
        </div>
        <div class='itemDetailsFooter'>
            <div class='itemDetailsStarbar'>
                <img src='/Chevaleresk/icons/StarIcon.png'>
                <img src='/Chevaleresk/icons/StarIcon.png'>
            </div>
            <button id='" .$idItem."_showEvaluations' class='itemDetailsContainerEvaluationButton showEvaluations'>
            Voir les évaluations</button>
            
        </div>
      </div>";
    }

    echo "<div id='overlay'></div>";
}
