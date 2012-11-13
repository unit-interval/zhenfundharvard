<?php

include './config.php';
include './database.php';

session_name(SESSNAME);
session_start();

if($_POST['passwd']) {
    $query = "select `id` from `judges` 
        where `passwd` = '{$db->real_escape_string($_POST['passwd'])}'";
    $result = $db->query($query);
    if($row = $result->fetch_row()) {
        $_SESSION['id'] = $row[0];
        if($_SESSION['mobile'])
            header('Location: mobile.php');
        else
            header('Location: main.php');
        exit;
    }
    $result->free();
}

if($_SESSION['mobile'])
    header('Location: mobile.php');
else
    header('Location: index.php');
exit;

?>