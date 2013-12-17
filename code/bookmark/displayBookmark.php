<?php
/*
 * Add additional include files to array if needed for this page.
 */
$includeFilesAdditional = array(
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
?><!DOCTYPE html>
<html>
	<head>
		<title>Tackster | View Bookmark</title>
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

	</head>

	<body>
		<!-- Body Content-->
            <div class="displayBookmark">
                <h3>View Bookmark</h3>
                <div class="container">
                  <div class="well">
                    <table>
                      <tr>
                          <img src="/shared/images/Shoes.jpg">
                          <td width="95"><br/></td>
                      </tr>
                      <tr>
                          <td><label style="padding-top:5px;">Description: </label></td>
                          <td>[Pulls description of the current Bookmark] Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</td>
                        </tr>
                        <tr>
                          <td><label style="padding-top:5px;">Privacy: </label></td>
                          <td>
                            <select name="privacy" id="privacy">
                              <option value="0">Share</option>
                              <option value="1">For Me</option>
                            </select>
                          </td>
                        </tr>
                      </table>
                    </form>
                  </div>
                </div>
                <div class="container">
                  <div class="well">
                    <!-- begin htmlcommentbox.com -->
                    <div id="HCB_comment_box"><a href="http://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
                    <link rel="stylesheet" type="text/css" href="//www.htmlcommentbox.com/static/skins/bootstrap/twitter-bootstrap.css?v=0" />
                    <script type="text/javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={};} (function(){var s=document.createElement("script"), l=(hcb_user.PAGE || ""+window.location), h="//www.htmlcommentbox.com";s.setAttribute("type","text/javascript");s.setAttribute("src", h+"/jread?page="+encodeURIComponent(l).replace("+","%2B")+"&opts=16862&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
                   <!-- end htmlcommentbox.com -->
                  </div>
                </div>
            </div>
   <!-- /Body Content-->
	</body>
</html>
