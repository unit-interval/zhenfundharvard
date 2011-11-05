<?php

include './config.php';
include './database.php';

session_name(SESSNAME);
session_start();

$return = array('success' => false, 'score' => array());

$id = intval($_GET['id']);

if($id > 0) {
    $query = "select * from `votes` where `team_id` = $id";
    $result = $db->query($query);
    if($result->num_rows == 0) {
        echo(json_encode($return));
        exit;
    }

    $return['score'][$id] = array();
    $score = array();

    while($row = $result->fetch_assoc())
        $score[$row['judge_id']] = intval($row['score']);
    for ($i = 0; $i++ < 15; ){
        if(isset($score[$i])) {
            $return['score'][$id][] = $score[$i];
            unset($score[$i]);
        } else
            $return['score'][$id][] = 0;
    }
    $return['score'][$id][] = floatval(array_sum($score) / count($score));
} else {
    $query = "select * from `votes`";
    $result = $db->query($query);
//    if($result->num_rows == 0) {
    if(true) {
        echo(json_encode($return));
        exit;
    }

    $score = array();

    while($row = $result->fetch_assoc()) {
        if(! isset($score[$row['team_id']]))
            $score[$row['team_id']] = array();
        $score[$row['team_id']]['judge_id'] = intval($row['score']);
    }

    foreach($score as $k => $v) {
        $return['score'][$k] = array();
        for ($i = 0; $i++ < 15; ) {
            if(isset($v[$i])) {
                $return['score'][$k][] = $v[$i];
                unset($v[$i]);
            } else
                $return['score'][$k][] = 0;
        }
        $return['score'][$k][] = floatval(array_sum($v) / count($v));
    }
}

$return['success'] = true;

echo json_encode($return);

