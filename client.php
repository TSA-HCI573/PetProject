<?php

include 'includes/constant/config.inc.php';
session_start();
return_meta();

//Check for post data
if($_POST and $_GET)
{
	if ($_GET['cmd'] == 'submitPetAssist'){
	
		//Assign variables and sanitize POST data
		$monday = mysql_real_escape_string($_POST['monday']);
		$tuesday = mysql_real_escape_string($_POST['tuesday']);
		//echo $monday . " " . $ tuesday;
	 	echo "Hello";
		//Build our query statement
// 		var insertRequest = "INSERT INTO ".REQUEST." (UserId, Monday, Tuesday) VALUES (1, '" . $monday . "', '" .$tuesday . "'";
		mysql_query("INSERT INTO ".REQUEST." (UserId, Monday, Tuesday) VALUES (1, '" . $monday . "', '" .$tuesday . "'") or die(mysql_error());
// 		 echo insertRequest;
	 
		//End this portion of the script
		exit();
	}

}

?>
<head>
<title>Pet Owners Seeking Assistance</title>
<link rel="stylesheet" type="text/css" media="all" href="includes/styles/styles.css" />

<script src="includes/js/jquery-1.10.2.js"></script>
<script>
//Form processing function start
$(function()
{
	$(".submit").click(function()
    {
        
		//create three variables to store the data entered into the form
		boolean monday = $("#Monday").val();
		boolean tuesday = $("#Tuesday").val();
//         boolean am = $("#am").val();
//         boolean pm = $("#pm").val();
//         boolean petType = $("#pettype").val();
//         boolean dogwalking = $("#dogwalking").val();
//         boolean grooming =$("#grooming").val();
//         boolean administermeds =$("#administermeds").val();
//         boolean deliverfood =$("#deliverfood").val();
//         boolean transportation =$("#transportation").val();
//         boolean fostercare =$("#fostercare").val();
//         var other =$("#other").val(); 
// 		var comments =$("#comments").val(); 
        //Check for empty values
        
        if(!monday && !tuesday)
        {
			//here, we change the html content of all divs with class="error" and show them
			//there should be only 1 such div but the code would affect multiple if they were present in the page
			$('.error').fadeIn(400).show().html('Please select preferred days/times.'); 
        }
        else
        {
			//construct the data string - this should look something like:
			//	client=John&quarter=Q1&amount=3456
			
			//var datastring = 'client=' + client + "&quarter=" + quarter + "&amount=" + amount;
 
			/*
				Make the AJAX request. The request is made to $_SERVER['PHP_SELF'], i.e., clients_form.php
				The request is handled by checking for $_POST data -- see line 6
				After the $_POST data is processed, we use the exit() function because we don't need to actually
				show the page as the request is made in the background
			*/
			$.ajax( 
				{
				type: "POST",
				url: "<?php echo $_SERVER['PHP_SELF']; ?>?cmd=submitPetAssist", 
				data: datastring,
				success: function()
					{
						uncheckAll();
						$('.success').fadeIn(2000).show().html('Pet Assistance Requested.').fadeOut(6000); //Show, then hide success msg
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

function unCheckAll()
{
  var checkboxes = new Array(); 
  checkboxes = document[client].getElementsByTagName('input');
 
  for (var i=0; i<checkboxes.length; i++)  {
    if (checkboxes[i].type == 'checkbox')   {
      checkboxes[i].checked = false;
    }
  }
}
</script>
</head>
<body>
<div id="container">
	<div id="headerplaced">
	<?php include 'includes/constant/nav.inc.php'; ?>
	
	</div>
	
	<div class="content">
	
		<div class="main">

		<h1>Request Pet Assistance</h1>
<!-- 
		<p>This is the client/pet-owner <a href="link.htm">content</a> for the public site.</p>
		<p>There will be some generic information on how the services work. There will be prominent links to the User home page and Registration.</p>
 -->
		<form method="post" name="form" id="form">
		
		   	<p><label>Pet Type</label>
   			  <select name="petType"> 
        			<option VALUE" " selected="selected"></option>
       				<option VALUE="abc"> Dog </option>
        			<option VALUE="def"> Cat </option>
        			<option VALUE="def"> Bird </option> 
    			</select>
		
   			 <p><label>I'd like assistance during </label></br>
   			 <table>
   			 <tr>
			 	<td><input type="checkbox" id="Monday" name="Monday" value="True">
			 	    <label for="Monday">Monday</label>
			 	</td>
			 	<td><input type="checkbox" id="Tuesday" name="Tuesday" value="True">
			 		<label for="Tuesday">Tuesday</label></td>
			 	<td><input type="checkbox" id="Wednesday" name="Wednesday" value="True">
			 		<label for="Wednesday">Wednesday</label></td>
			 	<td><input type="checkbox" id="Thursday" name="Thursday" value="True">
			 		<label for="Thursday">Thursday</label></td>
			 	<td><input type="checkbox" id="Friday" name="Friday" value="True">
			 		<label for="Friday">Friday</label></td>
			 </tr>
			 <tr>
			 	<td><input type="checkbox" id="Saturday" name="Saturday" value="True">
			 		<label for="Saturday">Saturday</label></td>
				 <td><input type="checkbox" id="Sunday" name="Sunday" value="True">
			 		<label for="Sunday">Sunday</label></td>
			 <tr>
			 	<td><input type="checkbox" id="am" name="am" value="True">
			 		<label for="am">AM</label></td>
				 <td><input type="checkbox" id="pm" name="pm" value="True">
			 		<label for="pm">PM</label></td>
			 </table>
   			 
   			 <p><label>Requested Services </label></br>
   			 <table>
   			 <tr>
			 	<td><input type="checkbox" id="DogWalking" name="DogWalking" value="True">
			 	    <label for="DogWalking">Dog Walking</label>
			 	</td>
			 	<td><input type="checkbox" id="Grooming" name="Grooming" value="True">
			 		<label for="Grooming">Grooming</label></td>
			 	<td><input type="checkbox" id="AdministerMed" name="AdministerMed" value="True">
			 		<label for="AdministerMed">Administer Meds</label></td>
			 </tr>
			 <tr>
				<td><input type="checkbox" id="Transport" name="Transport" value="True">
			 		<label for="Transport">Transportation</label></td>
			 	<td ><input type="checkbox" id="DeliverFood" name="DeliverFood" value="True">
			 		<label for="DeliverFood">Deliver Food</label></td>
			 	<td><input type="checkbox" id="FosterCare" name="FosterCare" value="True">
			 		<label for="FosterCare">Foster Care</label></td>
			 </tr>
			 </table>
			 <table>
			 <tr>
			 	<td valign="top"><input type="checkbox" id="OtherChk" name="OtherChk" value="True">
			 		<label for="OtherChk">Other</label></td>
<!-- 			 	<td colspan="2" rows="2"><input type="text" id="Other" name="Other" size="150" /></p> -->
				<td width="350" valign="top">
					<textarea name="Other" rows="3" style="width:100%" maxlength="200"></textarea>
			 	</td>

			</tr>
			 </table>
   			 
   			 <p><label>Additional Comments: </label><br/>
   			 <textarea name="Comments" rows="5" style="width:73%" maxlength="300"></textarea>	
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
	<p>Here's some content for the footer. Need to use an include for this.</p>
	</div>
	
</div>
</body>
</html>
