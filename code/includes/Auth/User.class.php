<?php

/*
  //  for windows users? maybe.
  require_once __DIR__ . '\..\Utility\MyException.class.php';
  require_once __DIR__ . '\..\DataBase.php';
  require_once __DIR__ . '\..\mandrillApi.php';
  require_once __DIR__ . '\..\Configs\defineSalt.php';
  require_once __DIR__ . '\..\Configs\defineUser.php';
 */
require_once 'Utility/MyException.class.php';
require_once 'Utility/EnvUtilities.class.php';
require_once 'DataBase.php';
require_once 'mandrillApi.php';
require_once 'Configs/defineSalt.php';
require_once 'Configs/defineUser.php';

/**
 * Description of user.
 * Stores the user credentials and stores it in the database.
 * Handles authentication for encrypting the users login.
 *
 * @author Luis Barreto
 */
class User {

	private $uid;
	private $lname;
	private $fname;
	private $email;
	private $username;
	private $password;
	private $state;
	private $fromFB;
	private $about;
	private $gender;
	private $_errorMsg = Array();

	//private $userInfoArray;

	/**
	 * Stores all the information that is passed in from the array.
	 * Queries the Tackster Database to enter this information.
	 * @param type $userDataArray This is the passed data from when the user
	 * hits submit.
	 * White box testing is limited here due to the nature of private keys in our database;
	 * there is little automation that we can do since we would need to create a new user
	 *  @assert (array("fname" => "Robert", "lname" => "Lee", "email" => "test@test.com",
	  "password" => "password", "gender" => "M", "source" => "I")) == FALSE
	 */
	public function createUser($userDataArray) {
		$this->fname = (isset($userDataArray['fname'])) ? $userDataArray['fname'] : NULL;
		$this->lname = (isset($userDataArray['lname'])) ? $userDataArray['lname'] : NULL;
		$this->email = (isset($userDataArray['email'])) ? $userDataArray['email'] : NULL;
		$this->username = (isset($userDataArray['email'])) ? $userDataArray['email'] : NULL;
		$tempPwd = (isset($userDataArray['password'])) ? $userDataArray['password'] : NULL;
		$this->gender = (isset($userDataArray['gender'])) ? $userDataArray['gender'] : NULL;
		$this->state = "p";
		$this->fromFB = (isset($userDataArray['source'])) ? $userDataArray['source'] : NULL;

		//TODO: Look at bookmark class for sample try/catch block around DB code
		$sqlObj = new DataBase();
		$this->password = $this->encryptPwd($tempPwd);

		$query = "INSERT INTO  `user_credentials` (
                    `id` ,
                    `email` ,
                    `password` ,
                    `state` ,
                    `fromFB` ,
                    `acct_created`
                )
                VALUES (
                    NULL ,  '$this->email',  '$this->password',  '$this->state',
                    '$this->fromFB', CURRENT_TIMESTAMP
                );";
		try {
			//let's try to create a simple credential record
			$createProfileResult = $credentialID = $sqlObj->DoQuery($query);
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
			return FALSE;
		}


