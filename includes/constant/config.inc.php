<?php

ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);
error_reporting(E_ERROR);

define ("DB_HOST", "localhost"); // set database host
define ("DB_USER", "hci573"); // set database user
define ("DB_PASS","hci573"); // set database password
define ("DB_NAME","petproject"); // set database name

//tables
define ("USERS", "Users");
define ("USER_ROLE", "UserRole");
define ("USER_PETS", "UserPets");
define ("MATCHUPS", "MatchUps");
define ("REQUESTS", "Requests");


//site base
define ("SITE_BASE", "http://".$_SERVER['HTTP_HOST']."/PetProject");
define ("SITE_ROOT", $_SERVER['DOCUMENT_ROOT']."/PetProject");
define ("JS", SITE_BASE ."/includes/js");

//email to use for verification
//define ("GLOBAL_EMAIL", "notused@gmail.com");
define ("REQUIRE_ACTIVIATION",false); //keep this as false

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");// 
// echo DB_HOST . " " . DB_USER . " " . DB_PASS;

$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

//our keys -- ideally, those would be stored on a separate machine or server
$salt = "ae4bca65f3283fe26a6d3b10b85c3a308";
global $salt;

$passsalt = "f576c07dbe00e8f07d463bc14dede9e492";
global $passsalt;

$password_store_key = sha1("dsf4dgfd5s2");
global $password_store_key;



/* Function that adds a new user to our system */
function add_user($firstname, $lastname, $username, $password, $email, $address1, $address2, $city,
    $state, $zipcode, $bio, $profileImagePath )
{
	
	//declaring $salt and $link as global allows the function to access the values stored in these variables
	global $salt;
	global $link;
	global $password_store_key;
	
	$err = array();
	
	//here we validate that the user submited all fields
	if(empty($firstname) || strlen($firstname) < 4)
	{
		$err[] = "You must enter your first name";
	}
	
	if(empty($lastname) || strlen($lastname) < 4)
	{
		$err[] = "You must enter your last name";
	}
	
	
	if(empty($username) || strlen($username) < 4)
	{
		$err[] = "You must enter a username";
	}
	
	if(empty($password) || strlen($password) < 4)
	{
		$err[] = "You must enter a password";
	}
	
	if(empty($email) || !check_email($email))
	{
		$err[] = "Please enter a valid email address.";
	}
	
	

	$q = mysql_query("SELECT username, email FROM ".USERS." WHERE username = '$username' OR email = AES_ENCRYPT('$email', '$salt')");
	if(mysql_num_rows($q) > 0)
	{
		$err[] = "User already exists";
	}

	if(empty($err))
	{
		//the function hash_pass is defined in config.inc.php
		$password = hash_pass($password);
		
        $q1 = mysql_query("INSERT INTO ".USERS." (FirstName, LastName, Email, Password, UserName,
            Address1, Address2, City, State, ZipCode, Bio, ProfileImagePath) 
            VALUES ('$firstname',  '$lastname', AES_ENCRYPT('$email', '$salt'), '$password', '$username',
                '$address1', '$address2', '$city',  '$state', '$zipcode', '$bio', 
                '$profileImagePath')", $link) or die("Unable to insert data".mysql_error($link));


		
		//Generate rough hash based on user id from above insertion statement
		$user_id = mysql_insert_id($link); //get the id of the last inserted item
		$md5_id = md5($user_id);
		mysql_query("UPDATE ".USERS." SET md5_id='$md5_id' WHERE id='$user_id'");

	// 	if (REQUIRE_ACTIVIATION){
// 		
// 			//set the approve flag to 0
// 			$rs_activ = mysql_query("UPDATE ".USERS." SET approved='0' WHERE
// 				md5_id='". $md5_id. "' AND activation_code = '" . $activation_code ."' ") or die(mysql_error());
// 		
// 			//send an email with the activation key
// 			
// 			//first, retrieve my encrypted password
// 			$key = $password_store_key;
// 			$result = mysql_query("SELECT * , AES_DECRYPT(password, '$key') AS password FROM ". PSTORE_TABLE ." WHERE username=AES_ENCRYPT('".GLOBAL_EMAIL."', '$key')") or die(mysql_error());
// 			$row = mysql_fetch_assoc($result);
// 			$pw = $row['password'];
// 			
// 			//generate the message
// 			$message = "Hi ".$fullname."!\n
// 				Thank you for registering with us. Here are your login details...
// 
// 				User ID: ".$username."\n
// 				Email: ".$email."\n
// 				Password: ".$_POST['password']."\n\n
// 
// 				You must activate your account before you can actually do anything:\n
// 				".SITE_BASE."/users/activate.php?user=".$md5_id."&activ_code=".$activation_code."\n\n\n
// 
// 				Thank You,\n
// 
// 				Administrator\n
// 				".SITE_BASE."";
// 			
// 			
// 			//next, we use swift's email function
// 			$email_to = $email; $email_from=GLOBAL_EMAIL;$password = $pw; $subj = "Registration successful!";
// 			$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
// 			  ->setUsername($email_to)
// 			  ->setPassword($password);
// 
// 			$mailer = Swift_Mailer::newInstance($transport);
// 
// 			$message = Swift_Message::newInstance($subj)
// 			  ->setFrom(array($email_from => 'Jivko Sinapov'))
// 			  ->setTo(array($email_to))
// 			  ->setBody($message);
// 
// 			$result = $mailer->send($message);
// 	
// 		}
// 		else {
// 			//activate user by default
// 			// set the approved field to 1 to activate the account
// 			$rs_activ = mysql_query("UPDATE ".USERS." SET approved='1' WHERE
// 				md5_id='". $md5_id. "' AND activation_code = '" . $activation_code ."' ") or die(mysql_error());
// 		}
	}

	
	
	
	return $err;
}


