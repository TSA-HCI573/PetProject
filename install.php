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
            { //Couldn't create databasei, exit
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
Id bigint(20) not null auto_increment,
ClientId bigint(20),
VolunteerId bigint(20),
PetType varchar(45),
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
Monday boolean,
Tuesday boolean,
Wednesday boolean,
Thursday boolean,
Friday boolean,
Saturday boolean,
Sunday boolean,
AM boolean,
PM boolean,
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
    
          //create volunteers table
    $sql ="create table if not exists Volunteers (
Id bigint(20) not null auto_increment,
UserId bigint(20),
BeginDate Date,
Monday boolean,
Tuesday boolean,
Wednesday boolean,
Thursday boolean,
Friday boolean,
Saturday boolean,
Sunday boolean,
AM boolean,
PM boolean,
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
    
    echo "<br/>Database Creation Sucessful<br/> ";


    require 'includes/constant/config.inc.php';

    
    if(isTableEmpty($con, "Users"))
    {
        add_user("user1", "user1", "user1", "pass", "user1@user1.com", "", "", "", "", "", "", "" );
        add_user("user2", "user2", "user2", "pass", "user2@user2.com", "", "", "", "", "", "", "" );
    }
    if(isTableEmpty($con, "UserRole"))
    {
        $sql = "insert into UserRole (UserId,UserType) values(1, 'Volunteer')";
        if($con->query($sql))
        {
            echo "Succesfully Populated UserRole";
        }
        else
        {
            echo $con->error;
        }
        $sql = "insert into UserRole (UserId,UserType) values(2, 'Client')";
        if($con->query($sql))
        {
            echo "Succesfully Populated UserRole";
        }
        else
        {
            echo $con->error;
        }

    }
    
    $con->close();
?>