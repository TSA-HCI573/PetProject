<?php
/*Secured user only page*/
require_once '../includes/constant/config.inc.php';
secure_page();
session_start();
return_meta();


$msg = NULL;

if(isset($_POST['update']))
{
//update for users table
$update = "UPDATE ".USERS." SET firstname = '".filter($_POST['firstname']).
"', lastname = '".filter($_POST['lastname']).
"', username = '".filter($_POST['username']).
"', email = AES_ENCRYPT('".filter($_POST['email'])."', '$salt') ".
", address1 = '".filter($_POST['address1']).
"', address2 = '".filter($_POST['address2']).
"', city = '".filter($_POST['city']).
"', state = '".filter($_POST['state']).
"', zipcode = '".filter($_POST['zip']).
"', bio = '".filter($_POST['bio'])."'".
" WHERE id = ".$_SESSION['UserId'];

//update/insert for userrole table
$userRoleUpdate = "REPLACE INTO ".USER_ROLE." (UserId, UserType) VALUES(".$_SESSION['UserId'].
", '".filter($_POST['usertype'])."')";

$run_update = mysql_query($update) or die(mysql_error());

$run_user_role_update = mysql_query($userRoleUpdate) or die(mysql_error());

if($run_update && $run_user_role_update)
{
    $msg = "Profile updated successfully!";

    if( filter($_POST['usertype']) == "Volunteer")
    {
        header("Location: " . SITE_BASE . "/users/volunteers.php");
    }
    else if (filter($_POST['usertype']) == "Client")
    {
        header("Location: " . SITE_BASE . "/users/clients.php");
    }
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

<?php require '../includes/constant/nav.inc.php'; ?>
<div id="headerplaced"></div>
<div class="content">
<div class="main">





<?php
if(isset($msg))
{
echo '<div class="success">'.$msg.'</div>';
}

// echo "user_id:  " .$_SESSION['user_id'];


$sql = "SELECT ". USERS. ".*, " . USER_ROLE . ".UserType, AES_DECRYPT(".USERS.".email, '$salt') AS decryptedEmail FROM ".USERS." left join " . USER_ROLE . " on " .
USERS . ".id = ".USER_ROLE . ".userId  WHERE ". USERS. ".Id = ".$_SESSION['UserId'];

$in = mysql_query($sql) or die("Unable to get your info!");

while($r = mysql_fetch_array($in))
{
?>
<h1>My Profile</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="profile_form">
<table cellspacing="5" cellpadding="5" border="0">
<tr>
<td colspan="2"><label>Are you a pet owner needing help or a volunteer wanting to help?</label></td></tr>
<tr>
<td/>
<td>
<select name="usertype" id="usertype" value="<?php echo $r['userrole']; ?>"/>
<option value=""  <?php if($r['UserType'] == "") {echo selected;} ?>></option>
<option value="Volunteer" <? if ($r['UserType'] == 'Volunteer') { echo "selected"; } ?>Volunteer</option>
<option value="Client" <?php if($r['UserType'] == 'Client') {echo selected;}?>>Need Pet Assistance</option>
</select> </td>
</tr>
<tr>
<td>First Name</td>
<td><input type="text" size = "35" name="firstname" value="<?php echo $r['FirstName']; ?>" /></td>
</tr>
   <tr>
<td>Last Name</td>
<td><input type="text" size = "35" name="lastname" value="<?php echo $r['LastName']; ?>" /></td>
</tr>
   <tr>
<td>Username</td>
<td><input type="text" size = "35" name="username" value="<?php echo $r['UserName']; ?>" /></td>
</tr>
<tr>
<td>Email</td>
<td><input type="text" size = "35" name="email" value="<?php echo $r['decryptedEmail']; ?>" /></td>
</tr>
<tr>
<td>Address 1</td>
<td><input type="text" size = "35" name="address1" value="<?php echo $r['Address1']; ?>" /></td>
</tr>
<tr>
<td>Address 2</td>
<td><input type="text" size = "35" name="address2" value="<?php echo $r['Address2']; ?>" /></td>
</tr>
<tr>
<td>City</td>
<td><input type="text" size = "35" name="city" value="<?php echo $r['City']; ?>" /></td>
</tr>
<tr>
<td>State</td>
<td><input type="text" name="state" value="<?php echo $r['State']; ?>" /></td>
</tr>
<tr>
<td>Zip</td>
<td><input type="text" name="zip" value="<?php echo $r['ZipCode']; ?>" /></td>
</tr>

<tr>
<td>About Me</td>
<td><textarea rows="5" cols="35" name="bio"><?php echo $r['Bio']; ?></textarea></td>
<!-- <td><type="text" name="bio" rows="5" maxlength="300" value="<?php echo $r['Bio']; ?>" /></td> -->

</tr>
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
<h3>Keep your information current!</h3>
<p>Please keep your profile information updated to ensure that the most pet-owners in need get connected with the best resources. </p>
</div>
</div>
<div id="footer">
<?php include '../includes/constant/footer.inc.php'; ?>
</div>
</div>
</body>
</html>
