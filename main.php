<?php

include './config.php';

session_name(SESSNAME);
session_start();

$id = false;
if($_SESSION['id']) {
	$id = $_SESSION['id'];
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>MIT-CHIEF 2012</title>
		<link href="css/style.css" rel="stylesheet">
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/script.js" type="text/javascript"></script>
	</head>
	<body>
		<div id='app'>
			<header class="cf">
				<nav id="top_nav">
                    <ul>
                    	<li id="fullscreen">
                    		<a href='#'>Full Screen</a>
                    	</li>
<?php if($id) {
?>
						<li class="logout">
                        <a href="index.php?logout">#<?php echo($id); ?> Log Out</a>
                        </li>
<?php } else {
?>
						<li class="login">
							<a href="index.php">Log In</a>
						</li>
<?php } ?>
					</ul>
				</nav>
				<div id="header_wrap">
					<div class="make_hcenter">
					</div>
				</div>
			</header>
			<div class="cf" id="wrap">
				<div id="bottom_panel">
					<div id="section_tabs_container">
						<div class="inner make_hcenter">
							<ul class="section_tabs">
								<li class="selected" data-team="1">
									<span>TEAM 1</span>
								</li>
								<li data-team="2">
									<span>TEAM 2</span>
								</li>
								<li data-team="3">
									<span>TEAM 3</span>
								</li>
								<li data-team="4">
									<span>TEAM 4</span>
								</li>
								<li data-team="5">
									<span>TEAM 5</span>
								</li>
								<li data-team="6">
									<span>TEAM 6</span>
								</li>
							</ul>
						</div>
					</div>
					<div class="make_hcenter" id="sections_container">
						<div class="section cf" id="spaces_section">
							<div class="left_col">
								<h3>VOTE FOR <span id="left_col_team_name" data-team='1'>TEAM 1</span></h3>
								<div id='filter' class='<?php if (! $id) { ?>hidden<?php } ?>'>
									<span id="current-track" href="#all-tracks"><span>VOTE</span></span>
									<table id="filter-table">
										<tbody>
											<tr>
												<td data-score='1'>1</td>
												<td data-score='2'>2</td>
												<td data-score='3'>3</td>
											</tr>
											<tr>
												<td data-score='4'>4</td>
												<td data-score='5'>5</td>
												<td data-score='6'>6</td>
											</tr>
											<tr>
												<td data-score='7'>7</td>
												<td data-score='8'>8</td>
												<td data-score='9'>9</td>
											</tr>
											<tr>
												<th></th>
												<td data-score='10'>10</td>
												<th></th>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="agenda-header">
									<span class="schedule-hour">0</span><span class="schedule-hour">1</span><span class="schedule-hour">2</span><span class="schedule-hour">3</span><span class="schedule-hour">4</span><span class="schedule-hour">5</span><span class="schedule-hour">6</span><span class="schedule-hour">7</span><span class="schedule-hour">8</span><span class="schedule-hour">9</span><span class="schedule-hour">10</span>
								</div>
								<div class="agenda-row">
									<label>Xiaojun Li</label>
									<div class="agenda-item" style="width: 33px; ">
									</div>
								</div>
								<div class="agenda-row alt">
									<label>Alan Song</label>
									<div class="agenda-item">
									</div>
								</div>
								<div class="agenda-row">
									<label>Weijie Yun</label>
									<div class="agenda-item">
									</div>
								</div>
								<div class="agenda-row alt">
									<label>Stephen Tang</label>
									<div class="agenda-item">
									</div>
								</div>
								<div class="agenda-row">
									<label>Yajun Xu</label>
									<div class="agenda-item">
									</div>
								</div>
								<div class="agenda-row alt">
									<label>William Aulet</label>
									<div class="agenda-item">
									</div>
								</div>
								<div class="agenda-row">
									<label>Edward Roberts</label>
									<div class="agenda-item">
									</div>
								</div>
								<div class="agenda-row alt">
									<label>Fiona Murray</label>
									<div class="agenda-item">
									</div>
								</div>
								<div class="agenda-row alt sum">
									<label>Total</label>
									<div class="agenda-item">
									</div>
								</div>
								<div id="info-balloon">
									<h4>0.0</h4>
								</div>
							</div>
							<div class="right_col">
								<h3>RANKING</h3>
								<div class="rank-list">
									<ul>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer>
				<div id="footer_wrap">
					<div class="top_row">
						<div class="links_container">
							<div class="small_links">
								<a href='admin.php' target='_blank'>&copy;</a> Proudly Powered by <a href='http://huangtao.me/'>Tao Huang</a>, <a href='https://www.facebook.com/zilinj'>Zilin Jiang</a>, 2012 - <a href='mobile.php'>Mobile Site</a>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</body>
</html>