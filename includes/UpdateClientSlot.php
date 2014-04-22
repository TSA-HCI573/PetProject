<?php

    include 'constant/config.inc.php';
    error_reporting(E_ALL | E_STRICT);
 
    $userId = $_POST['userid'];
    $time = $_POST['time'];
    $day = $_POST['day'];
    $volunteer = $_POST['volunteer'];

    if(!isset($userId)
        || !isset($time)
        || !isset($day)
        || !isset($volunteer))
    {
        return;
    }


    $sql = 
        "select *
        from 
            MatchUps 
        where 
            ClientId = $userId and
            VolunteerId =$volunteer and
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
        echo("Allready There UnSetting");
        $sql =  
        "update MatchUps 
        set
           ClientId = null 
        where 
            VolunteerId = $volunteer and
            Time = '$time' and
            Day = '$day';";

        $con->query($sql);
    }  
    else
    {
        echo("Not There Yet, Updating");
        $sql =  
        "update MatchUps 
        set
           ClientId = $userId 
        where 
            VolunteerId = $volunteer and
            Time = '$time' and
            Day = '$day';";

        $con->query($sql);
    }
    $con->close();
?>
