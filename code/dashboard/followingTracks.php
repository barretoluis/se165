<?php
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
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Following Tracks</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap -->
    <link href="/framework/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Style Sheets -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>
    <link href="/shared/css/base.css" rel="stylesheet" type="text/css">
    <link href="/shared/css/trackStyle.css" rel="stylesheet" type="text/css">
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
    
    <link href="/shared/css/trackStyle.css" rel="stylesheet" type="text/css" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.2/css/font-awesome.min.css" rel="stylesheet"> <!--for delete and edit icons-->
    <script type="text/javascript" src="/shared/js/modernizr.custom.69142.js"></script>

    <script type="text/javascript">
            //TODO: The font heydings is being called. Where is it in the code... probably remove it.
            //Reply (Shruti): can't remove it b/c those provide icons: heart, bookmark, comments on each track!
            Modernizr.load({
                    test: Modernizr.csstransforms3d && Modernizr.csstransitions,
                    yep : ['http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js','/shared/js/jquery.hoverfold.js'],
                    nope: 'css/fallback.css',
                    callback : function( url, result, key ) {
                            if( url === '/shared/js/jquery.hoverfold.js' ) {
                                    $( '#bookmarks' ).hoverfold();
                            }
                    }
            });
    </script>
  </head>
  <body>
    
    <!-- Navigation Bar -->
        <?php require_once('html/navbar.php'); ?>
    <!-- /Navigation Bar -->
  <script>
      $(document).ready(function() {
    $('.track img').click(function () {
       window.location = 'trackSpecific.php';
    });
});
  </script>
  <!-- Body ***TO DO: GET THE PHOTOS TO AUTOMATICALLY RESIZE TO 300 X 200px!!!
    ================================================== -->
    <div class="main" >
      <h3>&nbsp; &nbsp; &nbsp;This should be My Dashboard View!</h3>
      <div class="container-fluid">
      <div class="row-fluid">
        <div class="span12">
          <div class="row-fluid">
            <div class="track">
              <div id="trackName">Track 1</div>
              <img src= "/shared/images/placeholder.jpg"/>
              <a class="btn btn-danger" href="#"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
              <a class="btn btn-default" href="#"><i class="fa fa-pencil fa-fw"></i> Edit</a></li>
            </div><!--/span-->
            <div class="track">
              <div id="trackName">Track 1</div>
              <img src= "/shared/images/Shoes.jpg"/>
              <a class="btn btn-danger" href="#"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
              <a class="btn btn-default" href="#"><i class="fa fa-pencil fa-fw"></i> Edit</a></li>
            </div><!--/span-->
            <div class="track">
              <div id="trackName">Track 1</div>
              <img src= "/shared/images/placeholder.jpg"/>
              <a class="btn btn-danger" href="#"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
              <a class="btn btn-default" href="#"><i class="fa fa-pencil fa-fw"></i> Edit</a></li>
            </div><!--/span-->
            <div class="track">
              <div id="trackName">Track 1</div>
              <img src= "/shared/images/placeholder.jpg"/>
              <a class="btn btn-danger" href="#"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
              <a class="btn btn-default" href="#"><i class="fa fa-pencil fa-fw"></i> Edit</a></li>
            </div><!--/span-->
            <div class="track">
              <div id="trackName">Track 1</div>
              <img src= "/shared/images/placeholder.jpg"/>
              <a class="btn btn-danger" href="#"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
              <a class="btn btn-default" href="#"><i class="fa fa-pencil fa-fw"></i> Edit</a></li>
            </div><!--/span-->
            <div class="track" id = "trk">
              <div id="trackName">Last Track</div>
              <img src= "/shared/images/placeholder.jpg"/>
              <a class="btn btn-danger" href="#"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
              <a class="btn btn-default" href="#"><i class="fa fa-pencil fa-fw"></i> Edit</a></li>
            </div><!--/span-->
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->
      
      		<!-- Footer Content -->
<?php require_once('html/footer.php'); ?>
		<!-- /Footer Content -->

  </body>
</html> 