<?php

include_once '../includes/constant/config.inc.php';
session_start();
return_meta();

//Check for post data
if($_POST and $_GET)
{
if ($_GET['cmd'] == 'update'){
echo "POST";
//update pet owner information
$startDate = mysql_real_escape_string($_POST['startDate']);

$petType = mysql_real_escape_string($_POST['petType']);	

$comments = mysql_real_escape_string($_POST['comments']);

//Build insert sql statement

  debug_to_console("INSERT INTO ".REQUESTS."(UserId, BeginDate, PetType, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, AM, PM,
dogwalking, grooming, administermeds, deliverfood, transport, fostercare, other, comments )
VALUES (1, '" . $startDate . "', '" .$petType . "', '" .$monday . "', '" . $tuesday. "', '" . $wednesday . "', '" . $thursday . "', '" . $friday .
"', '" . $saturday . "', '" . $sunday . "', '" . $am . "', '" . $pm . "', '" . $dogwalking. "', '" . $grooming. "', '" . $administermeds. "', '" .
$deliverfood. "', '" . $transportation. "', '" . $fostercare . "', '" .$other. "', '" . $comments."')");

mysql_query("INSERT INTO ".REQUESTS."(UserId, BeginDate, PetType, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, AM, PM,
dogwalking, grooming, administermeds, deliverfood, transport, fostercare, other, comments )
VALUES (1, '" . $startDate . "', '" .$petType . "', '" .$monday . "', '" . $tuesday. "', '" . $wednesday . "', '" . $thursday . "', '" . $friday .
"', '" . $saturday . "', '" . $sunday . "', '" . $am . "', '" . $pm . "', '" . $dogwalking. "', '" . $grooming. "', '" . $administermeds. "', '" .
$deliverfood. "', '" . $transportation. "', '" . $fostercare . "', '" .$other. "', '" . $comments."')") or die(mysql_error());
  // echo insertRequest;

//End this portion of the script
exit();
}
}

function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

?>
<head>
<title>Pet Owner Information</title>
<link rel="stylesheet" type="text/css" media="all" href="includes/styles/styles.css" />
<link rel="stylesheet" href="includes/js/jquery-ui.css">

<script src="includes/js/jquery-1.10.2.js"></script>
<script src="includes/js/jquery-ui-1.10.4.js"></script>
<script>
//Form processing function start
$(function()
{
$(".update").click(function()
{
//create three variables to store the data entered into the form
var startDate = $('#datepicker').val();
var petType = $('#petType').val();
//day / times
var firstname = $('#monday').val();
var lastname = $('#lastname').val();
var wednesday = $('#wednesday').prop('checked') ? 1:0;
var thursday = $('#thursday').prop('checked') ? 1:0;
var friday = $('#friday').prop('checked') ? 1:0;
var saturday = $('#saturday').prop('checked') ? 1:0;
var sunday = $('#sunday').prop('checked') ? 1:0;
var am = $('#am').prop('checked') ? 1:0;
var pm = $('#pm').prop('checked') ? 1:0;
//requested services

var dogwalking = $('#dogwalking').prop('checked') ? 1:0;
var grooming = $('#grooming').prop('checked') ? 1:0;
var administermeds = $('#administermeds').prop('checked') ? 1:0;
var deliverfood = $('#deliverfood').prop('checked') ? 1:0;
var transportation = $('#transport').prop('checked') ? 1:0;
var fostercare = $('#fostercare').prop('checked') ? 1:0;
var other =$("#other").val();
//additional comments
var comments =$("#comments").val();
//Check for empty values
if(!monday && !tuesday && !wednesday && !thursday && !friday && !saturday && !sunday)
{
//here, we change the html content of all divs with class="error" and show them
//there should be only 1 such div but the code would affect multiple if they were present in the page
$('.error').fadeIn(400).show().html('Please select preferred days/times.');
}
else
{
//construct the data string ]
var datastring = "monday=" + monday + "&tuesday=" + tuesday + "&wednesday=" + wednesday + "&thursday=" + thursday + "&friday=" + friday + "&saturday=" + saturday
+ "&sunday=" + sunday + "&am=" + am + "&pm=" + pm + "&dogwalking=" + dogwalking + "&grooming=" + grooming + "&administermeds=" + administermeds
+ "&deliverfood=" + deliverfood + "&transportation=" + transportation + "&fostercare=" + fostercare + "&other=" + other + "&comments=" + comments
+ "&startDate=" + startDate +"&petType=" + petType;
/*
Make the AJAX request. The request is made to $_SERVER['PHP_SELF'], i.e., clients_form.php
The request is handled by checking for $_POST data -- see line 6
After the $_POST data is processed, we use the exit() function because we don't need to actually
show the page as the request is made in the background
*/
$.ajax(
{
type: "POST",
url: "<?php echo $_SERVER['PHP_SELF']; ?>?cmd=add",
data: datastring,
success: function()
{
$('.success').fadeIn(2000).show().html('Pet Assistance Requested. ').fadeOut(6000); //Show, then hide success msg
resetForm('form');
$('.error').fadeOut(2000).hide(); //If showing error, fade out
}
}
);
}
//return false to prevent reloading page
return false;
});
});

