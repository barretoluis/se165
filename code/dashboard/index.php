<?php
/*
 * Add additional include files to array if needed for this page.
 */
$includeFilesAdditional = array(
	'Bookmark/SearchBookmark.class.php',
	'Bookmark/Bookmark.class.php',
	'Track/Track.class.php'
);




// DO NOT EDIT THIS BLOCK - START
/*
 * Require mandatory libraries to be loaded.
 * Else, redirect to server outage page.
 *
 */
try {
	// require the primary include file
	if (!include_once('main.php')) {
		throw new Exception("Unable to include the main library.\n");
	}
} catch (Exception $e) {
	throw new Exception('Was not able to include the main.php file.', 0, $e);
	header('HTTP/1.1 500 Internal Server Error', true, 500);
	exit(0);
}
// DO NOT EDIT THIS BLOCK - END




/*
 * Page specific PHP code here
 */
$htmlTrack = NULL; //default dashboard
$htmlTrackFollow = NULL; //default dashboard
$_myTracks = array();
$_followingTracks = array();
$ucId = $_SESSION['uc_id'];
$isNewUser = (isset($_SESSION['isNewUser'])) ? $_SESSION['isNewUser'] : FALSE;
$_SESSION['isNewUser'] = $isNewUser; //let's not show the 1st time UI on page refreshes

if(isset($_COOKIE['isNewUserMsgSeen']) && $_COOKIE['isNewUserMsgSeen'] == 1) {
	$isNewUser = FALSE;
} else {
	setcookie("isNewUserMsgSeen", '1', time()+3600);  /* expire in 1 hour */
}


$Track = new Track();

//let's get the default track id
$trackId = $Track->returnDefaultTrackId($ucId);

//TODO: Add this code to main and do a one time check on login instead
//Create a default track for the user if one doesn't exist.
try {
	$trackId = $Track->createDefaultTrack($ucId);
} catch (MyException $e) {
	$e->getMyExceptionMessage();
}

//Get user's tracks if not available in session already
if (!isset($_SESSION['_myTracks']) || !isset($_SESSION['_followingTracks'])) {
	try {
		$_myTracks = $Track->getMyTrack($_SESSION['uc_id'], 'id,title,private');
		$_followingTracks = $Track->returnFollowingTracks($_SESSION['uc_id'], 'id,title,private');
	} catch (MyException $e) {
		$e->getMyExceptionMessage();
	}
} else {
	$_myTracks = $_SESSION['_myTracks'];
	$_followingTracks = $_SESSION['_followingTracks'];
}

//TODO: Make sure a default track cannot be deleted or edited
$defaultTrackId = $Track->returnDefaultTrackId($ucId);
$defaultTrackName = $Track->returnTrackName($defaultTrackId);
$defaulttrackImage = $Track->returnDefaultImage($defaultTrackId);
$htmlTrack .=<<<EOF
<div class="track">
	<div style="position: relative;"><div id="private"></div><div id="trackName">{$defaultTrackName}</div></div>
	<img src= "{$defaulttrackImage}" tid="{$defaultTrackId}" />

</div><!--/track-->
EOF;

foreach ($_myTracks as $dbRow) {
	$isPrivate = ($dbRow['private'] == "T") ? '<div id="private"></div>' : '';
	$tempTrackId = $dbRow['id'];
	$trackImage = $Track->returnDefaultImage($tempTrackId);

	//we don't want the default track in the list again
	if ($dbRow['id'] != $defaultTrackId) {
		$htmlTrack .=<<<EOF
<div class="track" id="track">
	<div style="position: relative;">{$isPrivate}<div id="trackName">{$dbRow['title']}</div></div>
	<img src="{$trackImage}" tid="{$dbRow['id']}" />
	<div style="position: relative;"><a id="deleteBtn" class="btn btn-danger" href="/track/deleteTrack.php?tid={$dbRow['id']}"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
	<a id="editBtn" class="editBtn btn btn-default" href="/track/createTrack.php?tid={$dbRow['id']}"><i class="fa fa-pencil fa-fw"></i> Edit</a></li></div>
</div><!--/track-->\n
EOF;
	}
}

