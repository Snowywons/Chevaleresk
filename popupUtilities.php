<?php

/******************************************
 *              À COMPLÉTER
 ******************************************/

/*Doit recevoir un array de la forme: idItem, nomItem*/
function CreateItemDetailsContainers($items)
{
    foreach ($items as $data) {
        $idItem = $data[0];
        $nomItem = $data[1];
        $photoItem = "./Icons/ChevalereskIcon.png";

        /*Création des pages de détails pour chaque item*/
        echo "
      <div id='".$idItem."_details' class='itemDetailsContainer'>
        <div class='itemDetailsHeader'>
          <span>$nomItem</span>
          <button class='itemDetailsContainerExitButton'>x</button>
        </div>
        <div class='itemDetailsImageContainer'>
            <img src='$photoItem'/>
        </div>
      </div>";
    }

    echo "<div id='overlay'></div>";
}
