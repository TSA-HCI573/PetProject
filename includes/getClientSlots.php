<?php
    include 'constant/config.inc.php';

    function GetAvailableSlots($userId)
    { 
        $sql =
            "select 
                m.Time, 
                m.Day,
                m.ClientId,
                m.VolunteerId,
                u.FirstName, 
                u.LastName 
            from 
                MatchUps m left outer join Users u on 
                m.VolunteerId = u.Id 
            where 
                ClientId = $userId or
                ClientId is null;";


        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 

        if($con->connect_errno)
        {
            echo "Failed to connect to mysql: " . msqli_connect_error($con);
            return;
        }
        else
        {
            $matchups = array();
            if($result = $con->query($sql))
            {
                while($row = $result->fetch_object())
                {
                    $tempArray =$row;
                    $matchups [] = $row;
                }
                echo json_encode($matchups);
            }


        }
        $con->close();
    }

    
    //$userid = $_POST['userid'];
    $userid= 2;
    GetAvailableSlots($userid);

?>

