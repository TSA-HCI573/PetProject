<?php

    include 'constant/config.inc.php';
    //error_reporting(E_ALL | E_STRICT);
    error_reporting(E_ERROR);

    $userId = $_POST['userid'];
    $time = $_POST['time'];
    $day = $_POST['day'];

    if(!isset($userId) 
        || !isset($time)
        || !isset($day))
    {
        echo "Post Data Bad!";
        echo $userId;
        echo $time;
        echo $day;
        return;
    }

    $sql = 
        "select *
        from 
            MatchUps 
        where 
            VolunteerId = $userId and
            Time = '$time' and
            Day = '$day';";

    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 
    $timeFilled = false;
    $result = $con->query($sql);
    if($result)
    { 
        
        if($result->num_rows > 0)
        {
            $timeFilled = true;
            $result->close();

        }
        $result->close();
    }

    if($timeFilled)
    {
        echo("Allready There Deleting");
        $sql =  
        "delete
        from 
            MatchUps 
        where 
            VolunteerId = $userId and
            Time = '$time' and
            Day = '$day';";

        $con->query($sql);
    }
    else
    {
        echo("Not there Yet");
        $sql ="insert into MatchUps (VolunteerId, Time, Day)
            values($userId, '$time', '$day');";
        $con->query($sql);
    }
$con->close();

 
?> 
