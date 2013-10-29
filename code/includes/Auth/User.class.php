<?php

require_once 'Utility/MyException.class.php';
require_once 'DataBase.php';
require_once 'mandrillApi.php';
require_once 'Configs/defineSalt.php';

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
	private $password;
	private $state;
	private $fromFB;
	private $about;
	private $gender;

	//private $userInfoArray;

	/**
	 * Stores all the information that is passed in from the array.
	 * Queries the Tackster Database to enter this information.
	 * @param type $userDataArray This is the passed data from when the user
	 * hits submit.
	 */
	public function createUser($userDataArray) {
		$this->fname = $userDataArray['fname'];
		$this->lname = $userDataArray['lname'];
		$this->email = $userDataArray['email'];
		//$this->password = $userDataArray['password'];
		$tempPwd = $userDataArray['password'];
		$this->gender = $userDataArray['gender'];
		$this->state = "p";
		$this->fromFB = $userDataArray['source'];

		//TODO: Look at bookmark class for sample try/catch block around DB code
		$sqlObj = new DataBase();
		$this->password = $this->encyptPwd($tempPwd);

		$query = "INSERT INTO  `db_tackster`.`user_credentials` (
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
		$credentialID = $sqlObj->DoQuery($query);
		$query = "INSERT INTO `db_tackster`.`user_profile` (`uc_id`, `id`, `first`,
                `last`, `username`, `sex`, `bio`, `photo`, `timestamp`)
                VALUES
                ('$credentialID', NULL, '$this->fname', '$this->lname', '$this->email', '$this->gender',
                NULL, NULL, CURRENT_TIMESTAMP);";
		$sqlObj->DoQuery($query);
		$sqlObj->destroy();
		$this->sendConfEmail();
	}

	/**
	 * This function updates user credentials based on the userDataArray
	 * object. This function is currently not implemented, will be implemented on a future date.
	 *
	 * @param type $userDataArray This is the passed data from when the user
	 * hits submit.
	 * @return boolean This boolean is defaulted to TRUE since the function isn't implemented yet.
	 */
	public function updateUser($userDataArray) {
		//TODO: Implement method
//		throw new MyException('Method createUser() not implemented');
		return TRUE;
	}

	/**
	 * Creates a hash of 128 characters in length based on a passphrase using a salt.
	 *
	 * @param type $string This is the password that is input.
	 * @return type This is a hashed numeric value to check against the input password.
	 */
	public function encyptPwd($pwd) {
		$passPhrase = SALT_PASS . $pwd;
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
        /** This function creates a Password reset email and dends it to the user
         * @param type $email the email of the user
         */
        public function sendResteEmail($email, $pwd){
            	$to = array($this->email => $this->fname . " " . $this->lname);
		$emailObj = new mandrillApi($to, "Passwowrd Successfuly reseted");
		$htmlString = "<html>
                    <h1>Your passwd was successfuly resset</hi>
                    <p>Your new password is: $pwd</p>
                    </html>";
		$emailObj->createEmail($htmlString);
		$emailObj->sendEmail();

        }

	/** This function creates an Email object with
	 * a welcome message confirming account creation.
	 */
	public function sendConfEmail() {
		$to = array($this->email => $this->fname . " " . $this->lname);
		$emailObj = new mandrillApi($to, "Welcome to Tackster.com");
		$htmlString = "<html>
                    <h1>Welcome</hi>
                    <p>This is a test email generated by our login system</p>
                    </html>";
		$emailObj->createEmail($htmlString);
		$emailObj->sendEmail();
	}

	/** Searches for a user by doing a query with the user credentials with the database.
	 *
	 * @param type $email The email of the user.
	 * @return boolean  True if the user was found, False if the user was not found
	 */
	public function searchUser($email) {

		//TODO: Look at bookmark class for sample try/catch block around DB code
		$sqlObj = new DataBase();
		$found = FALSE;
		$query = "SELECT *
                    FROM  `user_credentials`
                    WHERE  `email` LIKE  '$email'";
		$sqlObj->DoQuery($query);
		$num = $sqlObj->getNumberOfRecords();
		if ($num > 0) {
			$found = TRUE;
		} else {
			$found = FALSE;
		}
		return $found;
		$sqlObj->destroy();
	}

	/** Loads the user information based on the e-mail address that is provided. This queries the
	 * database to retrieve all of the user credentials, such as first and last name.
	 *
	 * @param type $email The email address of the user
	 * @return null The result of the query against the database. This will store the user data.
	 * @throws MyException This exception is thrown in the case that there is a duplicate credential
	 * email.
	 */
	public function loadUser($email) {

		//TODO: Look at bookmark class for sample try/catch block around DB code
		$sqlObj = new DataBase();
		$query = "SELECT  `uc_id`, `first` ,  `last` ,  `sex`, `username`
                  FROM  `user_profile`
                  WHERE  `uc_id` = (
                    SELECT  `id`
                    FROM  `user_credentials`
                    WHERE  `email`='{$email}'
                    )
                ";
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

		return $result;
	}

	/*	 * This function logs in a user by taking their e-mail and password that they provide through the log in page.
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
                    AND  `password`='{$sha512}'";

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

	/*	 * This function ends a users session with the server and logs them out of their account.
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
        /** This function loads a user object and based on an email provided provides
         * the facility to reset a user's password.
         * @param type $email The email address of the user
         */
        public function resetPassword($email,$newPWD){
            if($this->searchUser($email)==TRUE){
                $this->loadUser($email);
                $sqlObj = new DataBase();
                $newEncryptedPWD = $this->encyptPwd($newPWD);
                $query = "UPDATE  `db_tackster`.`user_credentials` SET
                         `password` = '$newEncryptedPWD' WHERE
                         `user_credentials`.`email` = '$email'";
                $sqlObj->DoQuery($query);
                $sqlObj->destroy();
                $this->sendResteEmail($email, $newPWD);

            }
            else{
                throw new MyException('User Profile not found');
            }
        }

}

?>
