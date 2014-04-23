
<?php require_once 'config.inc.php'; ?>
<div class="header">

	<div class="imageleft">
    <img src="<?php echo SITE_BASE . "/images/dog_and_cat_green_bg.jpg"?>">
	</div>
	
	<div class="admin">
		<ul>
		<?php if(!isset($_SESSION['UserId'])) //checks out true if nobody is logged in
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
				
				<!-- USER PROFILE link -->
				<li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'profile.php') { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/users/profile.php">Update My Information</a></li>
					
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
			
</div>

<div class="nav">
		<ul>
			
			<!-- SITE HOME link -->
			<li
			<?php 
				//checks if the current page matches the string '/users/index.php'
				if(basename($_SERVER['SCRIPT_NAME']) == 'index.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>">Home</a>
			</li>
			
			
			
			<!-- ABOUT US link -->
			<li
			<?php 
			
				if(basename($_SERVER['SCRIPT_NAME']) == 'aboutus.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>/aboutus.php">About Us</a>
			</li>
			
		
			<!-- DONATE link -->
			<li
			<?php 
			
				if(basename($_SERVER['SCRIPT_NAME']) == 'donate.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>/donate.php">Donate</a>
			</li>
			
			
				<!-- CONTACT US link -->
			<li
			<?php 
				if(basename($_SERVER['SCRIPT_NAME']) == 'contactus.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>/contactus.php">Contact Us</a>
			</li>
            <!-- Public Volunteer Link-->
            <li
			<?php 
				if(basename($_SERVER['SCRIPT_NAME']) == 'volunteer.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>/volunteer.php">Volunteer</a>
			</li>

            <!-- Private Volunteer Link-->
            <li
			<?php 
				if(basename($_SERVER['SCRIPT_NAME']) == 'client.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>/client.php">Pet Owners</a>
			</li>



            <?php
           //determine if the user is logged in so we can display conditional 
           //tabs 

            if(isset($_SESSION) && isset($_SESSION['UserId']))
            {
                $userId = $_SESSION['UserId'];
                $userRole = getUserRole($userId);
            }
            else
            {
                $userRole = array();
            }

            //VOLUNTEER link 
            if(in_array("Volunteer", $userRole))
            {
			    echo "<li ";
                if(basename($_SERVER['SCRIPT_NAME']) == 'volunteer.php') { echo "class=\"current\""; }
            
                echo" >";
                echo "<a href='". SITE_BASE . "/users/volunteers.php'>Volunteer Your Services</a>";
                echo "</li>";
            }

			// REQUEST PET ASSISTANCE link
            if(in_array("Client", $userRole))
            {
                echo "<li ";
                if(basename($_SERVER['SCRIPT_NAME']) == 'client.php') { echo "class=\"current\""; }

                echo " >";
                echo "<a href='" . SITE_BASE . "/users/clients.php'>Request Pet Assistance</a>";
                echo"</li>"; 
            }
?>
					


			
		</ul>
</div>


