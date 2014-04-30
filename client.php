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
		<ol><li><a href="<?php echo SITE_BASE; ?>/register.php">Register</a> on this site.</li>
		<li>Log in using the Login link.</li> 
		<li>Fill out all of your information on your profile.</li>
		<li>Use the <a href="x">Match Tool</a> to provide the details of your request and find a volunteer.</li>
		</ol>
		<h3>Need help?</h3>
		<p>If you need help, you can call Pet Project at 515-111-2222 and we will assist you with the form.</p>
		<h3>Paper form</h3>
		<p>If you know someone that would like to register who doesn't have a computer, they can print out the paper Pet Owner Form and mail it to Pet Project.</p> 
		
					
		</div>
	
	</div>
	
	<div id="footer">
	<?php include 'includes/constant/footer.inc.php'; ?>
	</div>
	
</div>
</body>
</html> 
