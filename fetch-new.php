<?php

include './config.php';
include './database.php';

session_name(SESSNAME);
session_start();

exit('abc');

$return = array('success' => false, 'score' => array());

$id = intval($_GET['id']);

exit($id);

if($id > 0) {
    $query = "select * from `votes` where `team_id` = $id";
    $result = $db->query($query);
    if($result->num_rows = 0)
        exit(json_encode($return));

    $return['score'][$id] = array();
    $score = array();

    while($row = $result->fetch_assoc())
        $score[$row['judge_id']] = $row['score'];
    for ($i = 1; $i++ <= 15; ){
        if(isset($score[$i])) {
            $return['score'][$id][] = $score[$i];
            unset($score[$i]);
        } else
            $return['score'][$id][] = 0;
        $return['score'][$id][] = array_sum($score) / count($score);
    }
} else {
    $query = "select * from `votes`";
    $result = $db->query($query);

    if($result->num_rows = 0)
        exit(json_encode($return));

    $score = array();

    while($row = $result->fetch_assoc()) {
        if(! isset($score[$row['team_id']]))
            $score[$row['team_id']] = array();
        $score[$row['team_id']]['judge_id'] = $row['score'];
    }

    foreach($score as $k => $v) {
        $return['score'][$k] = array();
        for ($i = 1; $i++ <= 15; ) {
            if(isset($v[$i])) {
                $return['score'][$k][] = $v[$i];
                unset($v[$i]);
            } else
                $return['score'][$k][] = 0;
            $return['score'][$k][] = array_sum($v) / count($v);
        }
    }
}

$return['success'] = true;

echo json_encode($return);

