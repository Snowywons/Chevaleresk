<?php
session_start();

function UserIsAdmin()
{
    if (isset($_SESSION["admin"]))
        return $_SESSION["admin"];
    return false;
}

function UserIsLogged()
{
    if (isset($_SESSION["logged"]))
        return $_SESSION["logged"];
    return false;
}