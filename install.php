<?php

    function isTableEmpty($con, $table)
    {
       // Determine if empty";
        $result = $con->query("select * from " . $table);
        if($result)
        {
           // echo "Num Rows =" . $result->num_rows;
            if($result->num_rows > 0)
            {
                $result->close();
                return false;
            }
            $result->close();
        }
        return true;
    }

    function updateUserDetails($con, $firstName, $address, $city, $state, $zip, $bio)
    {
        $sql = "update Users 
                set 
                    FirstName = '$firstName', 
                    Address1='$address', 
                    City='$city', 
                    State = '$state',
                    ZipCode = '$zip',
                    Bio = '$bio'
                where 
                    FirstName = '$firstName';";

        if($con->query($sql) === FALSE)
        {
            echo "<br/> Error updating user info <br/>" . $con->error;
            return;
        }
    }

    function updateMatchUpTable($con, $volunteer, $client, $day, $time)
    {
        $sql = "insert into MatchUps(ClientId, VolunteerId, Day, Time)
            values($client,$volunteer,'$day', '$time');";

        if($con->query($sql) === FALSE)
        {
            echo "<br/> Error updating MatchUps <br/>" . $con->error;
            return;
        }
    }

    function updateVolunteerAndRequest($con, $table, $userid, $beginDate, $petType, $dw, $g, 
        $a, $df, $t, $fc, $other)
    {
        $sql = "
            insert into $table(
                UserId, BeginDate, PetType, DogWalking, Grooming, AdministerMeds, DeliverFood,
                Transport, FosterCare, Other)
            values(
                $userid, Date('$beginDate'), '$petType', $dw, $g, $a, $df, $t, $fc, '$other');";

        if($con->query($sql) === FALSE)
        {
            echo "<br/> Error updating Volunteers <br/>" . $con->error;
            return;
        }
    }

    

    echo "Starting install....<br/>";
    
    //see if I can establish a connection to the database
    $con = new mysqli("localhost", "hci573","hci573","petproject");
    
	
    if( $con->connect_errno)
    {
    	echo "Creating database <br/>";
        //If Database doesn't exist try to create it
        $con = new mysqli("localhost", "hci573","hci573");
        if($con->connect_errno)
        {
            //Couldn't connect so we can't create nuthin, exit
            echo "Failed to Connect to mysql: " . mysqli_connect_error($con) . "<br/";
            return;
        }
        else// We could connect so lets try to create
        {
            $sql="create database petproject";
            if($con->query($sql)=== FALSE)
            { //Couldn't create databasei, exit
                echo "<br/>Error creating sql database: " . $con->error . "<br/";
                return;
            }
        }
   	 }
   	 else //no error so drop the database
   	 {
   	 	$sql="drop database petproject";
            if($con->query($sql)=== FALSE)
            { //Couldn't drop databasei, exit
                echo "<br/>Error dropping sql database: " . $con->error . "<br/";
                return;
            }
            else //dropped it now recreate it
            {
           		 $con = new mysqli("localhost", "hci573","hci573");
                if($con->connect_errno)
        		{
         		   //Couldn't connect so we can't create nuthin, exit
         		   echo "Failed to Connect to mysql: " . mysqli_connect_error($con) . "<br/";
           		 return;
        		}
        		else// We could connect so lets try to create
        		{
            		$sql="create database petproject";
            		if($con->query($sql)=== FALSE)
            		{ //Couldn't create databasei, exit
                	echo "<br/>Error creating sql database: " . $con->error . "<br/";
                	return;
           			 }
        		}
            
            }
   	 }
    
    $con = new mysqli("localhost", "hci573","hci573","petproject");
        if( $con->connect_errno)
        {
        	echo "Failed to get connection to new petproject db <br/>";
        	return;
        }
        
    //If we are here we should be connected to a database
    echo " Created Pet Project database <br/> ";
    //create users table
    $sql ="create table if not exists Users (
Id bigint(20) not null auto_increment,
FirstName varchar(100),
LastName varchar(100),
Email varbinary(100),
Password varchar(100),
md5_id varchar(200),
UserName varchar(100),
Address1 varchar(100),
Address2 varchar(100),
City varchar(50),
State varchar(2),
ZipCode varchar(7),
Bio mediumtext,
ProfileImagePath varchar(200),
ckey varchar(200),
ctime varchar(200),
num_logins int(11),
last_login timestamp,	
primary key (Id))";
    if($con->query($sql) === FALSE)
    {
        echo "<br/> Error creating users table <br/>". $con->error;
        return;
    }

   
    $sql= "create table if not exists UserRole(
Id bigint(20) not null auto_increment,
UserId bigint(20),
Rating int,
UserType varchar(9),
primary key (Id))";

    if($con->query($sql) === FALSE)
    {
        echo "<br/> Error creating userRole table <br/>" . $con->error;

        return;
    }
    
 
 $sql="CREATE UNIQUE INDEX index_UserId
	ON UserRole (userId)";
	
        if($con->query($sql) === FALSE)
    {
        echo "<br/> Error creating index on UserRole table <br/>" . $con->error;

        return;
    }
    
    
    
    
    $sql ="create table if not exists MatchUps(
