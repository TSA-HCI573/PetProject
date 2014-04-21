<?php

include_once '../includes/constant/config.inc.php';
session_start();
return_meta();

//Check for post data
if($_POST and $_GET)
{
if ($_GET['cmd'] == 'add'){
echo "POST";
//Assign variables and sanitize POST data
$startDate = mysql_real_escape_string($_POST['startDate']);

$petType = mysql_real_escape_string($_POST['petType']);	

$monday = mysql_real_escape_string($_POST['monday']);
$tuesday = mysql_real_escape_string($_POST['tuesday']);
$wednesday = mysql_real_escape_string($_POST['wednesday']);
$thursday = mysql_real_escape_string($_POST['thursday']);
$friday = mysql_real_escape_string($_POST['friday']);
$saturday = mysql_real_escape_string($_POST['saturday']);
$sunday = mysql_real_escape_string($_POST['sunday']);
$am = mysql_real_escape_string($_POST['am']);
$pm = mysql_real_escape_string($_POST['pm']);


$dogwalking = mysql_real_escape_string($_POST['dogwalking']);
$grooming = mysql_real_escape_string($_POST['grooming']);
$administermeds = mysql_real_escape_string($_POST['administermeds']);
$deliverfood = mysql_real_escape_string($_POST['deliverfood']);
$transportation = mysql_real_escape_string($_POST['transportation']);
$fostercare = mysql_real_escape_string($_POST['fostercare']);
$other = mysql_real_escape_string($_POST['other']);
$comments = mysql_real_escape_string($_POST['comments']);

//Build insert sql statement

  debug_to_console("INSERT INTO ".VOLUNTEERS."(UserId, BeginDate, PetType, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, AM, PM,
dogwalking, grooming, administermeds, deliverfood, transport, fostercare, other, comments )
VALUES (1, '" . $startDate . "', '" .$petType . "', '" .$monday . "', '" . $tuesday. "', '" . $wednesday . "', '" . $thursday . "', '" . $friday .
"', '" . $saturday . "', '" . $sunday . "', '" . $am . "', '" . $pm . "', '" . $dogwalking. "', '" . $grooming. "', '" . $administermeds. "', '" .
$deliverfood. "', '" . $transportation. "', '" . $fostercare . "', '" .$other. "', '" . $comments."')");

mysql_query("INSERT INTO ".VOLUNTEERS."(UserId, BeginDate, PetType, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, AM, PM,
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
<title>Pet Owners Seeking Assistance</title>
<link rel="stylesheet" type="text/css" media="all" href="includes/styles/styles.css" />
<link rel="stylesheet" href="includes/js/jquery-ui.css">

<script src="includes/js/jquery-1.10.2.js"></script>
<script src="includes/js/jquery-ui-1.10.4.js"></script>
<script>
//Form processing function start
$(function()
{
$(".submit").click(function()
{
//create three variables to store the data entered into the form
var startDate = $('#datepicker').val();
var petType = $('#petType').val();
//day / times
var monday = $('#monday').prop('checked') ? 1:0;
var tuesday = $('#tuesday').prop('checked') ? 1:0;
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

<h1>Volunteer</h1>

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
<tr><label>I'd like assistance on the following days:</label></tr>
<tr>
<td><input type="checkbox" id="monday" name="monday"">
<label for="monday">Monday</label>
</td>
<td><input type="checkbox" id="tuesday" name="tuesday">
<label for="tuesday">Tuesday</label></td>
<td><input type="checkbox" id="wednesday" name="wednesday">
<label for="wednesday">Wednesday</label></td>
<td><input type="checkbox" id="thursday" name="thursday">
<label for="thursday">Thursday</label></td>
<td><input type="checkbox" id="friday" name="friday">
<label for="friday">Friday</label></td>
</tr>
<tr>
<td><input type="checkbox" id="saturday" name="saturday">
<label for="saturday">Saturday</label></td>
<td><input type="checkbox" id="sunday" name="sunday">
<label for="sunday">Sunday</label></td></tr>
</table><br/>
<table>
<tr><label>My preferred time of day is:</label></tr>
<tr>
<td><input type="checkbox" id="am" name="am">
<label for="am">AM</label></td>
<td><input type="checkbox" id="pm" name="pm">
<label for="pm">PM</label></td></tr>
</table><br/>
<table>
<tr>Requested Services</tr>
<tr>
<td><input type="checkbox" id="dogwalking" name="dogwalking" value="True">
<label for="dogwalking">Dog Walking</label>
</td>
<td><input type="checkbox" id="grooming" name="grooming" value="True">
<label for="grooming">Grooming</label></td>
<td><input type="checkbox" id="administermeds" name="administermeds" value="True">
<label for="administermeds">Administer Meds</label></td>
</tr>
<tr>
<td><input type="checkbox" id="transport" name="transport" value="True">
<label for="transport">Transportation</label></td>
<td ><input type="checkbox" id="deliverfood" name="deliverfood" value="True">
<label for="deliverfood">Deliver Food</label></td>
<td><input type="checkbox" id="fostercare" name="fostercare" value="True">
<label for="fostercare">Foster Care</label></td>
</tr>
</table>
<table>
<tr>
<td valign="top">
<label for="OtherChk">Other</label></td>
<td width="350" valign="top">
<textarea name="other" id="other" rows="3" style="width:100%" maxlength="200"></textarea>
</td>

</tr>
</table><br/>
<table>
<tr>Additional Comments:</tr>
</table>
<tr>
<textarea name="comments" id="comments" rows="5" style="width:73%" maxlength="300"></textarea>
</tr>
</table>
<p><button type="submit" class="submit" value="insert">Volunteer</button></p>
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