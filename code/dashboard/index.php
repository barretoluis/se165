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
$htmlTrack .=<<<EOF
<div class="track">
	<div style="position: relative;"><div id="private"></div><div id="trackName">{$defaultTrackName}</div></div>
	<img src= "/shared/images/placeholder.jpg" tid="{$defaultTrackId}" />

</div><!--/track-->
EOF;

foreach ($_myTracks as $dbRow) {
	$isPrivate = ($dbRow['private'] == "T") ? '<div id="private"></div>' : '';

	//we don't want the default track in the list again
	if ($dbRow['id'] != $defaultTrackId) {
		$htmlTrack .=<<<EOF
<div class="track" id="track">
	<div style="position: relative;">{$isPrivate}<div id="trackName">{$dbRow['title']}</div></div>
	<img src="/shared/images/placeholder.jpg" tid="{$dbRow['id']}" />
	<div style="position: relative;"><a id="deleteBtn" class="btn btn-danger" href="/track/deleteTrack.php?tid={$dbRow['id']}"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
	<a id="editBtn" class="editBtn btn btn-default" href="/track/createTrack.php?tid={$dbRow['id']}"><i class="fa fa-pencil fa-fw"></i> Edit</a></li></div>
</div><!--/track-->\n
EOF;
	}
}

if (is_array($_followingTracks) && count($_followingTracks) > 0) {
	foreach ($_followingTracks as $dbRow) {
		$isPrivate = ($dbRow['private'] == "T") ? '<div id="private"></div>' : '';

		//we don't want the default track in the list again
		if ($dbRow['id'] != $defaultTrackId) {
			$htmlTrackFollow .=<<<EOF
<div class="track" id="track">
	<div style="position: relative;">{$isPrivate}<div id="trackName">{$dbRow['title']}</div></div>
	<img src="/shared/images/placeholder.jpg" tid="{$dbRow['id']}" />
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
		<script src="/framework/jquery/jquery-1.10.2.min.js"></script>

		<script src="/framework/jquery/jquery.confirm.js"></script>
		<script src="/framework/jquery/jquery.colorbox.js"></script>

		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="/framework/bootstrap/js/bootstrap.min.js"></script>

		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

		<!--		<link href="/shared/css/bookmarkStyle.css" rel="stylesheet" type="text/css" />-->
		<script type="text/javascript" src="/shared/js/modernizr.custom.69142.js"></script>

		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.2/css/font-awesome.min.css" rel="stylesheet"> <!--for delete and edit icons-->
		<link href="/shared/css/trackStyle.css" rel="stylesheet" type="text/css" />

		<script>
			$(document).ready(function() {
				$('.track img').click(function () {
					var tid = parseInt($(this).attr("tid"));
					window.location = '/track/?tid=' + tid;
				});
			});
		</script>

        <script>
//            $("#deleteBtn").confirm();
			$(document).ready(function(){
				$('.editBtn').colorbox({iframe:true, width:"70%", height:"60%", href:$(this).attr("href")});
				return false;
			});
        </script>
		<!--Before Deleting make confirmation>
		<script type="text/javascript">
			function confirmDelete() {
				count = 1;
			  $( "#delete-confirm" ).dialog({
				resizable: false,
				height:200,
				modal: true,
				buttons: {
				  "Delete Track": function() {
					$( this ).dialog( "close" );
					return true;
				  },
				  Cancel: function() {
					$( this ).dialog( "close" );
					return false;
				  }
				}
			  });
			}
			return false;
		</script-->

	</head>


	<body>
		<!-- Navigation Bar -->
		<?php require_once('html/navbar.php'); ?>
		<!-- /Navigation Bar -->


		<!-- Body Content-->
		<div class="main" >
			<h3>My Tracks</h3>
			<?php if ($formError) { ?>
				<div class="formError"><h4>Form Error</h4><?php echo $formError ?></div>
			<?php } ?>
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid">
							<?php echo_formData($htmlTrack); ?>
						</div><!--/row-->
					</div><!--/span-->
				</div><!--/row-->
			</div>
			<hr/>
			<h3>Tracks I'm Following</h3>
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid">
							<?php echo_formData($htmlTrackFollow); ?>
							<p>Basic code in place. Complete back-end method to return the bookmarks being followed by current user.</p>
						</div><!--/row-->
					</div><!--/span-->
				</div><!--/row-->
			</div>
			<!-- /Body Content-->

			<!-- Footer Content -->
			<?php require_once('html/footer.php'); ?>
			<!-- /Footer Content -->

	</body>
</html>