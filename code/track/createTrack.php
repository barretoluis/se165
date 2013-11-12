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
		<title>Tackster | Track</title>
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
            <div class="createTrack">
                <h3>Add Track</h3>
                <div class="container">
                  <div class="well">
                    <form action="/track/addTrack.php" method="post" name="createTrack" id="createTrack" class="form-horizontal">
                      <table>
                        <tr>
                          <img src="/shared/images/Shoes.jpg">
                          <td width="95"><br/></td>
                        </tr>
                        <tr>
                          <td><label>Track Name: </label></td>
                          <td><input id="name" type="text" name="name" required=""></td>
                        </tr>
                        <tr>
                          <td><label>Description: </label></td>
                          <td><textarea name="description" rows="3"></textarea></td>
                        </tr>
                        <tr>
                          <td><label>Description: </label></td>
                          <td><textarea cols="30" rows="3" name="desc" id="desc" required=""></textarea></td>
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
                      <button class="btn btn-success" type="submit" >Create</button>
                    </form>
                  </div>
                </div>
             </div>
	</body>
</html>
