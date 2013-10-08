<?php
session_start();

$profile = $_SESSION['profile'];
$fbButton = $_SESSION['logoutURL'];
echo $fbButton;
echo "<p>Dashboard</p>";
print_r($profile);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link rel="stylesheet" href="/framework/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="signUpStyle.css" />
    <link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <script type = "text/javascript" src = "http://code.jquery.com/jquery-1.10.1.min.js"> </script>
    <script type = "text/javascript" src = "/framework/bootstrap/js/bootstrap.js"></script>
    
    <style type = "text/css">

    .navbar-search{
      padding-left: 50px;
    }
    </style>
  </head>
  <body>
    <script src="/downloads/twitter-bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.js?view=1"></script>

    <!-- LOGGED IN USER'S NAVBAR
    ================================================== -->
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container-fluid" style = "padding: 5px 0 5px 0;">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="brand" href="#" style="color: #00B800">Tackster</a> <!--on-click: should return to their home page with suggested tracks -->
            <div class="nav-collapse collapse">      
              <form class="navbar-search pull-left">  
                <input type="text" class="search-query" placeholder="Search">  
              </form>

              <div class="btn-group pull-right">
                <a class="btn btn-primary" href="#"><i class="icon-user icon-white"></i> Username</a>
                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#"><i class="icon-wrench"></i> Settings</a></li>
                  <li><a href="#"><i class="icon-off"></i> Logout</a></li>
                </ul>
              </div> <!-- closing btn-group-->
            </div>
          </div>  <!-- closing container-fluid-->
        </div>  <!-- closing navbar-inner-->
      </div>  <!-- closing navbar-->

    <!-- CONTENTS 
    ================================================== -->
    
    <strong>**BTW, YOU SHOULD NOT HAVE SIGN IN OPTION HERE AS THIS IS A DASHBOARD!!!</strong><br/>
    Make sure to follow <a href= "https://www.youtube.com/watch?v=xR_Ee8TN4dc">this</a> tutorial - as it talks all you need to create a webpage!!</br>
    For advanced dropdown features: like hower over dropdown buttons <a href = "http://cameronspear.com/demos/twitter-bootstrap-hover-dropdown/">here</a><br/>
    For Modal dialogues here: <a href="http://getbootstrap.com/2.3.2/javascript.html#modals">One</a> and <a href="https://www.youtube.com/watch?v=XXgI8y0d4LU">Two</a><br/>
    Touching up on some of the basics of <a href="http://www.sitepoint.com/twitter-bootstrap-tutorial-handling-complex-designs/">Bootstrap</a><br/>
    Another excellent <a href="http://www.youtube.com/watch?v=1u9aXkh5Gcc">guy</a> for Bootstrap help!<br/>
    Complete website under 30 minutes <a href = "http://www.youtube.com/watch?v=GsAwMUUo6GM">here</a><br/>
  </body>
</html> 