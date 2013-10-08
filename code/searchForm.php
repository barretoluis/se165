<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="bootstrap/assets/ico/faviconOrig.png">

    <title>Test Track</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <form class="form-search" method="POST" action="trackTester.php">
            <input type="text" name="criteria" class="input-medium search-query">
            <button type="submit" class="btn">Search</button>
        </form>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <hr>
      <footer>
        <p>&copy; Tackster.com 2013</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
