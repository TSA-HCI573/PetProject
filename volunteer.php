<?php

include 'includes/constant/config.inc.php';
session_start();
return_meta();
?>
<html>
<head>
<title>Volunteer</title>
</head>
<body>
<div id="container">
	<div id="headerplaced">
	<?php include 'includes/constant/nav.inc.php'; ?>
	
	</div>
	
	<div class="content">
	
		<div class="main">

		<h1>Volunteer</h1>
		<p>This is the volunteer <a href="link.htm">content</a> for the public site.</p>
		<p>There will be some generic information on the different ways people can volunteer. There will be prominent links to the User home page and Registration.</p>

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