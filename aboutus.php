<?php

include 'includes/constant/config.inc.php';
session_start();
return_meta();
?>
<head>
<title>About Us</title></head>
<body>
<div id="container">
	<div id="headerplaced">
	<?php include 'includes/constant/nav.inc.php'; ?>
	
	</div>
	
	<div class="content">
	
		<div class="main">

		<h1>About Us</h1>
		<p>This is the about us <a href="link.htm">content</a> for the public site.</p>
		<p>Add Mission stuff and an overview of what we do.</p>

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