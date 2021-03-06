<?php

$conn = connectDB("167.114.152.54", "dbchevalersk13", "chevalier13", "x7ad6a84");

function connectDB($host, $dbName, $username, $password) {
    try {
        $conn = new PDO("mysql:host=$host; dbname=$dbName; charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "La connexion avec la base de donnée à échoué.";
    }
    return null;
}

function executeQuery($query, $firstOnly = false)
{
    global $conn;

    $records = [];

    if ($conn) {
        try {
            $records = $conn->query($query)->fetchall();
            if (count($records) > 0 && $firstOnly)
                    return $records[0];
        } catch (PDOException $e) { }
    }

    return $records;
}