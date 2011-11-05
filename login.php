<?php

include './config.php';
include './database.php';

$return = array('success' => false,);

if($_POST['passwd']) {
    $query = "select `id` from `judges` 
        where `passwd` = '{$db->real_escape_string($_POST['passwd'])}'";
    $result = $db->query($query);
    if($row = $result->fetch_row()) {
        $_SESSION['id'] = $row[0];
        $return['success'] = true;
    }
    $result->free();
}

//header('content-type: application/json');
echo json_encode($return);

?>

