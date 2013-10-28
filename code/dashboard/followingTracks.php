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

    <link href="/shared/css/tackStyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/shared/js/modernizr.custom.69142.js"></script>

    <script type="text/javascript">
            //TODO: The font heydings is being called. Where is it in the code... probably remove it.
            //Reply (Shruti): can't remove it b/c those give the icons: heart, bookmark, comments on the each track!
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
  
  <!-- Body ***TO DO: GET THE PHOTOS TO AUTOMATICALLY RESIZE TO 300 X 200px!!!
    ================================================== -->
    <div id="bookmarks" class="main" >
      <h3>Following Tacks!! *Note: tacks vs. bookmarks</h3>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">200</span>
          <span data-icon="h">124</span>
          <span data-icon="B"></span>
          <a href="http://www.flickr.com/photos/ag2r/4846704157/in/photostream">&rarr;</a>
        </div>
        <img src="/shared/images/Shoes.jpg" />
      </div>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">210</span>
          <span data-icon="h">102</span>
          <span data-icon="B"></span>
          <a href="http://www.flickr.com/photos/ag2r/6271521984/in/photostream">&rarr;</a>
        </div>
        <img src="/shared/images/3.jpg"/>
      </div>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">690</span>
          <span data-icon="h">361</span>
          <span data-icon="B"></span>
          <a href="http://www.flickr.com/photos/ag2r/6131126901/in/photostream">&rarr;</a>
        </div>
        <img src="/shared/images/6.jpg"/>
      </div>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">987</span>
          <span data-icon="h">130</span>
          <span data-icon="B"></span>
          <a href="http://www.google.com">&rarr;</a>
        </div>
        <img src="/shared/images/1.jpg" />
      </div>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">200</span>
          <span data-icon="h">124</span>
          <span data-icon="B"></span>
          <a href="http://www.flickr.com/photos/ag2r/4846704157/in/photostream">&rarr;</a>
        </div>
        <img src="/shared/images/4.jpg" />
      </div>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">210</span>
          <span data-icon="h">102</span>
          <span data-icon="B"></span>
          <a href="http://www.flickr.com/photos/ag2r/6271521984/in/photostream">&rarr;</a>
        </div>
        <img src="/shared/images/3.jpg" />
      </div>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">690</span>
          <span data-icon="h">361</span>
          <span data-icon="B"></span>
          <a href="http://www.flickr.com/photos/ag2r/6131126901/in/photostream">&rarr;</a>
        </div>
        <img src="/shared/images/6.jpg"/>
      </div>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">987</span>
          <span data-icon="h">130</span>
          <span data-icon="B"></span>
          <a href="http://www.google.com">&rarr;</a>
        </div>
        <img src="/shared/images/1.jpg" />
      </div>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">200</span>
          <span data-icon="h">124</span>
          <span data-icon="B"></span>
          <a href="http://www.flickr.com/photos/ag2r/4846704157/in/photostream">&rarr;</a>
        </div>
        <img src="/shared/images/4.jpg" />
      </div>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">210</span>
          <span data-icon="h">102</span>
          <span data-icon="B"></span>
          <a href="http://www.flickr.com/photos/ag2r/6271521984/in/photostream">&rarr;</a>
        </div>
        <img src="/shared/images/3.jpg" />
      </div>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">690</span>
          <span data-icon="h">361</span>
          <span data-icon="B"></span>
          <a href="http://www.flickr.com/photos/ag2r/6131126901/in/photostream">&rarr;</a>
        </div>
        <img src="/shared/images/6.jpg"/>
      </div>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">987</span>
          <span data-icon="h">130</span>
          <span data-icon="B"></span>
          <a href="http://www.google.com">&rarr;</a>
        </div>
        <img src="/shared/images/1.jpg" />
      </div>
      
      <div class="view">
        <div class="view-back">
          <span data-icon="b">210</span>
          <span data-icon="h">102</span>
          <span data-icon="B"></span>
          <a href="http://www.flickr.com/photos/ag2r/6271521984/in/photostream">&rarr;</a>
        </div>
        <img src="/shared/images/3.jpg" />
      </div>
      <div class="view">
        <div class="view-back">
          <span data-icon="b">690</span>
          <span data-icon="h">361</span>
          <span data-icon="B"></span>
          <a href="http://www.flickr.com/photos/ag2r/6131126901/in/photostream">&rarr;</a>
        </div>
        <img src="/shared/images/6.jpg"/>
      </div>
    </div>
  </body>
</html> 