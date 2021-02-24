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
        // connection
        $conn = new PDO("mysql:host=$host; dbname=$dbName; charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        var_dump($e);
//        // connection failed
//        try {
//            // creation
//            createDB($host, $dbName, $username, $password);
//            $conn = new PDO("mysql:host=$host; dbname=$dbName; charset=utf8", $username, $password);
//            return $conn;
//        } catch (PDOException $e) {
//            // creation failed
//            var_dump($e);
//        }
    }
    return null;
}