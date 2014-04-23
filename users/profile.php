<?php
/*Secured user only page*/
require_once '../includes/constant/config.inc.php';
secure_page();
<<<<<<< Updated upstream
session_start();
return_meta();


<<<<<<< HEAD
=======
return_meta("Edit your profile " .$_SESSION['fullname'] . "!");
=======
return_meta("Edit your profile " .$_SESSION['FirstName'] . "!");
>>>>>>> Stashed changes
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> FETCH_HEAD
=======
>>>>>>> FETCH_HEAD
=======
>>>>>>> FETCH_HEAD
$msg = NULL;

if(isset($_POST['update']))
{
$update = "UPDATE ".USERS." SET full_name = '".filter($_POST['fullname'])."', user_name = '".filter($_POST['username'])."', usr_email = AES_ENCRYPT('".filter($_POST['email'])."', '$salt')";

if(!empty($_POST['newpass']))
{
$update .= ", usr_pwd = '".hash_pass(filter($_POST['newpass']))."'";
}

$update .= " WHERE id = '".$_SESSION['user_id']."'";

$run_update = mysql_query($update) or die(mysql_error());

if($run_update)
{
$msg = "Profile updated successfully!";
}

}
?>
<head>
<title>Edit Your Information</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/styles/styles.css" />
<script>
</script>
</head>

<body>
<div id="container">

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<?php require '../includes/constant/nav.inc.php'; ?>
<div id="headerplaced"></div>
<div class="content">
<div class="main">

<h1>Update Your Information</h1>

<h2><?php echo $_SESSION['FirstName']; ?>!  Making sure your profile information is updated ensures that the most pet-owners in need get connected with the best resources. Make sure to keep your profile up-to-date at all times!</h2>

<!-- 
<p>Form that:</p>
=======
=======
>>>>>>> FETCH_HEAD
=======
>>>>>>> FETCH_HEAD
	<?php require '../includes/constant/nav.inc.php'; ?>
	
	<h1>Keep your information updated!</h1>

	<h2><?php echo $_SESSION['FirstName']; ?>!  Making sure your profile information is updated ensures that the most pet-owners in need get connected with the best resources. Make sure to keep your profile up-to-date at all times!</h2>
	
	<p>Form that:</p>
>>>>>>> FETCH_HEAD
<ul><li>Displays users' information </li>
<li>Allows users to update the information</li>
<li>Updates the database when they submit</li>
</ul>
<<<<<<< HEAD
 -->



<?php
if(isset($msg))
{
echo '<div class="success">'.$msg.'</div>';
}

// echo "user_id:  " .$_SESSION['user_id'];


$sql = "SELECT *, AES_DECRYPT(email, '$salt') AS decryptedEmail FROM ".USERS." WHERE Id = ".$_SESSION['user_id'];

$in = mysql_query($sql) or die("Unable to get your info!");

while($r = mysql_fetch_array($in))
{
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="profile_form">
<table cellspacing="5" cellpadding="5" border="0">
<tr>
<td>First Name</td>
<td><input type="text" name="FirstName" value="<?php echo $r['FirstName']; ?>" /></td>
</tr>
   <tr>
<td>Last Name</td>
<td><input type="text" name="LastName" value="<?php echo $r['LastName']; ?>" /></td>
</tr>
   <tr>
<td>Username</td>
<td><input type="text" name="UserName" value="<?php echo $r['UserName']; ?>" /></td>
</tr>
<tr>
<td>Address 1</td>
<td><input type="text" name="address1" value="<?php echo $r['Address1']; ?>" /></td>
</tr>
<tr>
<td>Address 2</td>
<td><input type="text" name="address2" value="<?php echo $r['Address2']; ?>" /></td>
</tr>
<tr>
<td>City</td>
<td><input type="text" name="City" value="<?php echo $r['City']; ?>" /></td>
</tr>
<tr>
<td>State</td>
<td><input type="text" name="State" value="<?php echo $r['State']; ?>" /></td>
</tr>
<tr>
<td>Zip</td>
<td><input type="text" name="Zip" value="<?php echo $r['ZipCode']; ?>" /></td>
</tr>
<tr>
<td>Email</td>
<td><input type="text" name="Email" value="<?php echo $r['decryptedEmail']; ?>" /></td>
</tr>
<tr>
<td>About Me</td>
<td>
<textarea name="bio" id="bio" value="<?php echo $r['Bio']; ?>" rows="5" style="width:73%" maxlength="300"></textarea>
</td>
</tr>
<tr>
<td>New Password</td>
<td><input type="text" name="newpass" /></td>
</tr>
<tr>
<td>Login Information:</td>
<td>Last login: <?php echo $r['last_login']; ?>, total number of logins: <?php echo $r['num_logins']; ?></td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" name="update" value="Update Profile" />
</td>
</tr>
</table>
</form>

<?php
}
?>
</div>
<div class="sidebar">
<p>Here is sidebar content such as tips, brag facts, resources and links, upcoming events</p>
</div>
</div>
<div id="footer">
<?php include 'includes/constant/footer.inc.php'; ?>
</div>
=======
	


	<?php
	if(isset($msg))
	{
		echo '<div class="success">'.$msg.'</div>';
	}
<<<<<<< Updated upstream
	echo "user_id:  " .$_SESSION['user_id'];
	$in = mysql_query("SELECT *, AES_DECRYPT(usr_email, '$salt') AS email FROM ".USERS." WHERE id = '".$_SESSION['user_id']."'") or die("Unable to get your info!");
=======
    $sql = "SELECT * FROM ".USERS." WHERE Id = ".$_SESSION['UserId'];
	$in = mysql_query($sql) or die("Unable to get your info!");
>>>>>>> Stashed changes
	while($r = mysql_fetch_array($in))
	{
	?>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="profile_form">
	<table cellspacing="5" cellpadding="5" border="0">
	<tr>
	<td>First Name</td>
	<td><input type="text" name="FirstName" value="<?php echo $r['FirstName']; ?>" /></td>
	</tr>
    <tr>
	<td>Last Name</td>
	<td><input type="text" name="LastName" value="<?php echo $r['LastName']; ?>" /></td>
	</tr>
    <tr>
	<td>Username</td>
	<td><input type="text" name="UserName" value="<?php echo $r['UserName']; ?>" /></td>
	</tr>
	<tr>
	<td>Email</td>
	<td><input type="text" name="Email" value="<?php echo $r['Email']; ?>" /></td>
	</tr>
	<tr>
	<td>New Password</td>
	<td><input type="text" name="newpass" /></td>
	</tr>
	<tr>
	<td>Login Information:</td>
	<td>Last login: <?php echo $r['last_login']; ?>, total number of logins: <?php echo $r['num_logins']; ?></td>
	</tr>
	<tr>
	<td colspan="2" align="center">
		<input type="submit" name="update" value="Update Profile" />
	</td>
	</tr>
	</table>
	</form>

	<?php
	}
	?>
>>>>>>> FETCH_HEAD
</div>
</body>
</html>
