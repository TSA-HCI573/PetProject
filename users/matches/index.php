<?php

include 'includes/constant/config.inc.php';
session_start();
return_meta();
?>
<head>
<title>Matching Volunteers with pet owners in need</title></head>
<body>
<div id="container">

<?php include 'includes/constant/nav.inc.php'; ?>

<h1>Volunteer Match Page</h1>

<p>This is the page where, after the volunteer clicks on a "Match me with a pet owner" button, a list of the top 3 pet-owner matches shows up based on type of pets, services, and location.</p>

<p>The results will be:</p>

<ul><li>A list numbered according to best match [summarizes their information in the list? links to page with all information?]</li>
		<li>A map with numbers that correspond with the list to show the locations</li>
		<li>A [frame?] with a scheduling graphic that shows how the schedule of each of the top 3 matches fits into the volunteer's day</li>
</ul>

</div>
</body>
</html>

