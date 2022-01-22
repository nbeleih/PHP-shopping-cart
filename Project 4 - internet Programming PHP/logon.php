<?php

$EMAIL_ID = 545314318; // 9-digit integer value (i.e., 123456789)

require_once '/home/common/php/dbInterface.php'; // Add database functionality
require_once '/home/common/php/mail.php'; // Add email functionality
require_once '/home/common/php/p4Functions.php'; // Add Project 4 base functions

processPageRequest(); // Call the processPageRequest() function


function authenticateUser($username, $password) 
{
	if($username == null || $password == null) {


		echo 'Username or Password are empty!';
		displayLoginForm('Username is wrong!!');
		return;
	}
	 else {


		$resultArray = [];
		$resultArray = validateUser($username , $password);
	
		if($resultArray != null) {
	
			session_start();
			
			$_SESSION["userId"] = $resultArray[0];
			$_SESSION["displayName"] = $resultArray[1];
			$_SESSION["emailAddress"] = $resultArray[2];
	
			return true;
	
		} else {
	
			return false;
		}


	}


}

function displayLoginForm($message = "")
{
	
	require_once './templates/logon_form.html';
}

function processPageRequest()
{

	
	$loginResult = null;
	$username = null;
	$password = null;
	if(session_status() == PHP_SESSION_ACTIVE)
	{
		session_destroy();
	}

	 if (empty($_POST) )	{	 
		
			displayLoginForm();
	}
	 if(isset($_POST["action"])) {


		if($_POST["action"] === "login") {
			
				$username = $_POST['username'];
				$password = $_POST['password'];
				$loginResult = authenticateUser($username,$password);
		

		}
		
			
			if($loginResult) {	//if authenticateUser is true redirect user
				
				header("Location: index.php");
			} 
			else {
	
				$errorMsg = "Wrong account credentials. Try again!";
				displayLoginForm($errorMsg);
			}

		

		

	 }

}

?>
