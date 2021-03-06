<?php
require 'includes/constant/config.inc.php';

include_once 'includes/swift/lib/swift_required.php';

$meta_title = "Register an account";

$firstname = "";
$lastname = "";
$username = "";
$password = "";
$email = "";

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

    if($password == filter($_POST['password2']))
    {
        $err = add_user($firstname, $lastname, $username, $password, $email);

        //if there are no errors, set $msg to "Registration Successfull" - later on, it is displayed on the page
        if ( count($err) == 0){
            $msg = "Registration successful!";
            $meta_title = "Registration successful!";
        }   
    }
    else
    {
        $error= "Passwords don't match";
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
    if(!empty($error)) 
	{
		echo '<div class="error">';
        echo $error;
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
			<h1>Registration</h1>
			<p class="small">Text in orange with * indicates required field.</p>	
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="register_form">
			<table>
			<tr><td><label class="required">First Name *</label> </td> 
            <td> <input type="text" name="firstname" 
                        value="<?php echo $firstname; ?>" class="required" /></td></tr>
			<tr><td><label class="required">Last Name *</label> </td>
            <td><input type="text" name="lastname" 
                        value="<?php echo $lastname; ?>" class="required" /></td></tr>
			<tr><td><label class="required">User Name *</label> </td> 
            <td><input type="text" name="username" 
                value="<?php echo $username; ?>" class="required" /></td></tr>
            <tr><td><label class="required">Password *</label> </td><td> <input type="password" 
                name="password" value="" class="required" /></td></tr>
            <tr><td><label class="required">Password Again *</label></td><td><input type="password" 
                name="password2" class="required" /></td></tr>
            <tr><td><label class="required">Email *</label></td><td><input type="text" name="email" 
                    value="<?php echo $email; ?>" class="required email" /></td></tr>

			<tr>
			<td colspan="2" align="right">
				<input id="registerButton" type="submit" name="add" value="Register!" />
			</td>
			</tr>
			</table>
			</form>
			
				
		<?php 
			//finally, we enter PHP mode again to close the curly bracket that is after 'else' 
		}
		?>
</div>
<div class="sidebar">
         <h3>Next Step: Create your profile</h3>
        <p>After you register, there will be a link to login. There you will add more details about who you are and you'll indicate if you're a pet owner looking for help or a volunteer.</p>                      
        </div>
</div>
<div id="footer">
    <?php include 'includes/constant/footer.inc.php'; ?>
    </div>
</div>
</body>
</html>
