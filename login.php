<?php

include './config.php';
include './database.php';

$return = array('success' => false,);

if($_POST['passwd']) {
    $stmt = $db->prepare("select `id` from `judges` where `passwd` = ?");
    $stmt->bind_param('s', $_POST['passwd']);
    $stmt->execute();
    $stmt->bind_result($id);
    if($stmt->fetch()) {
        $_SESSION['id'] = $id;
        $return['success'] = true;
    }
    $stmt->close();
}

//header('content-type: application/json');
echo json_encode($return);

?>

