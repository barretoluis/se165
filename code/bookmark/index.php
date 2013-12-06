<?php
/*
 * Add additional include files to array if needed for this page.
 */
$includeFilesAdditional = array(
	'Bookmark/Bookmark.class.php'
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
//variables for getting bookmark
$_bmkData = Array();

//variables for getting bookmark comments
$htmlComments = NULL;
$_comments = NULL;

/*
 * Code to check permissions if user can view the bookmark requested
 */
$bmkId = (isset($_GET['bid'])) ? (int) $_GET['bid'] : NULL;
$Bookmark = new Bookmark();
$_websiteErr = Array();
$ucId = $_SESSION['uc_id'];


try {
	$canViewBmk = $Bookmark->canViewBmk($ucId, $bmkId);
	$isOwner = $Bookmark->isOwner($ucId, $bmkId);
	$isLiked = $Bookmark->userLikesBookmark($bmkId, $ucId);
} catch (MyException $e) {
	$canViewBmk = FALSE;
	$isOwner = FALSE;
	$isLiked = FALSE;
	array_push($_websiteErr, $e->getMessage());
	$e->getMyExceptionMessage();
}

if ($canViewBmk) {
	/*
	 * Code to view bookmark
	 */

	if (isset($_GET['bid'])) {
		try {
			$_bmkData = $Bookmark->returnBookmark($bmkId);
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
			array_push($_websiteErr, $e->getMessage());
		}

		$bmkUcId = $_bmkData[0]['uc_id'];
		$bmkTid = $_bmkData[0]['t_id'];
		$bmkUrl = $_bmkData[0]['url'];
		$bmkPriv = (isset($_bmkData[0]['privacy']) && $_bmkData[0]['privacy'] == 1) ? "Private" : "Share";
		$bmkDesc = $_bmkData[0]['description'];
		$bmkImg = $_bmkData[0]['bmk_image'];
//		$bmkKey = $_bmkData[0]['keyword'];
		if ($bmkImg == " ") {
			$bmkImg = "/shared/images/home3.jpg";
		}
	}





	/*
	 * Bookmark comments code
	 */
	try {
		$_comments = $Bookmark->returnBmkComments($bmkId);
	} catch (MyException $e) {
		array_push($_websiteErr, $e->getMessage());
		$e->getMyExceptionMessage();
	}

	if (count($_comments) > 0) {
		$htmlComments .= '<div> <table class="table table-striped"> <tbody> <div class="text-info"> <h3>Comments </h3></div>';
		foreach ($_comments as $_dbRecord) {
			$htmlComments .= '<tr><td>';
			foreach ($_dbRecord as $key => $value) {

				switch ($key) {
					case 'id':
						$htmlComments .= '<div id="' . $value . '">';
						break;
					/* case 'photo':
					  if ($value == NULL) {
					  $value = "/shared/images/profileBlank.png";
					  } else {
					  $value = "/shared/images/{$value}";
					  }
					  $htmlComments .= '<div id "photo"><img src="' . $value . '"></div>\n';
					  break; */

					case 'comment':
						$htmlComments .= '<blockquote><p>' . $value . '</p></blockquote>';
						break;

					case 'username':
						if ($value == NULL) {
							$value = "Not Available";
						}
						$htmlComments .= ' <small>Comment by:  <cite title="Source Title">' . $value . '</cite></small>';
						break;
					case 'timestamp':
						$htmlComments .= '<div id="timestamp">' . $value . '</div>';
						break;

					default:
						break;
				}
			}
			$htmlComments .= '</td></tr>';
		}
	} else {
		$htmlComments = "Be the first to comment on this bookmark.";
	}
	//$htmlComments .= '</div>\n';
	$htmlComments .= '</tbody></table>';
} else {
	array_push($_websiteErr, "Either this bookmark does not exist or you do not have permissions to view it.");
}


/*
 * Format any page errors to show user on webpage.
 */
if (count($_websiteErr) >= 1) {
	$errString = '<div class="formError"><p><b>We encountered the following issue with your request:</b></p><ol>';
	foreach ($_websiteErr as $value) {
		$errString .= "<li>" . $value . "</li>\n";
	}
	$errString .= '</ol></div>';
	$_websiteErr = $errString;
}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Tackster | Bookmark</title>
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
		<script src="/framework/jquery/jquery-1.10.2.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="/framework/bootstrap/js/bootstrap.min.js"></script>
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.2/css/font-awesome.min.css" rel="stylesheet"> <!--for delete and edit icons-->
	</head>


	<body>
		<!-- Body Content-->
		<div class="displayBookmark">
<!--			<h3><?php echo_formData($bmkDesc) ?></h3>-->
			<div class="container">
				<div class="well">
					<table style="float:right;">
						<tr>
							<td><?php if ($isOwner) { ?><a href="/bookmark/deleteBookmark.php/?bid=<?php echo $bmkId; ?>" title="Delete Bookmark"><i class="fa fa-trash-o fa-lg"></i></a><?php } ?></td>
							<td><?php if ($isOwner) { ?><a href="/bookmark/editBookmark.php/?bid=<?php echo $bmkId; ?>" title="Edit Bookmark"><i class="fa fa-pencil fa-lg"></i></a><?php } ?></td>
							<td><a href="<?php echo $bmkUrl; ?>" title="Website" target="_blank"><i class="fa fa-external-link fa-lg"></i></a></td>
							<td><?php if (!$isLiked) { ?><a href="/bookmark/likeBookmark.php/?bid=<?php echo $bmkId; ?>" title="Like Bookmark"><i class="fa fa-heart fa-lg"></i></a><?php } else {
	?> <a href="/bookmark/dislikeBookmark.php/?bid=<?php echo $bmkId; ?>" title="Like Bookmark"><i class="fa fa-heart fa-lg" style="opacity:0.2;"></i></a> <?php } ?>
							</td>
							<td><?php if (!$isOwner) { ?><a href="/track/followTrack.php/?bid=<?php echo_formData($bmkId); ?>&tid=<?php echo_formData($bmkTid); ?>" title="Follow Track"><i class="fa fa-eye fa-lg"></i></a><?php } ?></td>
						</tr>
					</table>

					<table>
						<tr>
						<div>
							<div style="margin: 0 auto;" >
								<!--<img src="/shared/images/home3.jpg"/> -->
								<img src="<?php echo_formData($bmkImg) ?>" style="min-height: 150px; min-width: 200px; max-height: 200px; max-width: 420px;"/>
							</div>
<!--                                    <div style="text-align: right;"><a href="<!--?php echo $bmkUrl; ?>" target="_blank"><small>Visit Site</small></a></div>-->
						</div>
						<td width="95"><br/></td>
						</tr>
						<tr>
							<td><label style="padding-top:5px;">Description: </label></td>
							<td><?php echo_formData($bmkDesc) ?></td>
						</tr>
						<tr>
							<td><label style="padding-top:5px;">Privacy: </label></td>
							<td>
<?php echo_formData($bmkPriv) ?>
  <!--<select name="privacy" id="privacy">
									<option value="0">Share</option>
									<option value="1">For Me</option>
							  </select>-->
							</td>
						</tr>
					</table>
                    </form>
				</div>
			</div>
			<div class="container">
				<div class="well">
<?php
echo_formData($htmlComments);
?>

					<form class="form-horizontal" id="addComment2Bmk" name="addComment2Bmk" method="post" action="addComment2Bmk.php">
						<input id="b_id" type="hidden" name="b_id" value="<?php echo_formData($bmkId); ?>">
						<table>
							<tr>
								<td><label>Comment: </label></td>
								<td><textarea id="cmt" name="cmt" rows="3"></textarea></td>
							</tr>


						</table>
						<button class="btn btn-success" type="submit" id="submit_id">Comment</button>
					</form>
                    <!-- begin htmlcommentbox.com -->
					<!--                 <div id="HCB_comment_box"><a href="http://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
										<link rel="stylesheet" type="text/css" href="//www.htmlcommentbox.com/static/skins/bootstrap/twitter-bootstrap.css?v=0" />
										<script type="text/javascript" id="hcb"> /**/ if(!window.hcb_user){hcb_user={};} (function(){var s=document.createElement("script"),
					l=(hcb_user.PAGE || ""+window.location), h="//www.htmlcommentbox.com";s.setAttribute("type","text/javascript");s.setAttribute("src", h+"/jread?page="+encodeURIComponent(l).replace("+","%2B")+"&opts=16862&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /**/ </script>-->
					<!-- end htmlcommentbox.com -->
				</div>
			</div>
		</div>

		<!-- /Body Content-->
	</body>
</html>