if (is_array($_followingTracks) && count($_followingTracks) > 0) {
	foreach ($_followingTracks as $dbRow) {
		$isPrivate = ($dbRow['private'] == "T") ? '<div id="private"></div>' : '';
		$tempTrackId = $dbRow['id'];
		$trackImage = $Track->returnDefaultImage($tempTrackId);
		//we don't want the default track in the list again
		if ($dbRow['id'] != $defaultTrackId) {
			$htmlTrackFollow .=<<<EOF
<div class="track" id="track">
	<div style="position: relative;">{$isPrivate}<div id="trackName">{$dbRow['title']}</div></div>
	<img src="{$trackImage}" tid="{$dbRow['id']}" />
	<div style="position: relative;"><a id="deleteBtn" class="btn btn-danger" href="/track/deleteTrack.php?tid={$dbRow['id']}"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
	<a id="editBtn" class="btn btn-default" href="/track/createTrack.php?tid={$dbRow['id']}"><i class="fa fa-pencil fa-fw"></i> Edit</a></li></div>
</div><!--/track-->\n
EOF;
		}
	}
}
?><!DOCTYPE html>
<html>
	<head>
		<title>Tackster | My Dashboard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Bootstrap -->
		<link href="/framework/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

		<!-- Style Sheets -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>
		<link href="/shared/css/base.css" rel="stylesheet" type="text/css">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="/framework/bootstrap/assets/js/html5shiv.js"></script>
		<script src="/framework/bootstrap/assets/js/respond.min.js"></script>
		<![endif]-->

		<!-- JavaScript -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<link href="/framework/jquery/css/jquery-ui-1.10.3.custom.css" rel="stylesheet">
		<script src="/framework/jquery/jquery-1.10.2.min.js"></script>
<!--		<script src="/framework/jquery/jquery-ui-1.10.3.custom.js"></script>-->

		<script src="/framework/jquery/jquery.confirm.js"></script>
		<script src="/framework/jquery/jquery.colorbox.js"></script>

		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="/framework/bootstrap/js/bootstrap.min.js"></script>

		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<script type="text/javascript" src="/shared/js/modernizr.custom.69142.js"></script>

		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.2/css/font-awesome.min.css" rel="stylesheet"> <!--for delete and edit icons-->
		<link href="/shared/css/tabBody.css" rel="stylesheet" type="text/css">

		<script language="JavaScript" type="text/javascript">
			// ////////////////////
			//attach events for now and all new content

			$(document).ready(function() {
				//load default tab
				getMyTrack();
				//				if(window.location.hash) {
				//					var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
				//					if(hash=="following") {
				//						alert(hash);
				//						getFollowingTrack();
				//						document.getElementById('myTrack').className='last';
				//						document.getElementById('followTrack').className='active';					}
				//				} else {
				//					getMyTrack();
				//				}

				//attach event handler for tracks
				$('.tabContent').on("click", ".track img", function() {
					var tid = parseInt($(this).attr("tid"));
					//alert($(this).attr("tid"));	//DEBUG
					window.location = '/track/?tid=' + tid;
				});

				//attach event handler for tracks
				$('.tabContent').on("click", ".follow img", function() {
					var tid = parseInt($(this).attr("tid"));
					//alert($(this).attr("tid"));	//DEBUG
					window.location = '/track/?t=f&tid=' + tid;
				});

				//open edit buttons in modal
				$('.tabContent').on("click", ".editBtn", function() {
					$.colorbox({iframe:true, width:"70%", height:"60%", href:$(this).attr("href"), onClosed:function(){ location.reload(true); }});
					return false;
				});

				//open delete buttons in modal
				$('.tabContent').on("click", ".deleteBtn", function() {
					var checkstr =  confirm('Are you sure want to delete this track and all it\'s bookmarks?');
					if(checkstr == true){
					}else{
						return false;
					}
				});
			});

			// ////////////////////
			//show tooltips when hovering over icons
			$(function() {
				$( document ).tooltip({
					track: true
				});
            });

			// ////////////////////
			//populate tabs with appropriate content when clicked or page loaded
			function getMyTrack(id) {
				$.ajax({
					type: "GET",
					url: '/dashboard/tab_myTracks.php',
					//data: "id=" + id, // appears as $_GET['id'] @ ur backend side
					success: function(data) {
						// data is ur summary
						$('.tabContent').html(data);
					}

				});
			}
			function getFollowingTrack(id) {
				$.ajax({
					type: "GET",
					url: '/dashboard/tab_following.php',
					//data: "id=" + id, // appears as $_GET['id'] @ ur backend side
					success: function(data) {
						// data is ur summary
						$('.tabContent').html(data);
					}

				});
			}

