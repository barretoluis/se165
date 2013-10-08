<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="bootstrap/assets/ico/faviconOrig.png">

    <title>Create Track</title>

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
        <h2>Create Track</h2>
        
        <form class="form-horizontal" role="form" method="POST" action="addTrack.php">
  <div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">Name</label>
    <div class="col-md-3">
      <input type="text" name="name" class="form-control" id="inputEmail1" placeholder="Track name">
    </div>
  </div>
  <div class="form-group">
    <label for="inputDesc" class="col-md-2 control-label col">Description</label>
    <div class="col-md-3">
      <textarea name ="desc" class="span3" cols="50" id="inputdesc" placeholder="Description" rows="5"></textarea>
    </div>
  </div>
 <div class="form-group">
    <label for="inputPrivacy" class="col-md-2 control-label col">Privacy</label>
    <div class="col-md-3">
        <select name="privacy" id="inputPrivacy">
            <option value="F">Public</option>
            <option value="T">Private</option>
        </select>
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-md-10">
        <button type="submit" class="btn btn-success">Create</button>
    </div>
  </div>
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
