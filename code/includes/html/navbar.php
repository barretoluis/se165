<?php
require_once('Utility/EnvUtilities.class.php');
require_once('Track/Track.class.php');

$searchWord = (isset($_POST['searchWord'])) ? $_POST['searchWord'] : NULL;

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
$loggedIn = (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) ? TRUE : FALSE;
$userName = (isset($_SESSION['profile']['first'])) ? $_SESSION['profile']['first'] : "My Profile";

//User login status check and set show navigation variable
if (isset($_SESSION['loginState']) && $_SESSION['loginState'] == 1) {
	$loggedIn = TRUE;

	//Get user's tracks if not available in session already
	if (!isset($_SESSION['myTracks'])) {
		try {
			$myTracks = new track();
			$_myTracks = $myTracks->getMyTrack($_SESSION['uc_id'], 'id,title');
			$_SESSION['myTracks'] = $_myTracks;
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}
	}
}
?>

<?php if ($loggedIn) { //show logged in-nav   ?>
	<!-- Popups-->
	<link href="/shared/css/colorbox.css" rel="stylesheet">
	<script src="/framework/jquery/jquery.colorbox.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			//Examples of how to assign the Colorbox event to elements
			$(".track_popUp").colorbox({iframe:true, width:"50%", height:"80%"});
			$(".bookmark_popUp").colorbox({iframe:true, width:"80%", height:"80%"});
			$(".profile_popUp").colorbox({iframe:true, width:"40%", height:"70%"});
		});
	</script>
	<!--/Popups-->

	<link href="/shared/css/jquery.sidr.light.css" rel="stylesheet">
	<script src="/framework/sidr/jquery.sidr.min.js"></script>
	<?php
	require_once 'html/trackMenu.php';
	?>

<!--	<div id="sidr">
		<div align="right" style="margin: 5px 15px 5px 15px;"><a id="simple-menu2" href="#sidr"><small>(close menu)</small></a></div>
		<ul>
			<li style="margin-left: 5px;"><b>My Tracks</b></li>
			<li><a href="#">My Private Track</a></li>
			<li class="active"><a href="#">My Public Track</a></li>
			<li><a href="#">Another track</a></li>
		</ul>
		<ul>
			<li style="margin-left: 5px;"><b>Following Tracks</b></li>
			<li><a href="#">My Private Track</a></li>
			<li class="active"><a href="#">My Public Track</a></li>
			<li><a href="#">Another track</a></li>
		</ul>
	</div>-->
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid" style= "margin-left: -10px; margin-right: -5px;">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="nav-collapse collapse">
					<ul class="nav">
						<li class="dropdown">
							<a href="/" class="dropdown-toggle" data-toggle="dropdown" style="color: #00B800; font-size: 20px;">Tackster <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/dashboard/">My Dashboard</a></li>
								<li><a href="">Following Tracks</a></li>
								<li><a id="simple-menu" href="#sidr">Tracks</a></li>
								<li class="divider"></li>
								<li><a class='track_popUp' href="/track/createTrack.php">Add Tracks</a></li>
								<li><a class='bookmark_popUp' href="/bookmark/createBookmark.php">Add Bookmark</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<script>
					$(document).ready(function() {
						$('#simple-menu').sidr();
					});
					$(document).ready(function() {
						$('#simple-menu2').sidr();
					});
				</script>

				<div class="searchbar">
					<form action="/search/" method="post" name="ui_element" id="ui_element" class="sb_wrapper">
						<p>
							<span class="sb_down"></span>
							<input type="text" name="searchWord" id="searchWord" maxlength="40" class="sb_input" placeholder="Search">
							<input class="sb_search" type="submit" value=""/>
						</p>
						<ul class="sb_dropdown" style="display:none;">
							<li class="sb_filter">Filter your search</li>
							<li><input type="checkbox" name="track" id="public" value="public" checked><label for="public"><strong>Public Tracks</strong></label></li>
							<li><input type="checkbox" name="track" id="allMyTracks" value="allMyTracks"><label for="allMyTracks">My Tracks</label></li>
							<?php
							//Let's populate the search bar with the user's tracks
							if (isset($_SESSION['myTracks'])) {
								foreach ($_SESSION['myTracks'] as $_record) {
									echo_formData('<li><input type="checkbox" name="track" value="' . $_record['id'] . '"><label for="' . $_record['title'] . '">' . $_record['title'] . '</label></li>');
								}
							}
							?>
						</ul>
					</form>
				</div>
				<div>
				</div>

				<!-- The JavaScript specific to search bar-->
				<script type="text/javascript">
					$(function() {
						/**
						 * the element
						 */
						var $ui = $('#ui_element');

						/**
						 * on focus and on click display the dropdown,
						 * and change the arrow image
						 */
						$ui.find('.sb_input').bind('focus click', function() {
							$ui.find('.sb_down')
							.addClass('sb_up')
							.removeClass('sb_down')
							.andSelf()
							.find('.sb_dropdown')
							.show();
						});

						/**
						 * on mouse leave hide the dropdown,
						 * and change the arrow image
						 */
						$ui.bind('mouseleave', function() {
							$ui.find('.sb_up')
							.addClass('sb_down')
							.removeClass('sb_up')
							.andSelf()
							.find('.sb_dropdown')
							.hide();
						});
					});
				</script>

				<div class="btn-group pull-right">
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
						<?php echo_formData($userName) ?> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" >
						<li><a class='profile_popUp' href="/account/">Profile</a></li>
						<li class="divider"></li>
						<li><a href="/auth/logout.php">Logout</a></li>
					</ul>
				</div> <!-- closing btn-group -->

			</div>
		</div>  <!-- closing container-fluid-->
	</div>  <!-- closing navbar-inner-->
	</div>  <!-- closing navbar-->


<?php } else { //show standard nav   ?>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="brand" href="/" style="color: #00B800">Tackster</a>
				<div class="nav-collapse collapse">
					<p class="navbar-text pull-right">
						<a class="btn btn-default" href="/auth/login.php" role = "button" style=" margin: 0 -10px 0px 0">Login with email</a>
					</p>
					<p class="navbar-text pull-right">
					   <a href="#" onClick="MyWindow = window.open('https://www.facebook.com/login.php?skip_api_login=1&api_key=294846713986884&signed_next=1&next=https%3A%2F%2Fwww.facebook.com%2Fdialog%2Foauth%3Fredirect_uri%3Dhttp%253A%252F%252F153.18.33.144%252FDEV%252F%26state%3D7a56d86c0a6c372440bf849d630e2a27%26scope%3Demail%26client_id%3D294846713986884%26ret%3Dlogin&cancel_uri=http%3A%2F%2F153.18.33.144%2FDEV%2F%3Ferror%3Daccess_denied%26error_code%3D200%26error_description%3DPermissions%2Berror%26error_reason%3Duser_denied%26state%3D7a56d86c0a6c372440bf849d630e2a27%23_%3D_&display=page', 'MyWindow', 'width=50px', 'height=10px');
								return false;">
							<img src = "http://i.imgur.com/wfKcSNX.png" alt="Login with Facebook" class="img-rounded" style ="margin: 0px 10px 0px 10px;"/></a>
					</p>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

<?php } ?>
