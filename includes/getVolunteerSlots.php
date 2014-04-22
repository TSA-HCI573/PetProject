<?php

    include 'constant/config.inc.php';
    //error_reporting(E_ALL | E_STRICT);
    error_reporting(E_ERROR);
    

    function AddSlot($mySlots, $time, $day)
    {
        $slot = array();
        $slot['time'] = $time; 
        $slot['client'] = "";
        $slot['volunteer'] = false;
        

        foreach($mySlots as $s)
        {
            $dbTime =$s['Time'];

            //echo $startTime . " = " . $time . " | ";
            if( $dbTime == $time && $s['Day'] == $day)
            {
                $slot['volunteer'] = true;
                $name ="";
                if($s['FirstName'] != null
                    && $s['LastName'] != null)
                {
                    $name = $s['FirstName']. " " . $s['LastName'];
                } 

                $slot['client'] = $name;
            }
        }
        return $slot;
    }

    function GetVolunteerSlots($userId)
    {
        if(!isset($userId))
        {
            return;
        }
        $sql = 
            "select 
                m.Time, 
                m.Day,
                u.FirstName, 
                u.LastName 
            from 
                MatchUps m left outer join Users u on 
                m.ClientId = u.Id 
            where 
                VolunteerId = $userId;";
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 

        $mySlots =array();
        if($result = $con->query($sql))
        {
            $tempArray = array();
            while($row = $result->fetch_array())
            {
                $tempArray = $row;
                array_push($mySlots, $tempArray);
            }
        }
        else
        {
            echo $con->error;
        }

        $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday","Friday","Saturday");
        $slots = array();
        foreach($days as $day)
        {
            
            $slot = AddSlot($mySlots, "Morning",$day);
            $slots[$day][] = $slot;

            $slot = AddSlot($mySlots, "Afternoon",$day);
            $slots[$day][] = $slot;
        }
        echo json_encode($slots);
    }
    $userid = $_GET['userid'];
    GetVolunteerSlots($userid);

?>
