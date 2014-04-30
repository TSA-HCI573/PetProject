<?php

include 'includes/constant/config.inc.php';
session_start();
return_meta();
?>
<html>
<head>
<title>Volunteers</title>
</head>
<body>
<div id="container">
	<div id="headerplaced">
	<?php include 'includes/constant/nav.inc.php'; ?>
	
	</div>
	
	<div class="content">
	
		<div class="main">

		<img class="alignright" src="images/collie_visit_duo_350.jpg">
		
		<h1>Volunteers</h1>
		<p>Pet Project volunteers are key to our mission of helping the elderly and disabled keep their beloved companions. Volunteers perform the following types of services:</p>

		<ul><li>Feed pets</li>
		<li>Walk or exercise pets</li>
		<li>Groom pets – light grooming such as brushing a dog or cat or trimming nails</li>
		<li>Food/supplies delivery to Pet Project clients</li>
		<li>Transportation to vet and grooming appointments</li>
		<li>Food donation pickup</li>
		<li>Foster care</li>
		</ul>

		<h2>What services will I be assigned to?</h2>
		
		<p>As a volunteer you can designate the types of pet services you want to provide and the number of hours and days you have available.</p>

		
		</div>
		
		<div class="sidebar">
		
		<h3>Are you ready to join us?</h3>

		<p>To get started as a volunteer, just <a href="<?php echo SITE_BASE; ?>/register.php">register</a> and select the Volunteer option.</p> <p>On the Volunteer form you will select the times and services you're interested in.</p>
		
					
		</div>
	
	</div>
	
	<div id="footer">
	<?php include 'includes/constant/footer.inc.php'; ?>
	</div>
	
</div>
</body>
</html>
