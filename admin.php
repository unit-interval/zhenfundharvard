<?php

include './config.php';
include './database.php';

session_name(SESSNAME);
session_start();

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
    $html = "<form id='matrix'><table><thead><tr>";
    for($i = 1; $i <= NUM_TEAMS; $i++)
        $html .= "<td>Team $i</td>";
    $html .= "</tr></thead><tbody";
    //"</table>";
    echo "$html";
}
?>
    </body>
</html>
