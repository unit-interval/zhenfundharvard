<?php

include './config.php';

session_name(SESSNAME);
session_start();

$id = false;
if($_SESSION['id'])
    $id = $_SESSION['id'];

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>ZhenFund @ Harvard</title>
		<link href="css/style.css" rel="stylesheet">
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/script.js" type="text/javascript"></script>
	</head>
	<body>
		<div id='app'>
			<header class="cf">
				<div id="header_wrap">
					<div class="make_hcenter">
						<nav id="top_nav">
                            <ul>
                            	<li class="logo">
									<a href="http://www.zhenfund.com/"><span id="Zhen">Zhen</span><span id="Fund">Fund</span> @ Harvard</a>
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
					</div>
				</div>
			</header>
			<div class="cf" id="wrap">
				<div id="bottom_panel">
					<div id="section_tabs_container">
						<div class="arrow left"></div>
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
								<li data-team="7">
									<span>TEAM 7</span>
								</li>
								<li data-team="8">
									<span>TEAM 8</span>
								</li>
								<li data-team="9">
									<span>TEAM 9</span>
								</li>
								<li data-team="10">
									<span>TEAM 10</span>
								</li>
								<li data-team="11">
									<span>TEAM 11</span>
								</li>
								<li data-team="12">
									<span>TEAM 12</span>
								</li>
								<li data-team="13">
									<span>TEAM 13</span>
								</li>
								<li data-team="14">
									<span>TEAM 14</span>
								</li>
								<li data-team="15">
									<span>TEAM 15</span>
								</li>
								<li data-team="16">
									<span>TEAM 16</span>
								</li>
								<li data-team="17">
									<span>TEAM 17</span>
								</li>
								<li data-team="18">
									<span>TEAM 18</span>
								</li>
								<li data-team="19">
									<span>TEAM 19</span>
								</li>
								<li data-team="20">
									<span>TEAM 20</span>
								</li>
								<li data-team="21">
									<span>TEAM 21</span>
								</li>
								<li data-team="22">
									<span>TEAM 22</span>
								</li>
								<li data-team="23">
									<span>TEAM 23</span>
								</li>
								<li data-team="24">
									<span>TEAM 24</span>
								</li>
								<li data-team="25">
									<span>TEAM 25</span>
								</li>
								<li data-team="26">
									<span>TEAM 26</span>
								</li>
								<li data-team="27">
									<span>TEAM 27</span>
								</li>
								<li data-team="28">
									<span>TEAM 28</span>
								</li>
								<li data-team="29">
									<span>TEAM 29</span>
								</li>
								<li data-team="30">
									<span>TEAM 30</span>
								</li>
								<li data-team="31">
									<span>TEAM 31</span>
								</li>
								<li data-team="32">
									<span>TEAM 32</span>
								</li>
								<li data-team="33">
									<span>TEAM 33</span>
								</li>
								<li data-team="34">
									<span>TEAM 34</span>
								</li>
								<li data-team="35">
									<span>TEAM 35</span>
								</li>
								<li data-team="36">
									<span>TEAM 36</span>
								</li>
								<li data-team="37">
									<span>TEAM 37</span>
								</li>
								<li data-team="38">
									<span>TEAM 38</span>
								</li>
								<li data-team="39">
									<span>TEAM 39</span>
								</li>
								<li data-team="40">
									<span>TEAM 40</span>
								</li>
							</ul>
						</div>
						<div class="arrow right"></div>
					</div>
					<div class="make_hcenter" id="sections_container">
						<div class="section cf" id="spaces_section">
							<div class="left_col">
								<h3>VOTE FOR <span id="left_col_team_name" data-team='1'>TEAM 1</span></h3>
								<div id='filter'>
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
									<label>Judge 1</label>
									<div class="agenda-item" style="width: 33px; ">
										<span>•</span>
									</div>
								</div>
								<div class="agenda-row alt">
									<label>Judge 2</label>
									<div class="agenda-item" style="width: 33px; ">
										<span>•</span>
									</div>
								</div>
								<div class="agenda-row">
									<label>Judge 3</label>
									<div class="agenda-item" style="width: 33px; ">
										<span>•</span>
									</div>
								</div>
								<div class="agenda-row alt">
									<label>Judge 4</label>
									<div class="agenda-item" style="width: 33px; ">
										<span>•</span>
									</div>
								</div>
								<div class="agenda-row">
									<label>Judge 5</label>
									<div class="agenda-item" style="width: 33px; ">
										<span>•</span>
									</div>
								</div>
								<div class="agenda-row alt ivy">
									<label>Ivy League</label>
									<div class="agenda-item" style="width: 33px; ">
										<span>•</span>
									</div>
								</div>
								<div class="agenda-row sum">
									<label>Total</label>
									<div class="agenda-item" style="width: 33px; ">
										<span>•</span>
									</div>
								</div>
								<div id="info-balloon">
									<h4>10.0</h4>
								</div>
							</div>
							<div class="right_col">
								<h3>TOP TEN</h3>
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
								&copy; Proudly Powered by <a href='https://www.facebook.com/huangtao.me'>Tao Huang</a>, <a href='https://www.facebook.com/zilinj'>Zilin Jiang</a>, 2011
							</div>
						</div>
						<div class="feedback_link_container">
							<a href="http://www.cmu.edu">Carnegie Mellon University</a>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</body>
