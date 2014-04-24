<?php

include_once '../includes/constant/config.inc.php';
//session_start();
//return_meta();
secure_page();

//Check for post data
if($_POST and $_GET)
{
if ($_GET['cmd'] == 'add'){
echo "POST";
//Assign variables and sanitize POST data
$startDate = mysql_real_escape_string($_POST['startDate']);

$petType = mysql_real_escape_string($_POST['petType']);	

$dogwalking = mysql_real_escape_string($_POST['dogwalking']);
$grooming = mysql_real_escape_string($_POST['grooming']);
$administermeds = mysql_real_escape_string($_POST['administermeds']);
$deliverfood = mysql_real_escape_string($_POST['deliverfood']);
$transportation = mysql_real_escape_string($_POST['transportation']);
$fostercare = mysql_real_escape_string($_POST['fostercare']);
$other = mysql_real_escape_string($_POST['other']);
$comments = mysql_real_escape_string($_POST['comments']);

//Build insert sql statement

mysql_query("INSERT INTO ".VOLUNTEERS."(UserId, BeginDate, PetType,dogwalking, grooming, administermeds, deliverfood, transport, fostercare, other, comments )
VALUES (1, '" . $startDate . "', '" .$petType . "', '" . $dogwalking. "', '" . $grooming. "', '" . $administermeds. "', '" .
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
<link rel="stylesheet" type="text/css" media="all" href="../includes/styles/styles.css" />
<link rel="stylesheet" href="../includes/js/jquery-ui.css">
<link rel="stylesheet" href="../includes/styles/volunteer.css">

<script src="<?php echo JS?>/jquery-1.10.2.js"></script>
<script src="<?php echo JS?>/jquery-ui-1.10.4.js"></script>
<script src="<?php echo JS?>/jquery.approach.min.js"></script>
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
    var datastring = "&dogwalking=" + dogwalking + "&grooming=" + grooming + "&administermeds=" + administermeds
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
<?php include "volunteerJS.php"?>

</head>
<body>
<div id="container">
<div id="headerplaced">
<?php include_once '../includes/constant/nav.inc.php'; ?>
</div>
<div class="content">
<div class="main">

<h1>Volunteer</h1>
<table id='scheduleTable'>
</table>

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
</div>
<div id="footer">
<?php include 'includes/constant/footer.inc.php'; ?>
</div>
</div>
</body>
</html>
