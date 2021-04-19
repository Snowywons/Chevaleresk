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

    //Sur un changement de filtre
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

    //Sur l'ajout d'un item au panier
    if ($_POST["submit"] == "addItemShoppingCart") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = $_SESSION["alias"];
        $idItem = $_POST["idItem"];
        $quantity = $_POST["quantity"];

        echo AddItemShoppingCartByAlias($alias, $idItem, $quantity);
        exit;
    }

    //Sur la création d'un conteneur de modification d'une quantité
    if ($_POST["submit"] == "createQuantityContainer") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = isset($_POST["alias"]) ? ($_POST["alias"] !== "" ? $_POST["alias"] :
            (isset($_SESSION["alias"]) ? $_SESSION["alias"] : "")) : "";
        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
        $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";
        $sender = isset($_POST["sender"]) ? $_POST["sender"] : "";

        echo json_encode(CreateQuantityContainer($idItem, $quantity, $alias, $sender));
        exit;
    }

    //Sur la modification de quantité d'un item
    if ($_POST["submit"] == "quantityConfirm") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = isset($_POST["alias"]) ? ($_POST["alias"] !== "" ? $_POST["alias"] :
                (isset($_SESSION["alias"]) ? $_SESSION["alias"] : "")) : "";
        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
        $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";

        //Demande de la page 'store.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "store") {
            echo "Cette fonctionnalité n'existe pas.";
            exit;
        }

        //Demande de la page 'shopping-cart.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "shopping-cart") {
            echo ModifyItemQuantityShoppingCartByAlias($alias, $idItem, $quantity);
            exit;
        }

        //Demande de la page 'inventory.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "inventory") {
            echo ModifyItemQuantityInventoryByAlias($alias, $idItem, $quantity);
            exit;
        }
    }

    //Sur la création d'un conteneur de suppression d'item
    if ($_POST["submit"] == "createDeleteContainer") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = isset($_POST["alias"]) ? ($_POST["alias"] !== "" ? $_POST["alias"] :
            (isset($_SESSION["alias"]) ? $_SESSION["alias"] : "")) : "";
        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
        $sender = isset($_POST["sender"]) ? $_POST["sender"] : "";

        echo json_encode(CreateItemDeleteContainer($idItem, $alias, $sender));
        exit;
    }

    //Sur la suppression d'un item
    if ($_POST["submit"] == "deleteConfirm") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";
        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";

        //Demande de la page 'store.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "store") {
            echo DeleteItemFromStoreById($idItem);
            exit;
        }

        //Demande de la page 'shopping-cart.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "shopping-cart") {
            echo DeleteItemFromShoppingCartByAlias($alias, $idItem);
            exit;
        }

        //Demande de la page 'inventory.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "inventory") {
            echo DeleteItemFromInventoryByAlias($alias, $idItem);
            exit;
        }

        //Demande de la page 'administration.php'
        if (isset($_POST["sender"]) && $_POST["sender"] == "administration") {
            $alias = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
            echo DeletePlayerByAlias($alias);
            exit;
        }
    }

    //Sur le paiement du panier du joueur
    if ($_POST["submit"] == "payShoppingCart") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";

        $message = PayShoppingCartByAlias($alias);
        $_SESSION["balance"] = GetPlayerBalanceByAlias($alias);

        echo $message;
        exit;
    }

    //Sur le calcule du panier du joueur
    if ($_POST["submit"] == "calculateShoppingCart") {

        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = isset($_POST["alias"]) ? ($_POST["alias"] !== "" ? $_POST["alias"] :
            (isset($_SESSION["alias"]) ? $_SESSION["alias"] : "")) : "";

        echo json_encode(CreateShoppingCartTotalContainer($alias));
        exit;
    }

    //Sur la mise à jour du contenu du gestionnaire
    if ($_POST["submit"] == "updateManagerContent") {
        $records = GetAllPlayers();
        echo json_encode(CreateManagerContainer($records));
        exit;
    }

    //Sur la mise à jour des informations d'un profil
    if ($_POST["submit"] == "modifyProfileInformations") {
        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $alias = isset($_POST["alias"]) ? $_POST["alias"] : "";
        $records = GetPlayerByAlias($alias);

        if (count($records) > 0) {
            $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : $records[1];
            $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : $records[2];
            $balance = isset($_POST["balance"]) ? $_POST["balance"] : $records[3];


            ModifyPlayerNamesByAlias($alias, $lastName, $firstName);
            ModifyPlayerBalanceByAlias($alias, $balance);

            if (isset($_POST["password"]) && strlen($_POST["password"]) > 0)
                ModifyPlayerPasswordByAlias($alias, $_POST["password"]);

            echo "Informations enregistrées";
            exit;
        }

        echo "Le profile n'existe pas.";
    }

    //Sur l'ajout d'un item à la base de données
    if ($_POST["submit"] == "addItemDataBase") {
        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

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

    //Sur la mise à jour du contenu des évaluations
    if ($_POST["submit"] == "updateEvaluationContent") {
        $idItem = $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
        $records = GetEvaluationPreviewByIdItem($idItem);
        echo json_encode(CreateEvaluationContainer($records));
        exit;
    }

    //Sur l'envoie d'un nouveau commentaire
    if ($_POST["submit"] == "sendEvaluation") {
        //Si le joueur ne s'est pas authentifié
        if (!isset($_SESSION["logged"]) || !$_SESSION["logged"]) {
            echo "notLogged";
            exit;
        }

        $idItem = isset($_POST["idItem"]) ? $_POST["idItem"] : "";
        $alias = isset($_SESSION["alias"]) ? $_SESSION["alias"] : "";
        $stars = isset($_POST["stars"]) ? $_POST["stars"] : "";
        $comment = isset($_POST["comment"]) ? $_POST["comment"] : "";

        echo AddEvaluationByIdItem($idItem, $alias, $stars, $comment);
    }
}
