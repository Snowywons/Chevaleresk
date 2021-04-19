<?php
$root = "../";

include_once $root . "utilities/sessionUtilities.php";
include_once $root . "utilities/dbUtilities.php";
include_once $root . "utilities/popupUtilities.php";
include_once $root . "store/storeUpdate.php";
include_once $root . "profile/administrationUpdate.php";
include_once $root . "db/playersDT.php";
include_once $root . "db/inventoriesDT.php";
include_once $root . "db/shopping-cartsDT.php";
include_once $root . "db/itemsDT.php";
include_once $root . "db/weaponsDT.php";
include_once $root . "db/armorsDT.php";
include_once $root . "db/potionsDT.php";
include_once $root . "db/ressourcesDT.php";
include_once $root . "db/evaluationsDT.php";
include_once $root . "evaluations/evaluationsUpdate.php";

global $conn;

if (isset($_POST["submit"])) {

// ---------------------------- FILTRE ----------------------------------
    //Sur la demande d'un changement de filtre
    if ($_POST["submit"] == "setFilters") {
        $filters = isset($_POST["filters"]) ? $_POST["filters"] : "'','','',''";
        $_SESSION["filters"] = $filters;
        $alias = isset($_POST["alias"]) ? ($_POST["alias"] !== "" ? $_POST["alias"] :
            (isset($_SESSION["alias"]) ? $_SESSION["alias"] : "")) : "";

        //Mise à jour des conteneurs du store à partir de la page 'store.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "store") {
            $records = GetFilteredItems($filters);
            echo json_encode(CreateStoreContainer($records));
            exit;
        }

        //Mise à jour des conteneurs du store à partir de la page 'shopping-cart.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "shopping-cart") {
            $records = GetFilteredShoppingCartItemsByAlias($filters, $alias);
            echo json_encode(CreateShoppingCartStoreContainer($records));
            exit;
        }

        //Mise à jour des conteneurs du store à partir de la page 'inventory.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "inventory") {
            $records = GetFilteredInventoryItemsByAlias($filters, $alias);
            echo json_encode(CreateInventoryStoreContainer($records));
            exit;
        }
    }

// ---------------------------- ÉVALUATIONS ----------------------------------
    //Sur la mise à jour du contenu des évaluations
    if ($_POST["submit"] == "updateEvaluationContent") {

        $idItem = $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
        $records = GetEvaluationPreviewByIdItem($idItem);
        echo json_encode(CreateEvaluationContainer($records));
        exit;
    }

    //Sur l'envoie d'un nouveau commentaire
    if ($_POST["submit"] == "sendEvaluation") {

        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "Vous devez être connecté pour envoyer un commentaire.";
            exit;
        }

        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
        $alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
        $stars = isset($_POST["stars"]) ? $_POST["stars"] : "";
        $comment = isset($_POST["comment"]) ? $_POST["comment"] : "";

        echo AddEvaluationByIdItem($idItem, $alias, $stars, $comment);
    }

// --------------------------- PROTECTION --------------------------------
    //Protection : Si le joueur ne s'est pas authentifié
    if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
        echo "Veuillez vous connecter.";
        exit;
    }

