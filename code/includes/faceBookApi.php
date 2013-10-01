<?php
require 'facebook.php';


/**
 * faceBookApi is used by the system to make calls to the FaceBook SDK installed
 * in the server.
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
    
    public function __construct()
    {
        $this->facebook = new Facebook(array(
                                    //    'appId'  => '294846713986884', Original API ID
                                        'appId'  => '336997676446819', // barreto dev id
                                    //    'secret' => '984fbb242a0707457aaa3557a83eaaa2', Original secret
                                        'secret' => 'caa37a6cc046b710a50bdfe214e9d4a0', //barreto dev secret
                                 ));
    }
    public function getLogOutUrl()
    {
        return $this->logoutUrl;
    }
    public function getLoginUrl()
    {
        return $this->loginUrl;
    }
    public function getUserProfile()
    {
        return $this->userProfile;
    }
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
