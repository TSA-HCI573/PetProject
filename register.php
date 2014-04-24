<?php
require 'includes/constant/config.inc.php';

include_once 'includes/swift/lib/swift_required.php';

$meta_title = "Register an account";

$firstname = NULL;
$lastname = NULL;
$username = NULL;
$password = NULL;
$email = NULL;


$msg = NULL;
$err = array();

if(isset($_POST['add']))
{
	//filter is defined config.inc.php
	$firstname = filter($_POST['firstname']);
	$lastname = filter($_POST['lastname']);
	$username = filter($_POST['username']);
	$password = filter($_POST['password']);
	$email = filter($_POST['email']);

	
//echo $firstname . " " . $lastname. " " .  $username. " " .  $password. " " .  $email . " " .  $address1. " " .  $address2. " " .  $city. " " .  $state. " " .  $zipcode. " " .  $bio. " " .  $profileImagePath;
	//define in config.inc.php
	$err = add_user($firstname, $lastname, $username, $password, $email);

	//if there are no errors, set $msg to "Registration Successfull" - later on, it is displayed on the page
	if ( count($err) == 0){
		$msg = "Registration successful!";
		$meta_title = "Registration successful!";
	}
	
	
}


return_meta($meta_title);
?>
<html>
<head>
<title>Edit Your Information</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/styles/styles.css" />
<script>
</script>
</head>

<!-- 
<head>
<script>
</script>
</head>
 -->
<body>
<div id="container">

	<?php include 'includes/constant/nav.inc.php'; ?>
	<div id="headerplaced"></div>
	<div class="content">
	<div class="main">
	<?php
	//Show message if isset
	if(isset($msg))
	{
		echo '<div class="success">'.$msg.'</div>';
	}
	//Show error message if isset
	if(!empty($err)) 
	{
		echo '<div class="err">';
		foreach($err as $e)
		{
			echo $e.'<br />';
		}
		echo '</div>';
	}
	?>

	<!-- If the user just registered, we will not display the form. Instead, we offer them a link to log in -->
	<?php //enter PHP mode and start an if-statement
		if (isset($msg)) { ?> 
			<!-- we're now back in HTML mode but the HTML code will only appear if the condition in the if-statement was true -->
			<p>You may now <a href = "login.php">log in</a>!</p>
		
		
		<?php //now we enter PHP mode again to close the curly bracket and add the 'else'
		} 
		else { //if isset($msg) returns false, then we are here -- now we just show the form as before
		?>
			<!-- back in HTML mode -->
			
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="register_form">

			<table cellspacing="5" cellpadding="5" border="0">
			<tr><td>First Name </td> 
			<td> <input type="text" name="firstname" value="" class="required" /></td></tr>
			<tr><td>Last Name </td>
			<td><input type="text" name="lastname" value="" class="required" /></td></tr>
			<tr><td>User Name </td> 
			<td><input type="text" name="username" value="" class="required" /></td></tr>
			<tr><td>Password </td><td> <input type="password" name="password" value="" class="required" /></td></tr>
			<tr><td>Email</td><td><input type="text" name="email" value="" class="required email" /></td></tr>

			<tr>
			<td colspan="2" align="right">
				<input type="submit" name="add" value="Register!" />
			</td>
			</tr>
			</table>
			</form>
			
			
<p>Above is the registration form from HW4 (not completed). Will our users register separately from filling out the volunteer or client form? If so, how will they get to the appropriate forms? If not, how do do they choose volunteer or client, fill out the proper form area, and become registered as a client or a volunteer?</p>
			
			
		<?php 
			//finally, we enter PHP mode again to close the curly bracket that is after 'else' 
		}
		?>
</div>
</div>
</div>
</body>
</html>