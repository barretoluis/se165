<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet" >
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/tackStyle.css" rel="stylesheet" type="text/css" />
    
    
    <script type = "text/javascript" src = "http://code.jquery.com/jquery-1.10.1.min.js"> </script>
    <script type="text/javascript" src="js/modernizr.custom.69142.js"></script>
    <script type = "text/javascript" src = "js/bootstrap.js"></script>
    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>

    <style type = "text/css">

    body {
      background: #DCDDDF;
      color: #000;
      font: 14px Arial;
      margin: 0 auto;
      padding: 0;
      position: relative;
    }
    h3{ font-size:18px;}

    /* To style user's Navbar!!*/
      .container-fluid{
        margin-left: -15px;
        margin-right: -5px;
      }

      .navbar-search{
        padding-left: 50px;
      }

      .dropdown-menu .divider {
        height: 1px;
        margin: 9px 1px;
        overflow: hidden;
        background-color: #e5e5e5;
        border-bottom: 1px solid #e5e5e5;
      }
    </style>
  </head>
  <body>
    
  <!-- LOGGED IN USER'S NAVBAR
    ================================================== -->
      <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <div class="nav-collapse collapse">  
              <ul class="nav">
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #00B800; font-size: 20px;">Tackster <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="./myTacks.php">My Tacks</a></li>
                  <li><a href="./followingTacks.php">Following Tacks</a></li>
                  <li><a href="./dashboard.php">Suggested Bookmarks</a></li>
                  <li class="divider"></li>
                  <li><a href="./profile.php">Profile</a></li>
                  <li><a href="#">???</a></li>
                </ul>
              </li>  
              </ul>  
              <form class="navbar-search pull-left">  
                <input type="text" class="search-query" placeholder="Search">  
              </form>

              <div class="btn-group pull-right">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                  Username <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings</a></li>
                  <li><a href="./index.php">Logout</a></li>
                </ul> 
              </div> <!-- closing btn-group -->
            </div>
          </div>  <!-- closing container-fluid-->
        </div>  <!-- closing navbar-inner-->
      </div>  <!-- closing navbar-->

PROFILE PAGE


  </body>
</html> 