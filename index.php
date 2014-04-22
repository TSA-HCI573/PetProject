<?php

include 'includes/constant/config.inc.php';
session_start();
return_meta();
?>
<head>
<title>Pet Project Home Page</title></head>
<body>
<div id="container">
	<div id="headerplaced">
	<?php include 'includes/constant/nav.inc.php'; ?>
	
	</div>
	
	<div class="content">
	
		<div class="leftbarhome">

        <h2>What would you like to do? </h2>
		
		<button class="submit">Volunteer </button>
		<br><br>
		<button class="submit">Get Pet Assistance </button>
		
		<p class="note"><strong>Register first!</strong> When volunteering or requesting assistance for the first time, you will be first directed to register on the Pet Project website. </p>
						
		</div>
		
		<div class="mainhome">
		
		<h2 class="orangetext">Where the local community comes together to help the elderly and disabled keep and care for their best friends. </h2>
		<img src="images/german_shepard_duo_480.jpg">
		<h2>Pet Project impact</h2>
		
		<p>“My name is Ms. Anabelle Watson and I am 93 years old. Except for my pet Roxie I am alone. Roxie has given me comfort and companionship for 9 years. For the first 5 years that Roxie was with me, many times I had to decide whether to pay for my prescriptions or pay for Roxie’s food and medical care. This organization has not only provided pet food and covered other medical expenses, but also helps me get my baby to and from the vet as I am unable to drive. I do not know what we would do if not for the generosity and genuine concern that this organization has provided us for the past 4 years.”</p>
		<p class="footnote">This is an adaptation of a REAL story from a REAL organization. Visit <a href="http://www.palsatlanta.org/clientStories.htm" target="blank">PALS Atlanta</a> to read the full letter.</p>
					
		</div>
		
		<div class="rightbarhome">
		
		<h2>What else can you do?</h2>
		
		<p>Follow us on Facebook!</p>
		<p>Donate money, resources, or services! &raquo; <a href="donate.php">More</a> </p>
		
		
					
		</div>
	
	</div>
	
	
<div id="footer">
	<?php include 'includes/constant/footer.inc.php'; ?>
	
	</div>

	
</div>
</body>
</html>

