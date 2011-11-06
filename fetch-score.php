<?php

include './config.php';
include './database.php';

session_name(SESSNAME);
session_start();

$return = array('success' => false);

$id = intval($_GET['id']);

if($id > 0) {
    $query = "select * from `votes` where `team_id` = $id";
    $result = $db->query($query);
    if($result->num_rows == 0) {
        echo(json_encode($return));
        exit;
    }
    $score = array();
    $return['score'] = array();
    while($row = $result->fetch_assoc())
        $score[$row['judge_id']] = intval($row['score']);
    for ($i = 0; $i++ < 15; ){
        if(isset($score[$i])) {
            $return['score'][] = $score[$i];
            unset($score[$i]);
        } else
            $return['score'][] = 0;
    }
    $return['score'][] = floatval(array_sum($score) / count($score));
    $return['success'] = true;
} elseif($id == 0) {
    $query = "select * from `votes`";
    $result = $db->query($query);
    if($result->num_rows == 0) {
        echo(json_encode($return));
        exit;
    }
    $scores = array();
    $return['scores'] = array();

    while($row = $result->fetch_assoc()) {
        if(! isset($scores[$row['team_id']]))
            $scores[$row['team_id']] = array();
        $scores[$row['team_id']][$row['judge_id']] = intval($row['score']);
    }
    echo '<pre>';
    foreach($scores as $team => $score) {
        $return['scores'][$team] = array();
        for ($i = 0; $i++ < 15; ) {
            if(isset($score[$i])) {
                $return['scores'][$team][] = $score[$i];
                unset($score[$i]);
            } else
                $return['scores'][$team][] = 0;
        }
        $return['scores'][$team][] = floatval(array_sum($score) / count($score));
    print_r($score);
    print_r($return);
    }
    exit;
    $return['success'] = true;
}

echo json_encode($return);

