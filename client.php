<?php

include 'includes/constant/config.inc.php';
session_start();
return_meta();
?>
<html>
<head>
<title>Pet Owners</title>
</head>
<body>
<div id="container">
	<div id="headerplaced">
	<?php include 'includes/constant/nav.inc.php'; ?>
	
	</div>
	
	<div class="content">
	
		<div class="main">
		<img class="alignright" src="images/stripes_puppy_duo_350.jpg">
		<h1>Pet Owners</h1>
		<p>Pet Project wants to help you keep your pet when your health or income circumstances change, making pet expenses or care difficult.</p>
		<p>Pet Project volunteers can help with:</p>
	
		<ul>
		<li>Walking or exercising your pet</li>
		<li>Taking your pet to vet or grooming appointments</li>
		<li>Performing basic grooming</li>
		<li>Helping administer medication</li>
		<li>Delivering food</li>
		<li>Providing temporary foster care</li>
		</ul>
		<h2>Pet owner criteria</h2>
		<p>Pet Project clients must meet the following criteria to receive services or resources:
		<ul>
		<li>Must be disabled or at least 65 years old</li>
		<li>Must have a household income of no more than $25,000 per year</li>
		</ul>
		
		</div>
		
		<div class="sidebar">
		<h3>Get started!</h3>
		<p>To get started with your request, you need to: 
		<ol><li>Go to <a href="<?php echo SITE_BASE; ?>/register.php">register</a> and complete the form.</li>
		<li>Select the Pet Owner option.</li> 
		<li>Fill out all of your information on the Pet Owner form.</li>
		<li>Use the <a href="x">Match Tool</a> to view possible volunteers and select one.</li>
		</ol>
		<p>If you need help, you can call Pet Project and we will assist you with the form.</p>
		<p>If you know someone that would like to register who doesn't have a computer, they can print out the paper <a href="x">Pet Owner Form</a> and mail it to Pet Project.</p> 
		
					
		</div>
	
	</div>
	
	<div id="footer">
	<?php include 'includes/constant/footer.inc.php'; ?>
	</div>
	
</div>
</body>
</html> 