// ---------------------------- JOUEUR ----------------------------------
    //Sur la demande de création d'un conteneur de modification de solde
    if ($_POST["submit"] == "createUpdatePlayerBalancePopup") {

        $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";
        $balance = isset($_POST["balance"]) ? $_POST["balance"] : "";

        //Initialisation des éléments du popup
        $title = "Modification";
        $body = "
                <p>Veuillez indiquer le nouveau solde de $alias</p>
                <div class='shoppingCartActionsContainer'>
                    <div class='shoppingCartQuantityContainer'>
                        <input id='" . $alias . "_playerBalance' class='itemQuantity' type='number' value='$balance'/>
                        <br><br>
                    </div>
                </div>";
        $onConfirm = "UpdatePlayerBalanceConfirm(\"$alias\", $balance)";

        echo json_encode(CreatePopup($title, $body, $onConfirm));
        exit;
    }

    //Sur la confirmation du nouveau solde d'un joueur
    if ($_POST["submit"] == "updatePlayerBalanceConfirm") {

        $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";
        $balance = isset($_POST["balance"]) ? $_POST["balance"] : "";

        ModifyPlayerBalanceByAlias($alias, $balance);
        echo "Le solde du joueur a bien été mis à jour.";
        exit;
    }

    //Sur la demande de création d'un conteneur de suppression d'un joueur
    if ($_POST["submit"] == "createDeletePlayerPopup") {

        $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";

        //Initialisation des éléments du popup
        $title = "Suppression";
        $body = "Êtes-vous sûr de vouloir supprimer ce joueur?";
        $onConfirm = "DeletePlayerConfirm(\"$alias\")";

        echo json_encode(CreatePopup($title, $body, $onConfirm));
        exit;
    }

    //Sur la confirmation de la suppression d'un joueur
    if ($_POST["submit"] == "deletePlayerConfirm") {

        $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";

        echo DeletePlayerByAlias($alias);
        exit;
    }

    //Sur la demande d'une mise à jour des informations d'un profil
    if ($_POST["submit"] == "modifyProfileInformations") {

        $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";
        $records = GetPlayerByAlias($alias);

        if (count($records) > 0) {
            $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : $records[1];
            $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : $records[2];

            ModifyPlayerNamesByAlias($alias, $lastName, $firstName);

            if (isset($_POST["password"]) && strlen($_POST["password"]) > 0)
                ModifyPlayerPasswordByAlias($alias, $_POST["password"]);

            echo "Informations enregistrées";
            exit;
        }

        echo "Le profile n'existe pas.";
        exit;
    }

    //Sur la demande d'une mise à jour du contenu du gestionnaire
    if ($_POST["submit"] == "updateManagerContent") {
        $records = GetAllPlayers();
        echo json_encode(CreateManagerContainer($records));
        exit;
    }

// ---------------------------- ITEM ----------------------------------
    //Sur la demande de création d'un conteneur de modification d'une quantité
    if ($_POST["submit"] == "createUpdateQuantityPopup") {

        $alias = isset($_POST["alias"]) ? ($_POST["alias"] !== "" ? $_POST["alias"] :
                (isset($_SESSION["alias"]) ? $_SESSION["alias"] : "")) : "";
        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
        $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";
        $sender = isset($_POST["sender"]) ? $_POST["sender"] : "";

        //Initialisation des éléments du popup
        $title = "Modification";
        $body = "
                <p>Veuillez indiquer la quantité souhaitée</p>
                <div class='shoppingCartActionsContainer'>
                    <div class='shoppingCartQuantityContainer'>
                        <button class='removeItem' onclick='RemoveItem(\"$idItem\")'>-</button>
                        <input id='" . $idItem . "_itemQuantity' class='itemQuantity' type='number' value='$quantity'/>
                        <button class='addItem' onclick='AddItem(\"$idItem\")'>+</button>
                        <br><br>
                    </div>
                </div>";
        $onConfirm = "UpdateQuantityConfirm($idItem, \"$alias\", \"$sender\")";

        echo json_encode(CreatePopup($title, $body, $onConfirm));
        exit;
    }

    //Sur la confirmation d'une quantité d'item
    if ($_POST["submit"] == "updateQuantityConfirm") {

        $alias = isset($_POST["alias"]) ? ($_POST["alias"] !== "" ? $_POST["alias"] :
                (isset($_SESSION["alias"]) ? $_SESSION["alias"] : "")) : "";
        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
        $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";

        //Demande de la page 'shopping-cart.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "shopping-cart") {
            echo ModifyItemQuantityShoppingCartByAlias($alias, $idItem, $quantity);
            exit;
        }
    }

    //Sur la demande de création d'un conteneur de suppression d'item
    if ($_POST["submit"] == "createDeleteItemPopup") {

        $alias = isset($_POST["alias"]) ? ($_POST["alias"] !== "" ? $_POST["alias"] :
            (isset($_SESSION["alias"]) ? $_SESSION["alias"] : "")) : "";
        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
        $sender = isset($_POST["sender"]) ? $_POST["sender"] : "";

        //Initialisation des éléments du popup
        $title = "Suppression";
        $body = "Êtes-vous sûr de vouloir supprimer cet item?";
        $onConfirm = "DeleteItemConfirm($idItem, \"$alias\", \"$sender\")";

        echo json_encode(CreatePopup($title, $body, $onConfirm));
        exit;
    }
    
    //Sur la confirmation de la suppression d'un item
    if ($_POST["submit"] == "deleteItemConfirm") {

        $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";
        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";

        if (isset($_POST["sender"]) && $_POST["sender"] == "store") {
            echo DeleteItemFromStoreById($idItem);
            exit;
        }

        if (isset($_POST["sender"]) && $_POST["sender"] == "shopping-cart") {
            echo DeleteItemFromShoppingCartByAlias($alias, $idItem);
            exit;
        }
    }

