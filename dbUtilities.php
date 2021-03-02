<?php

function hostConnect($host, $username, $password) {
    try {
        $conn = new PDO("mysql:host=$host", $username, $password);
        return $conn;
    }
    catch (PDOException $e) {
        var_dump($e);
    }
    return null;
}

function createDB($host, $dbName, $username, $password) {
    try {
        $conn = hostConnect($host, $username, $password);
        if ($conn != null) {
            $conn->exec("CREATE DATABASE $dbName");
            return true;
        }
    }
    catch (PDOException $e) {
        var_dump($e);
    }
    return false;
}

function deleteDB($host, $dbName, $username, $password) {
    try {
        $conn = hostConnect($host, $username, $password);
        if ($conn != null) {
            $conn->exec("DROP DATABASE $dbName");
            return true;
        }
    }
    catch (PDOException $e) {
        var_dump($e);
    }
    return false;
}

function connectDB($host, $dbName, $username, $password) {
    try {
        $conn = new PDO("mysql:host=$host; dbname=$dbName; charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "La connexion avec la base de donnée à échouée.";
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