<?php
//session_start();
//$loggedIn = $_SESSION['loggedin'];
require_once('Utility/EnvUtilities.class.php');

$searchWord = (isset($_POST['searchWord'])) ? $_POST['searchWord']: NULL;

//TODO: Add logic to check if user is or isn't logged in

/*
 * Give navigtion based on user's authentication.
 */

/*
 * Pseudo Code
 * - check session for logged in state
 * - if loggedIn, show logged in nav
 * - else, show default nav
 */

//Variables
$loggedIn = (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) ? TRUE : FALSE;
$userName = (isset($_SESSION['profile']['first'])) ? $_SESSION['profile']['first'] : "My Profile";

//User login status check and set show navigation variable
if (isset($_SESSION['loginState']) && $_SESSION['loginState'] == 1) {
	$loggedIn = TRUE;
}
?>

<?php if ($loggedIn) { //show logged in-nav ?>

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container-fluid" style= "margin-left: -10px; margin-right: -5px;">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <div class="nav-collapse collapse">
              <ul class="nav">
                <li class="dropdown">
                <a href="/" class="dropdown-toggle" data-toggle="dropdown" style="color: #00B800; font-size: 20px;">Tackster <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="/dashboard/">My Dashboard</a></li>
                  <li><a href="/dashboard/followingTacks.php">Following Tacks</a></li>
                  <li><a href="/search/">Suggested Bookmarks</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Add Tacks</a></li>
                  <li><a href="#">Add Bookmark</a></li>
                </ul>
              </li>
              </ul>
              <form action="/search/" method="post" name="search" id="search" class="navbar-search pull-left">
                <input type="text" name="searchWord" id="searchWord" maxlength="40" class="search-query" placeholder="Search">
              </form>

              <div class="btn-group pull-right">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                  <?php echo_formData($userName) ?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/account/">Profile</a></li>
                  <li><a href="/auth/logout.php">Logout</a></li>
                </ul>
              </div> <!-- closing btn-group -->
            </div>
          </div>  <!-- closing container-fluid-->
        </div>  <!-- closing navbar-inner-->
      </div>  <!-- closing navbar-->

<?php } else { //show standard nav ?>

        <div class="navbar navbar-fixed-top">
          <div class="navbar-inner">
            <div class="container-fluid">
              <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="brand" href="/" style="color: #00B800">Tackster</a>
              <div class="nav-collapse collapse">
                <p class="navbar-text pull-right">
                  <a class="btn btn-default" href="/auth/login.php" role = "button" style=" margin: 0 -10px 0px 0">Login with email</a>
                </p>
                <p class="navbar-text pull-right">
                  <a href="#" onClick="MyWindow=window.open('https://www.facebook.com/login.php?skip_api_login=1&api_key=294846713986884&signed_next=1&next=https%3A%2F%2Fwww.facebook.com%2Fdialog%2Foauth%3Fredirect_uri%3Dhttp%253A%252F%252F153.18.33.144%252FDEV%252F%26state%3D7a56d86c0a6c372440bf849d630e2a27%26scope%3Demail%26client_id%3D294846713986884%26ret%3Dlogin&cancel_uri=http%3A%2F%2F153.18.33.144%2FDEV%2F%3Ferror%3Daccess_denied%26error_code%3D200%26error_description%3DPermissions%2Berror%26error_reason%3Duser_denied%26state%3D7a56d86c0a6c372440bf849d630e2a27%23_%3D_&display=page','MyWindow','width=50px','height=10px'); return false;">
                  <img src = "http://i.imgur.com/wfKcSNX.png" alt="Login with Facebook" class="img-rounded" style ="margin: 0px 10px 0px 10px;"/></a>
                </p>
              </div><!--/.nav-collapse -->
            </div>
          </div>
        </div>

<?php } ?>
