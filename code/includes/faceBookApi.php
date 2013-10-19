<?php
require 'facebook.php';


/**
 * FaceBookApi is used by the system to make calls to the FaceBook SDK installed
 * in the server and provide the functions to login and logout.
 *
 * @author Luis Barreto
 */
class faceBookApi
{
    private $facebook;
    private $logoutUrl;
    private $loginUrl;
    private $userProfile;
    private $user;
    /**
     * Creates a new Facebook object which allows the system to access
     * Facebook information.
     */
    public function __construct()
    {
        $this->facebook = new Facebook(array(
                                    //    'appId'  => '294846713986884', Original API ID
                                        'appId'  => '336997676446819', // barreto dev id
                                    //    'secret' => '984fbb242a0707457aaa3557a83eaaa2', Original secret
                                        'secret' => 'caa37a6cc046b710a50bdfe214e9d4a0', //barreto dev secret
                                 ));
    }
    /**
     * Returns the URL for the user to logout, so that the user can logout from
     * our website.
     * @return type Returns a URL. 
     */
    public function getLogOutUrl()
    {
        return $this->logoutUrl;
    }
    /**
     * This returns the login URL to Facebook
     * 
     * @return type This returns a URL from Facebook
     */
    public function getLoginUrl()
    {
        return $this->loginUrl;
    }
    /**
     * This returns the user's information in the form of a profile.
     * @return type This returns a user profile.
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }
    /** 
      * If the user that is logged in is the correct user, then return their information.
      * If the user that is logged in is not the correct user, then get the loginURL.
      * @return True if the user was the correct user, return False otherwise.
     */
    public function setUserState()
    {
        $status = FALSE;
        $this->user = $this->facebook->getUser();
        if ($this->user)
        {
            $this->logoutUrl = $this->facebook->getLogoutUrl();
            $this->getUserInfo();
            $status = TRUE;
        }
        else
        {
            $this->loginUrl = $this->facebook->getLoginUrl(array('scope' => 'email'));
            $status = FALSE;
        }
        return $status;
    }
    /**
     * This function returns the user data based on the facebook login.
     */
    public function getUserInfo()
    {
        if ($this->user)
        {
            try 
            {
                // Proceed knowing you have a logged in user who's authenticated.
                $this->userProfile = $this->facebook->api('/me');
            }
            catch (FacebookApiException $e)
            {
                error_log($e);
                $this->user = null;
            }
        }
    }
}

?>