		$query = "INSERT INTO `user_profile` (`uc_id`, `id`, `first`,
                `last`, `username`, `sex`, `bio`, `photo`, `timestamp`)
                VALUES
                ('$credentialID', NULL, '$this->fname', '$this->lname', '$this->username', '$this->gender',
                NULL, NULL, CURRENT_TIMESTAMP);";
		try {
			//now let's add the user's profile information
			$sqlObj->DoQuery($query);
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
			return FALSE;
		}

		$sqlObj->destroy();
		$this->sendConfEmail();
		return TRUE;
	}

	/**
	 * This function updates user credentials based on the userDataArray
	 * object. The function checks to see what areas of the userData needs
	 * to be updated, and then proceeds to update those fields.
	 *
	 * @param type $userDataArray This is the passed data from when the user
	 * hits submit.
	 * @return array Returns an array of errors. NULL if transaction was successful.
	 */
	public function updateUser($userId, $userDataArray) {
		$this->uid = (int) $userId;
		$this->fname = $userDataArray['fname'];
		$this->lname = $userDataArray['lname'];
		$this->email = $userDataArray['email'];
		$this->username = $userDataArray['username'];
		$tempPwd = $userDataArray['password'];
		$this->password = $this->encryptPwd($tempPwd);
		$this->gender = $userDataArray['gender'];

		//TODO: Look at bookmark class for sample try/catch block around DB code
		$sqlObj = new DataBase();

		//Update email if needed
		if ($this->email != $_SESSION['profile']['email'] && $this->uid) {
			if ($this->searchUser($this->email)) {
				//email already exists
				array_push($this->_errorMsg, "Email address already exists. Please try another one.");
			} else {
				$query = "UPDATE `user_credentials` SET email='" . $this->email . "  ' WHERE id='" . $this->uid . "'";
				$result = $sqlObj->DoQuery($query);
			}
		}

		//Update password if needed
		if ($tempPwd && $this->uid) {
			$query = "UPDATE `user_credentials` SET password='" . $this->password . "  ' WHERE id='" . $this->uid . "'";
			$result = $sqlObj->DoQuery($query);
		}

		//Update profile if needed
		//Construct fields
		$_queryCols = Array();
		array_push($_queryCols, (isset($this->fname)) ? "first='" . $this->fname . "'" : '');
		array_push($_queryCols, (isset($this->lname)) ? "last='" . $this->lname . "'" : '');
		array_push($_queryCols, (isset($this->username)) ? "username='" . $this->username . "'" : '');
		array_push($_queryCols, (isset($this->gender)) ? "sex='" . $this->gender . "'" : '');

		if ($this->uid && count($_queryCols) > 0) {
			$queryColsVals = implode(", ", $_queryCols);
			$query = "UPDATE `user_profile` SET {$queryColsVals} WHERE uc_id='" . $this->uid . "'";
			$result = $sqlObj->DoQuery($query);
		}

		//Reload session profile with updated data from the DB
		$_SESSION['profile'] = $this->loadUser($this->email);

		$sqlObj->destroy();

		return $_errorMsg;
	}

	/**
	 * Creates a hash of 128 characters in length based on a passphrase using a salt.
	 * @param type $string This is the password that is input.
	 * @return type This is a hashed numeric value to check against the input password.
	 * @assert ('password') != 'password'
	 */
	public function encryptPwd($pwd) {
		$passPhrase = SALT_PASS . $pwd;
		$sha512 = hash('sha512', $passPhrase);
		return $sha512;
	}

	/**
	 * Creates a hash of 128 characters in length based on a passphrase using a salt.
	 * @param type $string This is the password that is input.
	 * @return type This is a hashed numeric value to check against the input password.
	 * @assert ('password') != 'password'
	 */
	private function createToken($seed) {
		$passPhrase = SALT_TOKEN . $seed;
		$sha512 = hash('sha512', $passPhrase);
		return $sha512;
	}

	/** This function checks the a password against the current password in
	 * the database. It will return TRUE or FALSE depending on the comparison
	 * between the input password, after being hashed, and the stored hashed password.
	 * @param type $postPwd The password that is being checked
	 * @param type $dbPwd The hashed password taken from the database
	 * @return boolean Returns TRUE if the password is the same as the stored password,
	 * and FALSE if the password is different.
	 * @assert ('tack', '3e818eec51b45583b9881f5f2fe455413483848ab61ba10a0c4914d5cfb24a155dfc70b707b948c1ae7ce175b7ee6f0d54487d07fcc147f813e0283346bb023c') == TRUE
	 * @assert ('tack', '129dkjsf0') == FALSE
	 */
	public function checkPassword($postPwd, $dbPwd) {
		//TODO: I don't believe this method has been tested or used anywhere in the code. Need to verify.
		$match = FALSE;
		$passPhrase = SALT_PASS;
		$sha512 = hash('sha512', SALT_PASS . $postPwd);
		if (strcmp($sha512, $dbPwd) == 0) {
			$match = TRUE;
		} else {
			$match = FALSE;
		}
		return $match;
	}

	/**
	 * This function creates a Password reset email and dends it to the user
	 *  @TODO change functionname
	 *
	 * @param type $email the email of the user
	 * @assert ('tack@tackster.com', 'param2') != Exception
	 */
	public function sendResetEmail($email, $url) {
		$this->email = $email;
		$to = array($this->email => $this->fname . " " . $this->lname);
		$emailObj = new mandrillApi($to, "Reset Your Password");
		$htmlString = <<<EOF
<h3>Password Reset Request Recieved</h3>
<p>Your request to reset your password was successfully recieved. Please click on the link below to complete the reset. All requests will be canceled 15 minutes after we received it.</p>
<p><a href="$url">Complete Reset by Clicking Here</a></p>

<p>Or if the above link does not work for you. Please copy and paste the below link into your web browser.</p>
<pre>$url</pre>
EOF;
		$emailObj->createEmail($htmlString);
		$emailObj->sendEmail();
	}

	/**
	 * This function creates an Email object with
	 * a welcome message confirming account creation.
	 */
	public function sendConfEmail() {
		$to = array($this->email => $this->fname . " " . $this->lname);
		$emailObj = new mandrillApi($to, "Welcome to Tackster.com");
		$htmlString = <<<EOF
<h3>Welcome to Tackster.com</h3>
<p>You have now registered with <a href="http://www.tackster.com">Tackster.com</a>.
We figure we should keep the greeting short and get you started right away!</p>
Let's go to the site by <a href="http://www.tackster.com"><b>Visting Tackster.com</b></a>!
EOF;
		$emailObj->createEmail($htmlString);
		$emailObj->sendEmail();
	}

	/**
	 * Searches for a user by doing a query with the user credentials with the database.
	 *
	 * @param type $email The email of the user.
	 * @return int  -1 for false. Otherwise User ID.
	 * @assert ('test@test.com') != FALSE
	 * @assert ('notauser@random.org') == FALSE
	 */
	public function searchUser($email) {

		//TODO: Look at bookmark class for sample try/catch block around DB code
		$sqlObj = new DataBase();
		$found = FALSE;

		$query = "SELECT * FROM  `user_credentials` WHERE  `email`='$email'";

		try {
			$sqlObj->DoQuery($query);
			$resultset = $sqlObj->GetData();

			$num = $sqlObj->getNumberOfRecords();
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}
		if ($num == 1) {
			$id = $resultset[0]['id'];
			$found = $id;
		} else {
			$found = -1;
		}
		$sqlObj->destroy();

		return $found;
	}

	/**
	 * Deletes token for resetting a password.
	 * @param string $email Email for which a token was previously generated.
	 * @return bool TRUE on successful delete
	 *
	 */
	public function deleteResetPassToken($email) {
		$sqlObj = new DataBase();
		try {
			$ucId = (int) $this->searchUser($email);
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}

		if ($ucId != -1) {
			try {
				$query = "DELETE FROM tkn_password_reset WHERE uc_id='{$ucId}';";
				$sqlObj->DoQuery($query);
				$sqlObj->destroy();
			} catch (MyException $e) {
				$e->getMyExceptionMessage();
				return FALSE;
			}
		}

		return TRUE;
	}

	/**
	 * Deletes the user account.
	 * @param email
	 *
	 */
	public function deleteUser($email) {
		$sqlObj = new DataBase();
		$id = (int) $this->searchUser($email);
		if ($id != FALSE) {
			$query = "DELETE FROM `db_tackster`.`user_credentials` WHERE `user_credentials`.`id`=$id";
			$sqlObj->DoQuery($query);
			$query = "DELETE FROM `db_tackster`.`user_profile` WHERE `user_profile`.`uc_id` = $id";
			$sqlObj->DoQuery($query);
			$query = "DELETE FROM `db_tackster`.`track` WHERE `track`.`uc_id` = $id";
			$sqlObj->DoQuery($query);
			$query = "DELETE FROM `db_tackster`.`bmk_activity` WHERE `bmk_activity`.`uc_id` = $id";
			$sqlObj->DoQuery($query);
			$query = "DELETE FROM `db_tackster`.`bmk_entry` WHERE `bmk_entry`.`uc_id` = $id";
			$sqlObj->DoQuery($query);
			$query = "DELETE FROM `db_tackster`.`bmk_activity` WHERE `bmk_activity`.`uc_id` = $id";
			$sqlObj->DoQuery($query);
		}
		$sqlObj->destroy();
	}

	/**
	 * Checks to see if this is a new user.
	 *
	 * @param string $email The email address of the user
	 * @return bool Return TRUE if new user.
	 * @throws MyException This exception is thrown in the case that there is a duplicate credential
	 * email.
	 *
	 */
	public function isNewUser($email) {
		$dayDuration = (int) DB_NEW_USER_TIME;
		$sqlObj = new DataBase();
		$query = "SELECT id AS uc_id FROM user_credentials WHERE email='{$email}' AND acct_created>= DATE_SUB(NOW(), INTERVAL {$dayDuration} DAY);";

		try {
			$sqlObj->DoQuery($query);
			$result = $sqlObj->GetData();
			$sqlObj->destroy();
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
			return FALSE;
		}

		//Let's make sure we're only returning one result
		if (count($result) == 1) {
			return TRUE;
		} else {
			throw new MyException('ERROR: We may have duplicate records for User Credential email: {$email}.');
		}
		return FALSE;
	}

	/**
	 * Loads the user information based on the e-mail address that is provided. This queries the
	 * database to retrieve all of the user credentials, such as first and last name.
	 *
	 * @param string $email The email address of the user
	 * @return array The result of the query against the database. This will store the user data.
	 * @throws MyException This exception is thrown in the case that there is a duplicate credential
	 * email.
	 *
	 */
	public function loadUser($email) {

		//TODO: Look at bookmark class for sample try/catch block around DB code
		$sqlObj = new DataBase();
		$query = "SELECT id AS uc_id, first, last, email, username, sex FROM v_returnShortUserProfile WHERE email='{$email}';";

		$sqlObj->DoQuery($query);
		$result = $sqlObj->GetData();

		//Let's make sure we're only returning one result
		if (count($result) == 1) {
			$result = $result[0]; //break the multi-dimensional array since this should only be 1 record
		} elseif (count($result) > 1) {
			$result = NULL;
			throw new MyException('ERROR: We have duplicate records for User Credential email: {$email}.');
		} else {
			$result = NULL;
		}

		$sqlObj->destroy();

		return $result;
	}

	/**
	 * Loads the user information based on the e-mail address that is provided. This queries the
	 * database to retrieve all of the token information for resetting a password.
	 *
	 * @param string $email The email address of the user
	 * @return array The result of the query against the database. This will store the user data.
	 * @throws MyException This exception is thrown in the case that there is a duplicate credential
	 * email.
	 *
	 */
	public function loadPassResetToken($email) {
		//TODO: Look at bookmark class for sample try/catch block around DB code
		$sqlObj = new DataBase();

		$query = "SELECT uc_id, id, token, timestamp FROM tkn_password_reset WHERE uc_id='{$email}';";

		try {
			$sqlObj->DoQuery($query);
			$result = $sqlObj->GetData();
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
			return NULL;
		}

		//Let's make sure we're only returning one result
		if (count($result) == 1) {
			$result = $result[0]; //break the multi-dimensional array since this should only be 1 record
		} elseif (count($result) > 1) {
			$result = NULL;
			throw new MyException('ERROR: We have duplicate records for User Credential email: {$email}.');
		} else {
			$result = NULL;
		}

		$sqlObj->destroy();

		return $result;
	}

	/**
	 * This function logs in a user by taking their e-mail and password that they provide through the log in page.
	 *
	 * @param type $email The email address of the user
	 * @param type $pwd The password of the user
	 * @throws MyException This exception is thrown when the user was not able to be logged in. For example, if their credentials
	 * don't match that stored on the database.
	 */
	public function logInUser($email, $pwd) {

		//TODO: Look at bookmark class for sample try/catch block around DB code
		$sqlObj = new DataBase();
		$passPhrase = SALT_PASS . $pwd;
		$sha512 = hash('sha512', $passPhrase);
		$query = "SELECT  `id`, `email` ,  `password` ,  `state` ,  `fromFB`
                    FROM  `user_credentials`
                    WHERE  `email`='{$email}'
                    AND  `password`='{$sha512}'
					AND fromFB='I'";

		$sqlObj->DoQuery($query);
		$num = $sqlObj->getNumberOfRecords();
		if ($num > 0) {
			// Double check a session already exists, else start one
			if (!isset($_SESSION)) {
				session_start();
			}

			//Set some basic session items
			$_SESSION['loggedin'] = TRUE;

			//create info array
			$_SESSION['profile'] = $this->loadUser($email);
			$_SESSION['uc_id'] = $_SESSION['profile']['uc_id']; //get user login id
			header('Location: /dashboard/');
		} else {
			$_SESSION['loggedin'] = FALSE;
			throw new MyException('User: ' . $email . ' was not able to login using encrypted password (' . $sha512 . ').');
			header('Location: /auth/login.php');
		}
	}

	/**
	 * This function logs in a user by taking their e-mail that they provide through the Facebook log in page.
	 *
	 * @param type $email The email address of the user
	 * @throws MyException This exception is thrown when the user was not able to be logged in. For example, if their credentials
	 * don't match that stored on the database.
	 */
	public function logInFbUser($email) {
		// Double check a session already exists, else start one
		if (!isset($_SESSION)) {
			session_start();
		}

		$sqlObj = new DataBase();
		$query = "SELECT  `id`, `email`, `state` , `fromFB`
                    FROM  `user_credentials`
                    WHERE  `email`='{$email}'
					AND fromFB='F'";

		$sqlObj->DoQuery($query);
		$num = $sqlObj->getNumberOfRecords();

		//make sure no records were returned
		if ($num == 1) {
			//Set some basic session items
			$_SESSION['loggedin'] = TRUE;

			//create info array
			$_SESSION['profile'] = $this->loadUser($email);
			$_SESSION['uc_id'] = $_SESSION['profile']['uc_id']; //get user login id
		} else {
			throw new MyException('Account already created as a Tackster account. Please login with your email and password.');
		}
	}

	/**
	 * This function ends a users session with the server and logs them out of their account,
	 *  it requires an active connection.
	 *  This is untestable using white box testing.
	 *
	 */
	public function logOutUser() {
		if (isset($_SESSION)) {
			unset($_SESSION);
			session_unset();
			session_destroy();
		}
		header('Location: /');
	}

	/**
	 * This function loads a user object and based on an email provided provides
	 * the facility to reset a user's password.
	 * @param type $email The email address of the user
	 * @return bool Return true on successful reset.
	 * @throws MyException Returns error message and returns FALSE on exception.
	 */
	public function resetPassword($email, $newPWD) {
		if ($newPWD == NULL) {
			throw new MyException('No password was provided.');
			return FALSE;
		} elseif ($email == NULL) {
			throw new MyException('No email was provided.');
			return FALSE;
		}

		if ($this->searchUser($email) == TRUE) {
			$this->loadUser($email);
			$newEncryptedPWD = $this->encryptPwd($newPWD);

			$query = "UPDATE `user_credentials` SET `password` = '$newEncryptedPWD' WHERE `user_credentials`.`email` = '$email'";

			try {
				$sqlObj = new DataBase();
				$sqlObj->DoQuery($query);
				$sqlObj->destroy();

				return TRUE;
			} catch (MyException $e) {
				throw new MyException('Not able to reset password. Please try again.');

				return FALSE;
			}
		} else {
			throw new MyException('User Profile not found');
		}
		return FALSE;
	}

	/**
	 * This function loads a user object and based on an email provided provides
	 * the facility to reset a user's password.
	 * @param type $email The email address of the user
	 *
	 * @return bool Return true on successful reset.
	 */
	public function resetPassGenToken($email) {
		$resetUrl = NULL;

		if ($this->searchUser($email) == TRUE) {

			$Util = new EnvUtilities();
			$token = $this->createToken($Util->RandomString(15));
			$ucId = NULL;
			//TODO: Should be in config file rather than hard coded
			$resetUrl = "http://" . $_SERVER['SERVER_NAME'] . "/auth/forgotPassword.php?e=" . urlencode($email) . "&t=" . urlencode($token);

			//do we even have a user account for this person
			$_loadUser = $this->loadUser($email);
			if (isset($_loadUser)) {
				$this->ucId = $_loadUser['uc_id'];
				$this->fname = $_loadUser['first'];
				$this->lname = $_loadUser['last'];
			} else {
				throw new MyException('User account not in system. Try another email or username.');
				return FALSE;
			}

			//prep the DB query to insert a token
			$queryDelete = "DELETE FROM tkn_password_reset WHERE uc_id='{$this->ucId}';";
			$query = "INSERT INTO tkn_password_reset (uc_id, token) VALUES ('$this->ucId', '{$token}');";

			try {
				$sqlObj = new DataBase();
				$sqlObj->DoQuery($queryDelete);
				time_nanosleep(0, 500000000); //let's make sure delete of old records is done
				$sqlObj->DoQuery($query);
				$sqlObj->destroy();
				try {
					$this->sendResetEmail($email, $resetUrl);
				} catch (MyException $e) {
					throw new MyException($e->getMessage());
				}

				return TRUE;
			} catch (MyException $e) {
				throw new MyException('Not able to reset password. Please try again.' . $e->getMessage());

				return FALSE;
			}
		} else {
			throw new MyException('User profile not found.');
			return FALSE;
		}
	}

}

?>