<?php if ($isNewUser) { ?>
		// ////////////////////
		//run first time user balloon help
		$(function() {
			$(".searchSecretPopUp").delay(1000).fadeIn();
			$(".followSecretPopUp").delay(500).fadeIn();
			$(".myTracksSecretPopUp").delay(500).fadeIn();
			$(".searchSecretPopUp").hide(8000, function(){
				$(".allTracksSecretPopUp").delay(500).fadeIn();
				$(".allTracksSecretPopUp").hide(9000, function(){
					$(".trackSecretPopUp").delay(500).fadeIn();
					$(".trackSecretPopUp").hide(20000, function(){
						$(".logoSecretPopUp").delay(500).fadeIn();
						$(".logoSecretPopUp").hide(9000, function(){
							$(".bookmarkSecretPopUp").delay(500).fadeIn();
							$(".bookmarkSecretPopUp").hide(9000, function(){
								$(".followSecretPopUp").delay(500).fadeIn();
								$(".followSecretPopUp").hide(9000, function(){
									$(".myTracksSecretPopUp").delay(500).fadeIn();
									$(".myTracksSecretPopUp").hide(9000);
								});
							});
						});
					});
				});
			});
		});
<?php } ?>
		</script>

	</head>


	<body>
		<!-- Navigation Bar -->
		<?php require_once('html/navbar.php'); ?>
		<!-- /Navigation Bar -->


		<!-- Body Content-->
		<div class="main" id="main">
			<?php if ($isNewUser) { ?>
				<div class="searchSecretPopUp" style="position: absolute; top: -20px; left: 350px;">
					<p class="triangle-isosceles top" style="width: 180px;">Search for bookmarks here</p>
				</div>
				<div class="trackSecretPopUp" style="position: absolute; top: 30px; right: 55px;">
					<p class="triangle-isosceles top" style="width: 300px;">Tracks are like folders that can hold various bookmarks. Add a new track here.</p>
				</div>
				<div class="allTracksSecretPopUp" style="position: absolute; top: 30px; right: 10px;">
					<p class="triangle-isosceles top" style="width: 100px;">Click here to view all tracks.</p>
				</div>
				<div class="logoSecretPopUp" style="position: absolute; top: -20px; left: 10px;">
					<p class="triangle-isosceles top" style="width: 100px;">Logo acts as a home button.</p>
				</div>
				<div class="bookmarkSecretPopUp" style="position: absolute; top: 30px; right: 90px;">
					<p class="triangle-isosceles top" style="width: 100px;">Add a new bookmark!</p>
				</div>
				<!--                    <div class="followSecretPopUp" style="position: absolute; left: 200px;">
										<p class="triangle-isosceles top" style="width: 100px;">Easy access to Following Tracks.</p>
									</div>
									<div class="myTracksSecretPopUp" style="position: absolute; top: 25px; left: 90px;">
										<p class="triangle-isosceles top" style="width: 200px;">Shows all the Tracks that YOU created.</p>
									</div>-->
			<?php } ?>

			<div class="tab" id="tab">
				<div id="quickMenu" class="quickMenuTab">
					<div id="icons">
						<a class='bookmark_popUp' href="/bookmark/createBookmark.php" title="Add Bookmark"><i class="fa fa-bookmark fa-lg"></i></a>
						<a class='track_popUp' href="/track/createTrack.php" title="Add Track"><i class="fa fa-folder-open fa-lg"></i></a>
						<a title="Show all tracks" href="#sidr" id="allTracks">(tracks)</a>
						<script>
							$(document).ready(function() {
								$('#allTracks').sidr();
							});
						</script>
					</div>
				</div>
				<div id='cssmenu'>
					<ul>
						<li class='active' id="myTrack"><a href="javascript:void(0)" onclick="getMyTrack('main'); document.getElementById('myTrack').className='active'; document.getElementById('followTrack').className='last';"><span>My Tracks</span></a></li>
						<li class='last' id="followTrack"><a href="javascript:void(0)"  onclick="getFollowingTrack();  document.getElementById('myTrack').className='last'; document.getElementById('followTrack').className='active';"><span>Following Tracks</span></a></li>
					</ul>
				</div>
				<div class="main tabContent" id="tabContent"></div>
			</div>
		</div>
		<!-- /Body Content-->

		<!-- Footer Content -->
		<?php require_once('html/footer.php'); ?>
		<!-- /Footer Content -->

	</body>
</html>