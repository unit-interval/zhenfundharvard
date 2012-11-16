<?php

include './config.php';
include './database.php';

session_name(SESSNAME);
session_start();

function update_score() {
    global $db;
    unset($_POST['do']);
    unset($_POST['form']);
    foreach($_POST as $k => $v) {
        if(! $v)
            continue;
        $pos = strpos($k, '-');
        $judge = substr($k, 0, $pos);
        $team = substr($k, $pos + 1);
        $query = "insert into `votes` values ($team, $judge, $v)
            on duplicate key update `score` = $v";
        $db->query($query);
    }
}

if($_POST['passphrase'] == ADMIN_PW) {
	$_SESSION['admin'] = true;
	$admin_once = true;
}
?>
<html>
    <body>
        <form action='admin.php' method='post'>
            <input type='password' name='passphrase' /><br />
            <input type='submit' name='do' value='show' />
            <input type='submit' name='do' value='votes' />
            <input type='submit' name='do' value='console' /> | 
            <input type='submit' name='do' value='reset' />
        </form>
		<hr />
<?php
if(! $_SESSION['admin']) {
    echo 'not authenticated.';
    exit;
}
if($_POST['do'] == 'reset') {
    if($admin_once) {
        $db->query("truncate `votes`");
        echo "<p>successifully trancated table 'votes'.</p>";
    } else
        echo "<p>passphrase needed for this operation.</p>";
} elseif($_POST['do'] == 'votes') {
    echo "<table><thead><tr><td>judge</td><td>team</td><td>score</td></tr></thead><tbody>";
    $query = "select * from `votes` order by `judge_id`";
    $result = $db->query($query);
    while($row = $result->fetch_assoc())
        echo "<tr><td>{$row['judge_id']}</td><td>{$row['team_id']}</td><td>{$row['score']}</td></tr>";
    $result->free();
    echo "</tbody></table>";
} elseif($_POST['do'] == 'show') {
    echo "<table><thead><tr><td>#</td><td>passwd</td></tr></thead><tbody>";
    $query = "select * from `judges` order by `id`";
    $result = $db->query($query);
    while($row = $result->fetch_assoc())
        echo "<tr><td>{$row['id']}</td><td>{$row['passwd']}</td></tr>";
    $result->free();
    echo "</tbody></table>";
} elseif($_POST['do'] == 'console') {
    if($_POST['form'] == 'update')
        update_score();

    $query = "select * from `votes` where `judge_id` < 16 or`judge_id` > 99";
    $result = $db->query($query);
    $r = array();
    while($row = $result->fetch_assoc()) {
        if(! isset($r[$row['judge_id']]))
            $r[$row['judge_id']] = array();
        $r[$row['judge_id']][$row['team_id']] = $row['score'];
    }
    $result->free();

    $html = "<form action='admin.php' method='post'>
        <input type='submit' name='form' value='update' /><br />
        <input type='hidden' name='do' value='console' />
        <table><thead><tr><td>Judge #</td>";
    for($i = 1; $i <= NUM_TEAMS; $i++)
        $html .= "<td>Team $i</td>";
    $html .= "</tr></thead>\n<tbody>";
    for($i = 1; $i <= NUM_JUDGES; $i++) {
        $html .= "<tr><td>$i</td>";
        for($j = 1; $j <= NUM_TEAMS; $j++)
            $html .= "<td><input type='text' name='$i-$j' value='{$r[$i][$j]}' /></td>";
        $html .= "</tr>\n";
    }
    /*
     * audience
     *
    for($i = 100; $i <= 110; $i++) {
        $html .= "<tr><td>$i</td>";
        for($j = 1; $j <= NUM_TEAMS; $j++)
            $html .= "<td><input type='text' name='$i-$j' value='{$r[$i][$j]}' /></td>";
        $html .= "</tr>\n";
    }
    */
    $html .= "</tbody></table></form>";
    echo "$html";
}
?>
    </body>
</html>
