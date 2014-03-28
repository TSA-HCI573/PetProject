<?php
/*Nav.inc.php*/
?>
	<div class="nav">
		<ul>
			
			<!-- SITE HOME link -->
			<li
			<?php 
			
				//checks if the current page matches the string '/users/index.php'
				//print_r($_SERVER);
				if(!strpos($_SERVER['SCRIPT_NAME'], '/users/index.php') and basename($_SERVER['SCRIPT_NAME']) == 'index.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>">Site Home</a>
			</li>
			
			
			<!-- ABOUT US link -->
			<li
			<?php 
			
				//checks if the current page matches the string '/users/index.php'
				//print_r($_SERVER);
				if(!strpos($_SERVER['SCRIPT_NAME'], '/users/index.php') and basename($_SERVER['SCRIPT_NAME']) == 'index.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>/aboutus.php">About Us</a>
			</li>
			
			<!-- VOLUNTEER link -->
			<li
			<?php 
			
				//checks if the current page matches the string '/users/index.php'
				//print_r($_SERVER);
				if(!strpos($_SERVER['SCRIPT_NAME'], '/users/index.php') and basename($_SERVER['SCRIPT_NAME']) == 'index.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>/volunteer.php">Volunteer</a>
			</li>
						
			<!-- REQUEST PET ASSISTANCE link -->
			<li
			<?php 
			
				//checks if the current page matches the string '/users/index.php'
				//print_r($_SERVER);
				if(!strpos($_SERVER['SCRIPT_NAME'], '/users/index.php') and basename($_SERVER['SCRIPT_NAME']) == 'index.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>/client.php">Request Pet Assistance</a>
			</li>			
					

			<!-- DONATE link -->
			<li
			<?php 
			
				//checks if the current page matches the string '/users/index.php'
				//print_r($_SERVER);
				if(!strpos($_SERVER['SCRIPT_NAME'], '/users/index.php') and basename($_SERVER['SCRIPT_NAME']) == 'index.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>/donate.php">Donate</a>
			</li>
			
			
				<!-- CONTACT US link -->
			<li
			<?php 
			
				//checks if the current page matches the string '/users/index.php'
				//print_r($_SERVER);
				if(!strpos($_SERVER['SCRIPT_NAME'], '/users/index.php') and basename($_SERVER['SCRIPT_NAME']) == 'index.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>/contactus.php">Contact Us</a>
			</li>
			
			

			<?php if(!isset($_SESSION['user_id'])) //checks out true if nobody is logged in
			{
			?>
				<!-- REGISTER link -->
				<li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'register.php') { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/register.php">Register</a></li>
				
				<!-- LOGIN link -->
				<li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'login.php') { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/login.php">Login</a></li>
				
				<?php
			}
			else	//else, a user must be logged in so we show them some different options
			{
				?>
				
				<!-- SECURE HOME link -->
				<li <?php if(strpos($_SERVER['SCRIPT_NAME'], 'users/index.php')) { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/users/">Secure Home</a></li>
				
				<!-- USER PROFILE link -->
				<li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'profile.php') { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/users/profile.php">User Profile</a></li>
					
				<?php
				if(is_admin()) {
				?>
					<!-- MANAGE USERS link: only available to administrators -->
					<li <?php if(strpos($_SERVER['SCRIPT_NAME'], 'users/admin.php')) { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/users/admin.php">Manage Users</a></li>
				<?php
				} 
				?>
					
				
				<!-- LOGOUT link -->
				<li><a href="<?php echo SITE_BASE; ?>/logout.php">Logout</a></li>
				<?php
			}
			?>
		</ul>
	</div>
	<div class="clear">
	<!-- trying to get the body content of the page to clear the float. -->
	</div>
