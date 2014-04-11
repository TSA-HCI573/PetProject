<?php

include 'includes/constant/config.inc.php';
session_start();
return_meta();
?>
<head>
<title>Home</title></head>
<body>
<div id="container">
	<div id="headerplaced">
	<?php include 'includes/constant/nav.inc.php'; ?>
	
	</div>
	
	<div class="content">
	
		<div class="sidebarhome">

		<h2>What would you like to do?</h2>
		
		<p>A CHANGE </p>
		
		<p><strong>Volunteer </strong>button</p>
		
		<p><strong>Get Pet Assistance </strong>button</p>
		
		<p class="note"><strong>Register first!</strong> When volunteering or requesting assistance for the first time, you will be first directed to register on the Pet Project website. </p>
						
		</div>
		
		<div class="mainhome">
		
		<p>Home page content/photo.</p>
		<img src="images/unpurchased_photo.jpg">
		
				
		
		</div>
	
	</div>
	
	<div id="footer"> 
	
	<p>Here's some content for the footer. Need to use an include for this.</p>
	
	</div>
	
</div>
</body>
</html>

