<?php

include './config.php';
include './database.php';

session_name(SESSNAME);
session_start();

$return = array('success' => false);

if(! $_SESSION['id']) {
    echo json_encode($return);
    exit;
}

$j_id = $_SESSION['id'];
$t_id = intval($_GET['team_id']);
$score = intval($_GET['score']);

if($score > 10 || $score < 1) {
    echo json_encode($return);
    exit;
}

$query = "insert into `votes` values ($t_id, $j_id, $score)
    on duplicate key update `score` = $score";
$db->query($query);

$return['success'] = true;
echo json_encode($return);
exit;
