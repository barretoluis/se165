<?php
//TODO: Add logic to check if user is or isn't logged in

/*
 * Give navigtion based on user's authentication.
 */

/*
 * Pseudo Code
 * - check session for logged in state
 * - if loggedIn, show logged in nav
 * - else, show default nav
 */

//Variables
$loggedIn = FALSE;

//User login status check and set show navigation variable
if (isset($_SESSION['loginState']) && $_SESSION['loginState'] == 1) {
	$loggedIn = TRUE;
}
?>

<?php if ($loggedIn) { //show logged in-nav ?>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="nav-collapse collapse">
					<ul class="nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #00B800; font-size: 20px;">Tackster <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/myTacks.php">My Tacks</a></li>
								<li><a href="/followingTacks.php">Following Tacks</a></li>
								<li><a href="/dashboard.php">Suggested Bookmarks</a></li>
								<li class="divider"></li>
								<li><a href="/profile.php">Profile</a></li>
								<li>LOGGED IN</li>
							</ul>
						</li>
					</ul>
					<form action="/search/" method="post" name="searchBmk" id="searchBmk" class="navbar-search pull-left">
						<input type="text" class="search-query" placeholder="Search">
					</form>

					<div class="btn-group pull-right">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
							Username <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Settings</a></li>
							<li><a href="/index.php">Logout</a></li>
						</ul>
					</div> <!-- closing btn-group -->
				</div>
			</div>  <!-- closing container-fluid-->
		</div>  <!-- closing navbar-inner-->
	</div>  <!-- closing navbar-->

<?php } else { //show standard nav ?>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="nav-collapse collapse">
					<ul class="nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #00B800; font-size: 20px;">Tackster <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/myTacks.php">My Tacks</a></li>
								<li><a href="/followingTacks.php">Following Tacks</a></li>
								<li><a href="/dashboard.php">Suggested Bookmarks</a></li>
								<li class="divider"></li>
								<li><a href="/profile.php">Profile</a></li>
								<li>NOT LOGGED IN</li>
							</ul>
						</li>
					</ul>
					<form action="/search/" method="post" name="searchBmk" id="searchBmk" class="navbar-search pull-left">
						<input type="text" class="search-query" placeholder="Search">
					</form>

					<div class="btn-group pull-right">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
							Username <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Settings</a></li>
							<li><a href="/index.php">Logout</a></li>
						</ul>
					</div> <!-- closing btn-group -->
				</div>
			</div>  <!-- closing container-fluid-->
		</div>  <!-- closing navbar-inner-->
	</div>  <!-- closing navbar-->

<?php } ?>
