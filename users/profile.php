<?php
/*Secured user only page*/
require_once '../includes/constant/config.inc.php';
secure_page();
session_start();
return_meta();


$msg = NULL;

if(isset($_POST['update']))
{
$update = "UPDATE ".USERS." SET firstname = '".filter($_POST['firstname']).
"', lastname = '".filter($_POST['lastname']).
"', username = '".filter($_POST['username']).
"', usertype = '".filter($_POST['usertype']).
"', email = AES_ENCRYPT('".filter($_POST['email'])."', '$salt') ".
", address1 = '".filter($_POST['address1']).
"', address2 = '".filter($_POST['address2']).
"', city = '".filter($_POST['city']).
"', state = '".filter($_POST['state']).
"', zipcode = '".filter($_POST['zip']).
"', bio = '".filter($_POST['bio'])."'";


// if(!empty($_POST['newpass']))
// {
// $update .= ", usr_pwd = '".hash_pass(filter($_POST['newpass']))."'";
// }

$update .= " WHERE id = ".$_SESSION['UserId'];
//echo $update;
$run_update = mysql_query($update) or die(mysql_error());
//echo $run_update;
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

<?php require '../includes/constant/nav.inc.php'; ?>
<div id="headerplaced"></div>
<div class="content">
<div class="main">


<h2>  
<!-- <?php echo $_SESSION['FirstName']; ?>!  -->
Please keep your profile information updated to ensure that the most pet-owners in need get connected with the best resources. </h2>


<?php
if(isset($msg))
{
echo '<div class="success">'.$msg.'</div>';
}

// echo "user_id:  " .$_SESSION['user_id'];


$sql = "SELECT *, AES_DECRYPT(email, '$salt') AS decryptedEmail FROM ".USERS." WHERE Id = ".$_SESSION['UserId'];

$in = mysql_query($sql) or die("Unable to get your info!");

while($r = mysql_fetch_array($in))
{

// 	if ($r['UserType'] == '1'){
// 		echo "Volunteer";}
// 	elseif  ($r['UserType'] == '2'){
// 		echo "Client";}
// 	else{
// 		echo $r['UserType'];}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="profile_form">
<table cellspacing="5" cellpadding="5" border="0">
<tr>
<td>First Name</td>
<td><input type="text" name="firstname" value="<?php echo $r['FirstName']; ?>" /></td>
</tr>
   <tr>
<td>Last Name</td>
<td><input type="text" name="lastname" value="<?php echo $r['LastName']; ?>" /></td>
</tr>
   <tr>
<td>Username</td>
<td><input type="text" name="username" value="<?php echo $r['UserName']; ?>" /></td>
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
<td><input type="text" name="city" value="<?php echo $r['City']; ?>" /></td>
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
<td>Email</td>
<td><input type="text" name="email" value="<?php echo $r['decryptedEmail']; ?>" /></td>
</tr>
<tr>
<td>About Me</td>
<td><input type="text" name="bio" rows="5" maxlength="300" value="<?php echo $r['Bio']; ?>" /></td>

</tr>
<tr>
<td><label>User Type</label></td>
<td>
<select name="usertype" id="usertype" value="<?php echo $r['userrole']; ?>"/>
<option value=""  <?php if($r['UserType'] == "") {echo selected;} ?>></option>
<option value="1" <? if ($r['UserType'] == 1) { echo "selected"; } ?>>Volunteer</option>
<option value="2" <?php if($r['UserType'] == 2) {echo selected;}?>>Need Pet Assistance</option>
<!-- 

<option VALUE="1"> Volunteer </option>
<option VALUE="2"> Needing Pet Assistance </option>
 -->
</select> </td>
</tr>
<!-- 
<tr>
<td>New Password</td>
<td><input type="text" name="newpass" /></td>
</tr>
 -->

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
<?php include '../includes/constant/footer.inc.php'; ?>
</div>
</div>
</body>
</html>