//what should happen when we refresh?
//hint: find the element with id #loadmsgs, fade it in, show it, and use the load function to load get_msg.php
function refresh_content(){
}

$(function() {
$( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
});

function resetForm(formid) {
$(':input','#'+formid) .not(':button, :submit, :reset, :hidden') .val('') .removeAttr('checked') .removeAttr('selected');
}
</script>
</head>
<body>
<div id="container">
<div id="headerplaced">
<?php include_once '../includes/constant/nav.inc.php'; ?>
</div>
<div class="content">
<div class="main">

<h1>Request Pet Assistance</h1>
<!--
<p>This is the client/pet-owner <a href="link.htm">content</a> for the public site.</p>
<p>There will be some generic information on how the services work. There will be prominent links to the User home page and Registration.</p>
-->
<?php
// get user info for current logged in user
$get_user_info_by_user = "SELECT * FROM ".USERS." WHERE id = " .$_SESSION['user_id'];

echo $get_user_info_by_user;

$getUserInfo = mysql_query($get_user_info_by_user) or die("Unable to retrieve user information!");

$userInfo = mysql_fetch_row($getUserInfo);

//echo $userInfo;
//echo $userInfo[0];
echo $userInfo[1];
?>
<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="user_update_form">

<form method="post" name="form" id="form">
<table>
<tr><td>Start Date: </td>
<td><input type="text" id="datepicker" name="datepicker" ></td>
</tr>
<tr>
<td><label>Pet Type</label></td>
<td>
<select name="petType" id="petType">
<option VALUE"" selected="selected"></option>
<option name="petType" id="petType"VALUE="Dog"> Dog </option>
<option VALUE="Cat"> Cat </option>
<option VALUE="Bird"> Bird </option>
<option VALUE="Other"> Other </option>
</select> </td>
</tr>
</table><br/>
<table>
<tr>
<td valign="top">
<label for="OtherChk">Other</label></td>
<td width="350" valign="top">
<textarea name="other" id="other" rows="3" style="width:100%" maxlength="200"></textarea>
</td>

</tr>
</table>
<table>
<tr>
<td><label>First Name:</label></td>
<td><input type="text" name="firstname" value="" class="required" value=<?php echo $userInfo[1]; ?>/><td>
</tr>
<tr>
<td><label>Last Name:</label></td>
<td><input type="text" name="lastname" value="" class="required" /><td>
</tr>
<!--
<tr>
<td><label>User Name:</label></td>
<td><input type="text" name="username" value="" class="required" /> <td>
</tr>
--> <tr>
<td><label>Email:</label></td>
<td><input type="text" name="email" value="" class="required email" /><td>
</tr>
<tr>
<td><label>Address 1:</label></td>
<td><input type="text" name="address1" value="" class="required" /><td>
</tr>
<tr>
<td><label>Address 2:</label></td>
<td><input type="text" name="address2" value="" class="required" /><td>
</tr>
<tr>
<td><label>City:</label></td>
<td><input type="text" name="city" value="" class="required" /> <td>
</tr>
<tr>
<td><label>State:</label></td>
<td><input type="text" name="state" value="" class="required" /><td>
</tr>
<tr>
<td><label>Zip:</label></td>
<td><input type="text" name="zipcode" value="" class="required" /><td>
</tr>
<tr>
<td><label>Bio:</label></td>
<td><input type="text" name="bio" value="" class="required" /> <td>
</tr>
<br/>
<table>
<tr>Additional Comments:</tr>
</table>
<tr>
<textarea name="comments" id="comments" rows="5" style="width:73%" maxlength="300"></textarea>
</tr>
</table>
<p><button type="submit" class="submit" value="insert">Request Pet Assistance</button></p>
</form>
<p>
<span class="success" style="display:none;"></span>
<span class="error" style="display:none;">Uh Oh! Something went wrong, we are unable to submit request at this time.</span>
</p>
</div>
<div class="sidebar">
<p>Here is sidebar content such as tips, brag facts, resources and links, upcoming events</p>
</div>
</div>
<div id="footer">
<?php include 'includes/constant/footer.inc.php'; ?>
</div>
</div>
</body>
</html>