Id bigint(20) not null auto_increment,
ClientId bigint(20),
VolunteerId bigint(20),
Day varchar(15),
Time varchar(9),
Completed boolean,
UserReview int,
ClientReview int,
primary key(Id));";

    if($con->query($sql) === FALSE)
    {
        echo "<br/> Error creating matchups table <br/>" . $con->error;

        return;
    }
        
      //create requests table
    $sql ="create table if not exists Requests (
Id bigint(20) not null auto_increment,
UserId bigint(20),
BeginDate Date,
PetType varchar(100),
DogWalking boolean,
Grooming boolean,
AdministerMeds boolean,
DeliverFood boolean,
Transport boolean,
FosterCare boolean,
Other varchar(200),
Comments mediumtext,
primary key (Id))";
    if($con->query($sql) === FALSE)
    {
        echo "<br/> Error creating requests table <br/>". $con->error;
        return;
    }
     
$sql="CREATE UNIQUE INDEX index_Requests_UserId ON Requests (userId)";
	
        if($con->query($sql) === FALSE)
    {
        echo "<br/> Error creating index on Requests table <br/>" . $con->error;

        return;
    }
    
    
          //create volunteers table
    $sql ="create table if not exists Volunteers (
Id bigint(20) not null auto_increment,
UserId bigint(20),
BeginDate Date,
PetType varchar(100),
DogWalking boolean,
Grooming boolean,
AdministerMeds boolean,
DeliverFood boolean,
Transport boolean,
FosterCare boolean,
Other varchar(200),
Comments mediumtext,
primary key (Id))";
    if($con->query($sql) === FALSE)
    {
        echo "<br/> Error creating Volunteers table <br/>". $con->error;
        return;
    }
    
	echo "Created database tables <br/>";


    require 'includes/constant/config.inc.php';

   //Seting up some predefined values for our Usability study. 
    if(isTableEmpty($con, "Users"))
    {
        add_user("Anne", "Hatheway", "user1", "pass", "anne.hatheway@notreal.com");
        updateUserDetails($con, "Anne", "213 E Shawnee Ave", "Des Moines",
            "IA", "50313", "I am great with Dogs and I have 5yrs experience" );
        add_user("John", "Smith", "user2", "pass", "john.smith@notreal.com");
        updateUserDetails($con, "John", "1318 Main St", "Norwalk",
            "IA", "50211", "I am a paraplegic Vet. with a Cockatiel" );
        add_user("Heinrich", "Dudiekerbaumer", "user3", "pass", "heinrich.d@notreal.com");
        updateUserDetails($con, "Heinrich", "1301 Beckley St.", "Ames",
            "IA", "50010", "I am a new volunteer and excited to start helping!" );
        add_user("Luis", "Verde", "user4", "pass", "luis.verde@notreal.com");
        updateUserDetails($con, "Luis", "203 Story St.", "Slater",
            "IA", "50244", "I am a retired school teacher that loves animals" );
        add_user("Julie", "O\'Brian", "user5", "pass", "july.obrian@notreal.com");
        updateUserDetails($con, "Julie", "16532 Buena Vista Dr.", "Clive",
            "IA", "50324", "I am a second year student at DMACC." );
        echo "Added Users<br/>";

    }

    if(isTableEmpty($con, "UserRole"))
    { 
        updateUserRole(1, "Volunteer");
        updateUserRole(2, "Client");
        updateUserRole(3, "Volunteer");
        updateUserRole(4, "Client");
        updateUserRole(5, "Volunteer");
    }

    if(isTableEmpty($con, "Volunteers"))
    {
        updateVolunteerAndRequest($con, "Volunteers", 1, "2014-5-2", "Dog", 1, 0, 0, 0, 1, 1, "Jogging"); 
        updateVolunteerAndRequest($con, "Volunteers", 3, "2014-5-4", "Cat", 0, 1, 0, 0, 1, 1, ""); 
        updateVolunteerAndRequest($con, "Volunteers", 5, "2014-5-3", "Cat", 0, 1, 0, 0, 1, 1, "Litterbox Cleaning"); 
    }
    if(isTableEmpty($con, "Requsets"))
    {
        updateVolunteerAndRequest($con, "Requests", 2, "2014-5-2", "Bird", 0, 0, 0, 0, 1, 1, "Cage Cleaning"); 
        updateVolunteerAndRequest($con, "Requests", 4, "2014-5-4", "Dog", 1, 0, 0, 0, 1, 1, ""); 
    }

    if(isTableEmpty($con, "MatchUps"))
    {
        updateMatchUpTable($con, 1, 2, "Monday", "AM");
        updateMatchUpTable($con, 1, 'null', "Tuesday", "PM");
        updateMatchUpTable($con, 3, 'null', "Saturday", "AM");
        updateMatchUpTable($con, 3, 4, "Thursday", "AM");
        updateMatchUpTable($con, 5, 'null', "Saturday", "AM");
        updateMatchUpTable($con, 5, 4, "Saturday", "AM");
        echo "Created Volunteer/Pet Owner Matches<br/>";
    }
    
    $con->close();
?>
