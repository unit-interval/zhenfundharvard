<?php

include './config.php';
include './database.php';

/** prepare session cookie */
session_name(SESSNAME);
session_start();

$_SESSION['mobile'] = true;

?>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>iWeekend Beijing Autumn 2011</title>
		<link href="./css/mobile.css" rel="stylesheet" type="text/css">
	</head>
	<body id="index" screen_capture_injected="true">
		<div id="wrapper">
			<div id="container">
				<div id="header">
					<img width="100%" src="images/iweekend-header-bgd.png" />
				</div>
				<div id="content">
<?php

if($_SESSION['id']) {
    if($_POST['team_id'] && $_POST['score']) {
        $query = "insert into `votes` values ({$_POST['team_id']}, {$_SESSION['id']}, {$_POST['score']})
            on duplicate key update `score` = {$_POST['score']}";
        $db->query($query);
    }
    if($_GET['t']) {
        $team_id = $_GET['t'];
?>
					<form id="vote" action="mobile.php" id="login" method="post">
						<input type="submit" name="score" value="1"/>
						<input type="submit" name="score" value="2"/>
						<input type="submit" name="score" value="3"/>
						<input type="submit" name="score" value="4"/>
						<input type="submit" name="score" value="5"/>
						<input type="submit" name="score" value="6"/>
						<input type="submit" name="score" value="7"/>
						<input type="submit" name="score" value="8"/>
						<input type="submit" name="score" value="9"/>
						<input class="inv" type="submit" value="<"/>
						<input type="submit" name="score" value="10"/>
                        <input type="hidden" name="team_id" value="<?php echo($team_id); ?>" />
					</form>
<?php
    } else {
?>
					<ul id="nav">
						<li><a href="mobile.php?t=1">TEAM 1</a></li>
						<li><a href="mobile.php?t=2">TEAM 2</a></li>
						<li><a href="mobile.php?t=3">TEAM 3</a></li>
						<li><a href="mobile.php?t=4">TEAM 4</a></li>
						<li><a href="mobile.php?t=5">TEAM 5</a></li>
						<li><a href="mobile.php?t=6">TEAM 6</a></li>
					</ul>
<?php
    }
} else {
?>
					<form action="login.php" id="login" method="post">
						<input id="user_password" placeholder="Password" maxlength="20" name="passwd" size="8" type="password">
						<input id="save_button_login" type="submit" value="Login"/>
					</form>
<?php
}

?>
				</div>
			</div>
		</div>
		<div id="footer">
			<div id="footer-content">
				© Proudly Powered by <a href="http://huangtao.me/">Tao Huang</a>, <a href="https://www.facebook.com/zilinj">Zilin Jiang</a>, 2011
			</div>
		</div>
	</body>
</html>