// ---------------------------- PANIER ----------------------------------
    //Sur le paiement du panier du joueur
    if ($_POST["submit"] == "payShoppingCart") {

        $alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";

        $message = PayShoppingCartByAlias($alias);
        $_SESSION["balance"] = GetPlayerBalanceByAlias($alias);

        echo $message;
        exit;
    }

    //Sur le calcule du panier du joueur
    if ($_POST["submit"] == "calculateShoppingCart") {

        $alias = isset($_POST["alias"]) ? ($_POST["alias"] !== "" ? $_POST["alias"] :
            (isset($_SESSION["alias"]) ? $_SESSION["alias"] : "")) : "";

        echo json_encode(CreateShoppingCartTotalContainer($alias));
        exit;
    }

// ---------------------------- MAGASIN ----------------------------------
    //Sur l'ajout d'un item au panier
    if ($_POST["submit"] == "addItemShoppingCart") {

        $alias = $_SESSION["alias"];
        $idItem = $_POST["idItem"];
        $quantity = $_POST["quantity"];

        echo AddItemShoppingCartByAlias($alias, $idItem, $quantity);
        exit;
    }

    //Sur l'ajout d'un item à la base de données
    if ($_POST["submit"] == "addItemDataBase") {

        $name = isset($_POST["name"]) ? $_POST["name"] : "";
        $type = isset($_POST["type"]) ? $_POST["type"] : "";
        $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";
        $price = isset($_POST["price"]) ? $_POST["price"] : "";
        $pictureCode = isset($_POST["pictureCode"]) ? $_POST["pictureCode"] : "DefaultIcon"; //

        switch ($type) {
            case "AR" :
                $efficiency = isset($_POST["efficiency"]) ? $_POST["efficiency"] : "";
                $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
                $description = isset($_POST["description"]) ? $_POST["description"] : "";
                echo AddWeaponStore($name, $quantity, $price, $pictureCode, $type, $efficiency, $gender, $description);
                exit;
            case "AM" :
                $material = isset($_POST["material"]) ? $_POST["material"] : "";
                $weigth = isset($_POST["weigth"]) ? $_POST["weigth"] : "";
                $size = isset($_POST["size"]) ? $_POST["size"] : "";
                echo AddArmorStore($name, $quantity, $price, $pictureCode, $type, $material, $weigth, $size);
                exit;
            case "PO" :
                $effect = isset($_POST["effect"]) ? $_POST["effect"] : "";
                $duration = isset($_POST["duration"]) ? $_POST["duration"] : "";
                echo AddPotionStore($name, $quantity, $price, $pictureCode, $type, $effect, $duration);
                exit;
            case "RS" :
                $description = isset($_POST["description"]) ? $_POST["description"] : "";
                echo AddRessourceStore($name, $quantity, $price, $pictureCode, $type, $description);
                exit;
        }

        echo "Impossible d'ajouter l'item.";
        exit;
    }
}