/*Function to secure pages and check users*/
function secure_page()
{
	session_start();
	global $db;

	//Secure against Session Hijacking by checking user agent
	if(isset($_SESSION['HTTP_USER_AGENT']))
	{
		//Make sure values match!
		if($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']) or $_SESSION['logged'] != true)
		{
			logout();
			exit;
		}

		//We can only check the DB IF the session has specified a user id
		if(isset($_SESSION['user_id']))
		{
			$details = mysql_query("SELECT ckey, ctime FROM ".USERS." WHERE id ='".$_SESSION['user_id']."'") or die(mysql_error());
			list($ckey, $ctime) = mysql_fetch_row($details);

			//We know that we've declared the variables below, so if they aren't set, or don't match the DB values, force exit
			if(!isset($_SESSION['stamp']) && $_SESSION['stamp'] != $ctime || !isset($_SESSION['key']) && $_SESSION['key'] != $ckey)
			{
				logout();
				exit;
			}
		}
	}
	//if we get to this, then the $_SESSION['HTTP_USER_AGENT'] was not set and the user cannot be validated
	else
	{
		logout();
		exit;
	}
}

/*Function to logout users securely*/
function logout($lm = NULL)
{
	if(!isset($_SESSION))
	{
		session_start();
	}

	//If the user is 'partially' set for some reason, we'll want to unset the db session vars
	if(isset($_SESSION['user_id']))
	{
		global $db;
		mysql_query("UPDATE ".USERS." SET ckey= '', ctime= '' WHERE id='".$_SESSION['user_id']."'") or die(mysql_error());
		unset($_SESSION['user_id']);
	}
		
	unset($_SESSION['user_name']);
	unset($_SESSION['user_level']);
	unset($_SESSION['HTTP_USER_AGENT']);
	unset($_SESSION['stamp']);
	unset($_SESSION['key']);
	unset($_SESSION['fullname']);
	unset($_SESSION['logged']);
	session_unset();
	session_destroy();

	if(isset($lm))
	{
		header("Location: ".SITE_BASE."/login.php?msg=".$lm);
	}
	else
	{
		header("Location: ".SITE_BASE."/login.php");
	}
}

/* using the session data, this function checks if the person logged in has admin rights */
function is_admin()
{
	if(isset($_SESSION['user_level']) && $_SESSION['user_level'] >= 5)
	{
		return 1;
	}
	else
	{
		return 0 ;
	}
}

/*Function to generate key for login.php*/
function generate_key($length = 7)
{
	$password = "";
	$possible = "0123456789abcdefghijkmnopqrstuvwxyz";

	$i = 0;
	while ($i < $length)
	{
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		if (!strstr($password, $char))
		{
			$password .= $char;
			$i++;
		}
	}
	return $password;
}

/*Function to super sanitize anything going near our DBs*/
function filter($data)
{
	$data = trim(htmlentities(strip_tags($data)));

	if (get_magic_quotes_gpc())
	{
		$data = stripslashes($data);
	}

	$data = mysql_real_escape_string($data);
	return $data;
}

/*Function to easily output all our css, js, etc...*/
function return_meta($title = NULL, $keywords = NULL, $description = NULL)  // I want the page title, keywords, and description to be based on the page -- only if they are empty do I want to put this other stuff in there -- it's overriding the hard-coded page title right now.
{
	if(is_null($title))
	{
		$title = "Pet Project";
	}

	$meta = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>'.$title.'</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="'.$keywords.'" />
	<meta name="description" content="'.$description.'" />
	<meta name="language" content="en-us" />
	<meta name="robots" content="index,follow" />
	<meta name="googlebot" content="index,follow" />
	<meta name="msnbot" content="index,follow" />
	<meta name="revisit-after" content="7 Days" />
	<meta name="url" content="'.SITE_BASE.'" />
	<meta name="copyright" content="Copyright '.date("Y").' Your site name here. All rights reserved." />
	<meta name="author" content="Your site name here" />
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
	<link rel="stylesheet" type="text/css" media="all" href="'.SITE_BASE.'/includes/styles/styles.css" />
	
	';

	echo $meta;
}

/*Function to validate email addresses*/
function check_email($email)
{
	return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}




/*Function to update user details*/
function hash_pass($pass)
{
	global $passsalt;
	$hashed = md5(sha1($pass));
	$hashed = crypt($hashed, $passsalt);
	$hashed = sha1(md5($hashed));
	return $hashed;
}
<<<<<<< HEAD
=======

//function which returns all stored entries wrapped up in HTML code
function load_messages()
{
    //here, the variable $build holds the HTML content that is generated by the function
	$build = '';
	
	
	//setup our query and execute it
	$query = "SELECT * FROM ".THE_TABLE." ORDER BY ci_id DESC";
    $msgq = mysql_query($query) or die(mysql_error());
    
	
	if(mysql_num_rows($msgq) == 0)
    {
       
		//the .= operator adds on to the current value of $build
		$build .= "<p><b>No data found.  Add some data using the form above</b></p>";
    }
    else
    {
        while($row = mysql_fetch_array($msgq))
        {
            $build .= "<div >";
 
            $build .= "<p><b>The Client:</b> ".$row['ci_ci']."<br />";
 
            $build .= "<b>The Quarter:</b> ". $row['ci_qt'] . "<br />";
 
            $build .= "<b>The Amount:</b> $" . $row['ci_amt'] . "<br />";
   
            $build .= "</div>";
        }
    }
    return $build;
}
>>>>>>> ad983e2168d9b39b506faca032c30a4c1092dba5
