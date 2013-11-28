<?php
require_once('Utility/EnvUtilities.class.php');
require_once('Track/Track.class.php');
require_once('FacebookConnector/FacebookConnector.class.php');

$searchWord = (isset($_POST['searchWord'])) ? $_POST['searchWord'] : NULL;
$fbLoginUrl = NULL;

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

if (!$loggedIn) {
	$FBConn = new FacebookConnector();
	$fbLoginUrl = $FBConn->getLoginUrl();

	if ($fbLoginUrl == NULL) { //if a person already logged into Facebook, log'em in
		header('Location: /auth/loginFacebook.php');
	}
}

//User login status check and set show navigation variable
if ($loggedIn) {
//if (isset($_SESSION['loginState']) && $_SESSION['loginState'] == 1) {
//	$loggedIn = TRUE;
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

<?php if ($loggedIn) { //show logged in-nav      ?>
	<!-- Popups-->
	<link href="/shared/css/colorbox.css" rel="stylesheet">
	<script src="/framework/jquery/jquery.colorbox.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			//Examples of how to assign the Colorbox event to elements
			$(".track_popUp").colorbox({iframe:true, width:"70%", height:"60%", onClosed:function(){ location.reload(true); }});
			$(".bookmark_popUp").colorbox({iframe:true, width:"70%", height:"95%", onClosed:function(){ location.reload(true); }});
			$(".profile_popUp").colorbox({iframe:true, width:"50%", height:"70%"});
		});
	</script>
	<!--/Popups-->

	<link href="/shared/css/jquery.sidr.light.css" rel="stylesheet">
	<script src="/framework/sidr/jquery.sidr.min.js"></script>
	<?php
	require_once 'html/trackMenu.php';
	?>

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
<!--							<a href="/" class="dropdown-toggle" data-toggle="dropdown" style="color: #00B800; font-size: 20px; margin: 0 0 0 0;;"><img src="/shared/images/logo_tackster.png" style="margin: -20px 0px -20px 0px;"><b class="caret"></b></a>-->
                                                        <a href="/dashboard/" class="brand"><img src="/shared/images/logo_tackster.png" style="margin: -22px 0px -20px 20px;"></a>
<!--							<ul class="dropdown-menu">
								<li><a href="/dashboard/">Dashboard</a></li>
								<li style="padding-left: 10px;"><a id="simple-menu" href="#sidr">My Tracks</a></li>
								<li style="padding-left: 10px;"><a href="/dashboard/#following">Following Tracks</a></li>
								<li class="divider"></li>
								<li><a class='track_popUp' href="/track/createTrack.php">Add Tracks</a></li>
								<li><a class='bookmark_popUp' href="/bookmark/createBookmark.php">Add Bookmark</a></li>
							</ul>-->
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
                                <script>
                                    function checkPublicMarks(){

                                    document.getElementById("ui_element").publicTracks.checked = true;
                                    document.getElementById("ui_element").myTracks.checked = false;
                                    uncheckTracks();
                                    }
                                    function checkMyTracks(){
                                            document.getElementById("ui_element").myTracks.checked = true;
                                            document.getElementById("ui_element").publicTracks.checked = false;
                                            checkTracks();
                                  }
                                  function checkTracks(){
                                      var tracksNum = <?php
                                        if (isset($_SESSION['myTracks'])) {
                                            echo count($_SESSION['myTracks']);
                                        }
                                        ?>;

                                    if(tracksNum > 0){
                                        for(var i = 0 ; i < tracksNum ; i++)
                                        {
                                            var trackID = "tid" + i;
                                            document.getElementById(trackID).checked = true;
                                        }
                                    }
//                                      document.getElementById("ui_element").publicTracks.checked = false;
//                                      document.getElementById("ui_element").myTracks.checked = false;
                                  }
                                  function uncheckTracks(){
                                    var tracksNum = <?php
                                        if (isset($_SESSION['myTracks'])) {
                                            echo count($_SESSION['myTracks']);
                                        }
                                        ?>;

                                    if(tracksNum > 0){
                                        for(var i = 0 ; i < tracksNum ; i++)
                                        {
                                            var trackID = "tid" + i;
                                            document.getElementById(trackID).checked = false;
                                        }
                                    }
                                  }
                                  function checkSingleTracks(){
                                      document.getElementById("ui_element").publicTracks.checked = false;
                                      document.getElementById("ui_element").myTracks.checked = false;
                                  }
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
                                                        <li><input type="checkbox" name="publicTracks" id="publicTracks" value="1" checked onclick="checkPublicMarks();"><label for="public"><strong>Public Tracks</strong></label></li>
							<li><input type="checkbox" name="myTracks" id="myTracks" value="1" onclick="checkMyTracks();"><label for="allMyTracks">My Tracks</label></li>
							<?php
							//Let's populate the search bar with the user's tracks
                                                       $trackNum = 0;
							if (isset($_SESSION['myTracks'])) {
								foreach ($_SESSION['myTracks'] as $_record) {
									echo_formData('<li><input type="checkbox" name="tid[]" id="tid' . $trackNum . '" value="' . $_record['id'] . '" onclick="checkSingleTracks();"><label for="' . $_record['title'] . '">' . $_record['title'] . '</label></li>');
                                                                        $trackNum = $trackNum + 1;
								}
							}
							?>
						</ul>
					</form>
				</div>
        
				<!-- JavaScript to handle JQuery autocomplete-->
                <script>
                $(document).ready(function($){
                   $('#searchWord').autocomplete({source:'../search/autocomplete.php', minLength:1,
                       position: { my : "right top", at: "right bottom" }});
                });
                </script>

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


<?php } else { //show standard nav      ?>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="/" class="brand"><img src="/shared/images/logo_tackster.png" style="margin: -9px 0px -9px 0px;"></a>
				<div class="nav-collapse collapse">
					<p class="navbar-text pull-right">
						<a class="btn btn-default" href="/auth/login.php" role = "button" style=" margin: 0 -10px 0px 0">Login</a>
					</p>
					<p class="navbar-text pull-right">
						<a href="#" onClick="MyWindow=window.open('<?PHP echo $fbLoginUrl; ?>','MyWindow', 'width=875,height=675'); return false;">
							<img src= "/shared/images/btn_fbLogin.png" width="161" height="30" alt="Login with Facebook" class= "img-rounded" style="margin: 0px 10px 0px 10px;"/>
						</a>
					</p>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

<?php } ?>
