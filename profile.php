<?php
include_once "sessionCheck.php";
include_once "header.php";
include_once "dbUtilities.php";

/****************************************************************************************************
 * Pour exemple seulement
 ****************************************************************************************************/
$debug = false; //Mettre à true pour faire des test

if ($debug) {
    $conn = connectDB("167.114.152.54", "dbchevalersk13", "chevalier13", "x7ad6a84");
    $records = [];

    if ($conn) {
        echo "Connexion établie";
        $query = "SELECT * FROM Joueurs;";

        try {
            $records = $conn->query($query)->fetchall();
        } catch (PDOException $e) { }
    }

    var_dump($records);
}

/****************************************************************************************************/


//Exemple d'information reçu de la bd
$myInfosString = "JPaul61, Leblanc, Jean-Paul, 100, Password12345";

$myInfosArray = explode(", ", $myInfosString);
$alias = $myInfosArray[0];
$lastName = $myInfosArray[1];
$firstName = $myInfosArray[2];
$balance = $myInfosArray[3];

echo <<<HTML
    <main class='profilePage'>
        <h1>Mes informations</h1>
        <form action="">
            <fieldset>
                <label for="alias">Alias</label>
                <input type="text" id="alias" name="alias" value="$alias" disabled>
                <label for="firstName">Nom</label>
                <input type="text" id="firstName" name="firstName" value="$firstName" disabled>
                <label for="lastName">Last name:</label>
                <input type="text" id="lastName" name="lastName" value="$lastName" disabled>
                <label for="balance">Solde</label>
                <input type="text" id="balance" name="balance" value="$balance" disabled>
            </fieldset>
        </form>
    </main>
HTML;

include_once "footer.php";
?>