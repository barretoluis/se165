<?php
session_start();
require_once 'includes/faceBookApi.php';
require_once 'includes/mandrillApi.php';
require_once 'includes/user.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');
$faceBookObj = new faceBookApi();
$userObj = new user();
$registered = FALSE;
$exists = $faceBookObj->setUserState();
$logout = '<a href="'.$faceBookObj->getLogOutUrl().'">;
                    <img src="images/logoutFB.png" alt="logout" class="img-rounded"></a>';
                    
//$_SESSION['logoutURL'] = $fbButton;
if($exists)
{
    $fbButton = '<a href="'.$faceBookObj->getLogOutUrl().'">;
                    <img src="images/logoutFB.png" alt="logout" class="img-rounded"></a>';
    $_SESSION['logoutURL'] = $fbButton;
    $fbinfo = $faceBookObj->getUserProfile();
    $registered = $userObj->searchUser($fbinfo['email']);
    $_SESSION['profile'] = $fbinfo;
    if (!$registered)
    {
        $userArray = array('fname'=>$fbinfo['first_name'],
                       'lname'=>$fbinfo['last_name'],
                       'email'=>$fbinfo['email'],
                       'password' =>'',
                       'gender'=>$fbinfo['gender'],
                       'source'=>'F');
        $userObj->createUser($userArray);
        header('Location:dashboard.php');
    }
    else
    {
        header('Location:dashboard.php');
    }
}
else
{
   $fbButton = '<a href="'.$faceBookObj->getLoginUrl().'">;
                    <img src="images/loginFB.png" alt="Login using Facebook" class="img-rounded"></a>';

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="bootstrap/assets/ico/faviconOrig.png">

    <title>Tackster</title>

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

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Tackster.com</a>
        </div>
        <div class="navbar-collapse collapse">

          <form class="navbar-form navbar-right" name="bar" method="POST" action="login.php">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control" name="email">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control" name ="password">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
            <?php echo $fbButton?>
            
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h2>Register</h2>
        
        <form class="form-horizontal" role="form" method="POST" action="register.php">
  <div class="form-group">
    <label for="inputFname" class="col-sm-2 control-label">First Name</label>
    <div class="col-md-3">
      <input type="text" name="fname" class="form-control" id="inputEmail1" placeholder="First Name">
    </div>
  </div>
  <div class="form-group">
    <label for="inputLname" class="col-md-2 control-label col">Last Name</label>
    <div class="col-md-3">
      <input type="text" name="lname" class="form-control" id="inputEmail1" placeholder="Last Name">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail" class="col-md-2 control-label col">Email</label>
    <div class="col-md-3">
      <input type="email" name="email" class="form-control" id="inputEmail1" placeholder="Email">
    </div>
  </div>
   <div class="form-group">
    <label for="inputPassword" class="col-md-2 control-label col">Password</label>
    <div class="col-md-3">
      <input type="password" name="pwd" class="form-control" id="inputEmail1" placeholder="Password">
    </div>
  </div> 
  <div class="form-group">
    <label for="inputRePassword" class="col-md-2 control-label col">Re-type Password</label>
    <div class="col-md-3">
      <input type="password" name="pwd2" class="form-control" id="inputEmail1" placeholder="Re-type Password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputSex" class="col-md-2 control-label col">Gender</label>
        <div class="col-md-1">
        <select name="sex" class="form-control">
             <option>M</option>
             <option>F</option>
        </select>
        </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-md-10">
        <button type="submit" class="btn btn-success">Register</button>
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

