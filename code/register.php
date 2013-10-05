<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
	
	<!-- styles -->
    <link rel="stylesheet" type="text/css" href="/shared/css/registerStyle.css" />
    <link href="/framework/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen"/>
    <link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../../framework/bootstrap/css/bootstrap-theme.min.css" type="text/css">

    <?php
       /* require_once 'includes/user.php';
        session_Start();
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        $userObj = new user();
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $userArray = array('username'=>$username,
                           'email'=>$email,
                           'password'=>$password,
                           'source' => 'S');
        $userObj->createUSer($userArray);

        echo "<p>Register Page</p>";

        echo "<p>$username</p>";
        echo "<p>$email</p>";
        echo "<p>$password</p>";
        /*
         * To change this template, choose Tools | Templates
         * and open the template in the editor.
         */
    ?>
	
</head>
<body>

    <!-- NAVBAR
    ================================================== -->
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container-fluid" style = "padding: 5px 0 5px 0;">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="brand" href="/index.php" style="color: #00B800">Tackster</a>
            <div class="nav-collapse collapse">
              <p class="navbar-text pull-right">
                <a class="btn btn-default" href="/login.php" role = "button" style=" margin: 0 -10px 0px 0">Login</a>
              </p>
            </div><!--/.nav-collapse -->
          </div>
        </div>
      </div>

	<!-- SIGN UP FORM 
	================================================== -->
        <div class="container">
            <section id="content">
                <form action="">
                        <h1>Sign Up</h1>
                        <div>
                            <p>Name:&nbsp;<input type="text" required="" id="username" /></p>
                        </div>
                        <div>
                            <p>Email:&nbsp;<input type="text" required="" id="email" /></p>
                        </div>
                        <div>
                            <p>Password:&nbsp;<input type="password" required="" id="password" /></p>
                        </div>
                        <div>
                            <button class="btn btn-success" type="submit">Sign Up</button>
                            <button class="btn btn-danger" type="cancel" href="/index.php">Cancel</button>
                        </div>
                </form><!-- form -->
                <h6><span  class="line-center">OR</span></h6>
                <a href="#" onClick="MyWindow=window.open('https://www.facebook.com/login.php?skip_api_login=1&api_key=294846713986884&signed_next=1&next=https%3A%2F%2Fwww.facebook.com%2Fdialog%2Foauth%3Fredirect_uri%3Dhttp%253A%252F%252F153.18.33.144%252FDEV%252F%26state%3D7a56d86c0a6c372440bf849d630e2a27%26scope%3Demail%26client_id%3D294846713986884%26ret%3Dlogin&cancel_uri=http%3A%2F%2F153.18.33.144%2FDEV%2F%3Ferror%3Daccess_denied%26error_code%3D200%26error_description%3DPermissions%2Berror%26error_reason%3Duser_denied%26state%3D7a56d86c0a6c372440bf849d630e2a27%23_%3D_&display=page','MyWindow',width=20,height=30); return false;">
                    <img src= "http://i.imgur.com/lYI2b73.png" alt="Sign Up with Facebook" class= "img-rounded"/>
                <br/>
                </a>
            </section>
        </div>

</body>
</html>