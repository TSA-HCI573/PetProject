<?php

include 'includes/constant/config.inc.php';
session_start();
return_meta();

//Check for post data
if($_POST and $_GET)
{
	if ($_GET['cmd'] == 'add'){
		echo "POST";
		//Assign variables and sanitize POST data
		$monday = mysql_real_escape_string($_POST['monday']);
		$tuesday = mysql_real_escape_string($_POST['tuesday']);
		$wednesday = mysql_real_escape_string($_POST['wednesday']);
		$thursday = mysql_real_escape_string($_POST['thursday']);
		$friday = mysql_real_escape_string($_POST['friday']);
		$saturday = mysql_real_escape_string($_POST['saturday']);
		$sunday = mysql_real_escape_string($_POST['sunday']);
		$am = mysql_real_escape_string($_POST['am']);
		$pm = mysql_real_escape_string($_POST['pm']);
		//$petType = mysql_real_escape_string($_POST['PetType']);


		//Build our query statement
 		//var insertRequest = "INSERT INTO ".REQUEST." (UserId, Monday, petType) VALUES (1, '" . $monday . "', '" .$petType . "')";
 		//mysql_query("INSERT INTO Requests(UserId, Monday, petType) VALUES (1, 1, 'testing')") or die(mysql_error());
		mysql_query("INSERT INTO ".REQUESTS."(UserId, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday) 
		VALUES (1, '" . $monday . "', '" . $tuesday. "', '" . $wednesday . "', '" . $thursday . "', '" . $friday . "', '" . $saturday . "', '" . $sunday . "')") or die(mysql_error());
 	//	 echo insertRequest;
	 
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
		var monday = $('#monday').prop('checked') ? 1:0;
		var tuesday = $('#tuesday').prop('checked') ? 1:0;
		var wednesday = $('#wednesday').prop('checked') ? 1:0;
		var thursday = $('#thursday').prop('checked') ? 1:0;
		var friday = $('#friday').prop('checked') ? 1:0;
		var saturday = $('#saturday').prop('checked') ? 1:0;
		var sunday = $('#sunday').prop('checked') ? 1:0;
		var am = $('#am').prop('checked') ? 1:0;
		var pm = $('#pm').prop('checked') ? 1:0;
		
		//boolean monday = $("#Monday").val();
		//boolean tuesday = $("#Tuesday").val();
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
        
//         if(!monday && !tuesday)
		if(petType="")
        {
			//here, we change the html content of all divs with class="error" and show them
			//there should be only 1 such div but the code would affect multiple if they were present in the page
			$('.error').fadeIn(400).show().html('Please select preferred days/times.'); 
        }
        else
        {
			//construct the data string ]
			
				var datastring =  "monday=" + monday + "&tuesday=" + tuesday + "&wednesday=" + wednesday + "&thursday=" + thursday + "&friday=" + friday + "&saturday=" + saturday
								+ "&sunday=" + sunday + "&am=" + am + "&pm=" + pm;
 
 
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
						//uncheckAll();
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

// function unCheckAll()
// {
//   var checkboxes = new Array(); 
//   checkboxes = document[client].getElementsByTagName('input');
//  
//   for (var i=0; i<checkboxes.length; i++)  {
//     if (checkboxes[i].type == 'checkbox')   {
//       checkboxes[i].checked = false;
//     }
//   }
// }
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
   			  <select name="petType" id="petType"> 
        			<option VALUE"" selected="selected"></option>
       				<option name="petType" id="petType"VALUE="Dog"> Dog </option>
        			<option VALUE="Cat"> Cat </option>
        			<option VALUE="Bird"> Bird </option> 
    			</select>
		</p>
   			 <p><label>I'd like assistance during </label></p></br>
   			 <table>
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
			 		<label for="sunday">Sunday</label></td>
			 <tr>
			 	<td><input type="checkbox" id="am" name="am">
			 		<label for="am">AM</label></td>
				 <td><input type="checkbox" id="pm" name="pm">
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
