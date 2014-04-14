<?php

include 'includes/constant/config.inc.php'; 

    function isTableEmpty($con, $table)
    {
        echo "Determine if empty";
        $result = $con->query("select * from " . $table);
        if($result)
        { 
            echo "Num Rows =" . $result->num_rows;
            if($result->num_rows > 0)
            {
                $result->close();
                return false;
            }
            $result->close();
        }
        return true;
    }
    echo "php started <br/>";
    $con = new mysqli("localhost", "hci573","hci573","petproject"); 

    if( $con->connect_errno)
    {
        //If Database doesn't exist try to create it 
        $con = new mysqli("localhost", "hci573","hci573");
        if($con->connect_errno)
        {
            //Couldn't connect so we can't create nuthin, exit
            echo "Failed to Connect to mysql: " . mysqli_connect_error($con);
            return;
        }
        else// We could connect so lets try to create
        {
            $sql="create database petproject";
            if($con->query($sql)=== FALSE)
            {   //Couldn't create databasei, exit
                echo "<br/>Error creating sql database: " . $con->error;
                return;
            }
        }
    }
    //If we are here we should be connected to a database
    echo " database creation successful ";
    //create users table
    $sql ="create table if not exists Users (
        Id bigint(20) not null auto_increment,
        FirstName varchar(100),
        LastName varchar(100),
        Email varchar(100),
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
        primary key (Id))";
    if($con->query($sql) === FALSE)
    {
        echo "<br/> Error creating users table <br/>". $con->error;
        return;
    }

    $sql= "create table if not exists UserPets(
        Id bigint(20) not null auto_increment,
        UserId bigint(20),
        PetType varchar(100),
        primary key (Id))";

    if($con->query($sql) === FALSE)
    {
        echo "<br/>Error creating userpets table <br/>" . $con->error;

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
        echo "<br/> Error creating userpets table <br/>" . $con->error;

        return;
    }   	
    $sql ="create table if not exists MatchUps(
	Id bigint(20),
	ClientId bigint(20),
	VolunteerId bigint(20),
	PetType varchar(45),
	Day varchar(15),
	StartTime time,
	EndTime time,
	Completed boolean,
	UserReview int,
	ClientReview int);";

    if($con->query($sql) === FALSE)
    {
        echo "<br/> Error creating matchups table <br/>" . $con->error;

        return;
    } 
    echo "<br/>Database Creation Sucessful<br/> ";
    
	if(isTableEmpty($con,'Users'))
	{
		$sql ="insert into Users (
		FirstName,
		LastName,
		Email,
		Password,
		md5_id,
		UserName,
		Address1,
		Address2,
		City,
		State,
		ZipCode,
		Bio,
		ProfileImagePath)
		values(
		'Amy',
		'Kern',
		'akern@iastate.edu',
		'abc123',
		'lkj',
		'akern',
		'6680 123rd Lane',
		'lk',
		'Indianola',
		'IA',
		'50125',
		'something about me, a clob',
		'dummy.jpg');";
		if($con->query($sql) === FALSE)
		{
			echo "<br/> Error populating users table <br/>" . $con->error;
		}
	}
    $con->close();
?>
