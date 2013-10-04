
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Tackster</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTFYOAEE3kGkMbUrcTErO9THCYE1DPbO05bMv9shxlOrQLY5uMc">
    
    <!-- styles -->
    <link href="/framework/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!--To style the mid section-->
    <style type = "text/css">
      body {
        padding-bottom: 40px;
        color: #5a5a5a;
      }
      div{
        display: block;
      }
      .heading{
        color: white;
      }
      .subheading{
        color: white;
      }
      .marketing-section-signup {
        text-shadow: 0 1px 3px #222;
        background: #202021 url("http://i.imgur.com/KiuQWYq.jpg") center no-repeat;
      }
      .marketing-section {
        position: relative;
        padding-top: 120px;
        padding-bottom: 50px;
        border-bottom: 1px solid #e5e5e5;
      }
      .container {
        width: 980px;
        margin-left: auto;
        margin-right: auto;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
      }
      form {
        display: block;
        margin-top: 0em;
      }
      .homepage .container {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      }
      .form-signup-home {
        float: right;
        width: 300px;
        margin-left: 70px;
      }
      .form-signup-home dl.form {
        position: relative;
        margin-top: 0;
        margin-bottom: 10px;
      }
      .form-signup-home dl.form input[type="text"], .form-signup-home dl.form input[type="password"] {
        width: 100%;
        margin-right: 0;
        border-color: white;
      }
      .form-signup-home dl.form button{
        margin-left: 222px;
        width: 80px;
      }
    </style> 
  
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
                  <a class="btn btn-default" href="/login.php" role = "button" style=" margin: 0 -10px 0px 0">Login with email</a>
                </p>
                <p class="navbar-text pull-right">
                  <a href="#" onClick="MyWindow=window.open('https://www.facebook.com/login.php?skip_api_login=1&api_key=294846713986884&signed_next=1&next=https%3A%2F%2Fwww.facebook.com%2Fdialog%2Foauth%3Fredirect_uri%3Dhttp%253A%252F%252F153.18.33.144%252FDEV%252F%26state%3D7a56d86c0a6c372440bf849d630e2a27%26scope%3Demail%26client_id%3D294846713986884%26ret%3Dlogin&cancel_uri=http%3A%2F%2F153.18.33.144%2FDEV%2F%3Ferror%3Daccess_denied%26error_code%3D200%26error_description%3DPermissions%2Berror%26error_reason%3Duser_denied%26state%3D7a56d86c0a6c372440bf849d630e2a27%23_%3D_&display=page','MyWindow','width=50px','height=10px'); return false;">
                  <img src = "http://i.imgur.com/wfKcSNX.png" alt="Login with Facebook" class="img-rounded" style ="margin: 0px 10px 0px 10px;"/></a>             
                </p>
              </div><!--/.nav-collapse -->
            </div>
          </div>
        </div>

      <!-- MID SECTION
      ================================================== -->
        <div id="site-container" class="context-loader-container" data-pjax-container="">       
          <div class="marketing-section marketing-section-signup">
            <div class="container">
              <form accept-charset="UTF-8" autocomplete="off" class="form-signup-home js-form-signup-home" method="post">      
                  <dl class="form">
                    <dd>
                      <input type="text" name="loginName" class="textfield" required="" placeholder="Name" autofocus="">
                    </dd>
                  </dl>
                  <dl class="form">
                    <dd>
                      <input type="text" name="loginEmail" class="textfield" required="" placeholder="Email">
                    </dd>
                  </dl>
                  <dl class="form">
                    <dd>
                      <input type="password" name="loginPassword" class="textfield" required="" placeholder="Password">
                    </dd>
                  </dl>
                  <dl class="form">
                    <dd>
                      <button class="btn btn-success" type="submit" >Sign up</button>
                    </dd>
                  </dl>
              </form>
              <h1 class="heading">Explore, and Share your Interests</h1>
              <p class="subheading">Easier and a faster way to blah blah blah...</p>
            </div><!-- /.container -->
        </div>

      <!--FOOTER
      ================================================-->
        <footer>
          <br/>
          <p>&copy; 2013 Tackster, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
        </footer>


  <script type = "text/javascript" src = "http://code.jquery.com/jquery-1.10.1.min.js"> </script>
  <script type = "text/javascript" src = "/framework/bootstrap/js/bootstrap.js"></script>
 
 
</body>
        
</html>
