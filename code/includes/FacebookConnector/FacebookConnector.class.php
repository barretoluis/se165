<?php

require 'Configs/defineFb.php';
require 'FacebookConnector/Framework/facebook.php';

/**
 * FaceBookApi is used by the system to make calls to the FaceBook SDK installed
 * in the server and provide the functions to login and logout.
 *
 * @author Luis Barreto
 */
//class faceBookApi {
class FacebookConnector {

	private $Facebook = NULL;
	private $logoutUrl = NULL;
	private $loginUrl = NULL;
	private $userProfile = NULL;
	private $user = NULL;

	/**
	 * Creates a new Facebook object which allows the system to access
	 * Facebook information.
	 */
	public function __construct() {
		$fb = new facebook(array(
					'appId' => FB_APP_ID,
					'secret' => FB_APP_SECRET
				));
		$this->Facebook = $fb;
		$this->setUserState();
	}

	/**
	 * Returns the URL for the user to logout, so that the user can logout from
	 * our website.
	 * @return type Returns a URL.
	 *
	 */
	public function getLogOutUrl() {
		return $this->logoutUrl;
	}

	/**
	 * This returns the login URL to Facebook
	 *
	 * @return type This returns a URL from Facebook
	 */
	public function getLoginUrl() {
		$this->setUserState();
		return $this->loginUrl;
	}

	/**
	 * This returns the user's information in the form of a profile.
	 * @return type This returns a user profile.
	 */
	public function getUserProfile() {
		return $this->userProfile;
	}

	/**
	 * If logged in already, get user's profile information from FaceBook.
	 * If not logged in, get the FB login URL - allowing the user to login via FB.
	 * @return True if the user was the correct user, return False otherwise.
	 */
	private function setUserState() {
		$status = FALSE;
		$this->user = $this->Facebook->getUser();
		if ($this->user) {
			$this->logoutUrl = $this->Facebook->getLogoutUrl();
			$this->getUserInfo();
			$status = TRUE;
		} else {
			$this->loginUrl = $this->Facebook->getLoginUrl(array('scope' => 'email'));
			$status = FALSE;
		}
		return $status;
	}

	/**
	 * This function returns the user data based on the facebook login.
	 */
	public function getUserInfo() {
		if ($this->user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$this->userProfile = $this->Facebook->api('/me');
			} catch (FacebookApiException $e) {
				error_log($e);
				echo $e;
				$this->user = NULL;
				$this->userProfile = NULL;
			}
		}
		return $this->userProfile;
	}

	/**
	 * Ends the Facebook session
	 */
	public function logoutUser() {
		$this->setUserState(); //if user is logged in, let's make sure the state is updated
		if ($this->getLogOutUrl() != NULL) {
			header('Location: ' . $this->getLogOutUrl());
		}
	}

	/**
	 * Destroy FB Session
	 */
	public function destroyFBSession() {
		$this->destroyFBSession();
	}

}

?>
