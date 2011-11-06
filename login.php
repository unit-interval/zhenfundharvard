<?php

include './config.php';
include './database.php';

session_name(SESSNAME);
session_start();

//$return = array('success' => false, 'id' => 0);

if($_POST['passwd']) {
    $query = "select `id` from `judges` 
        where `passwd` = '{$db->real_escape_string($_POST['passwd'])}'";
    $result = $db->query($query);
    if($row = $result->fetch_row()) {
        $_SESSION['id'] = $row[0];
//        $return['success'] = true;
//        $return['id'] = $row[0];
        header('Location: main.php');
        exit;
    }
    $result->free();
}

//header('content-type: application/json');
//echo json_encode($return);
header('Location: index.php');
exit;

?>

