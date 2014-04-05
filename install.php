<?php

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
    echo "php started";
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
                echo "Error creating sql database: " . $con->error;
                return;
            }
        }
    }
    //If we are here we should be connected to a database
    echo "database creation successful";
    //create users table
    $sql ="create table if not exists Users (
        Id bigint(20) not null auto_increment,
        FirstName varchar(100),
        LastName varchar(100),
        Email varchar(100),
        Password varchar(100),
        UserName varchar(100),
        Address varchar(100),
        State varchar(2),
        ZipCode varchar(7),
        Bio mediumtext,
        ProfileImagePath varchar(200),
        primary key (Id))";
    if($con->query($sql) === FALSE)
    {
        echo "Error creating users table". $con->error;
        return;
    }

    $sql= "create table if not exists UserPets(
        Id bigint(20) not null auto_increment,
        UserId bigint(20),
        PetType varchar(100),
        primary key (Id))";

    if($con->query($sql) === FALSE)
    {
        echo "Error creating userpets table" . $con->error;

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
        echo "Error creating userpets table" . $con->error;

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
        echo "Error creating matchups table" . $con->error;

        return;
    } 
    echo "Database Creation Sucessful";
    
    $con->close();
?>
