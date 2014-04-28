<?php

    include 'constant/config.inc.php';
    include 'SlotBuilder.php';
    //error_reporting(E_ALL | E_STRICT);
    error_reporting(E_ERROR);

       

    function AddSlot($mySlots, $time, $day)
    {
        $slot = array();
        $slot['time'] = $time; 
        $slot['volunteer'] = false;
        $slot['lastName'] = "";
        $slot['firstName'] = "";

        foreach($mySlots as $s)
        {
            $dbTime =$s['Time'];
            if( $dbTime == $time && $s['Day'] == $day)
            {
                $slot['volunteer'] = true;
                $name ="";
                
                if($s['FirstName'] != null)
                {
                    $slot['firstName'] = $s['FirstName'];
                }
                if($s['LastName'] != null)
                {
                    $slot['lastName'] = $s['LastName'];
                }


                $slot['address'] = buildAddress($s);
                $slot['services'] = buildServices($s);
                $slot['startDate'] = $s['BeginDate'];
                $slot['petType'] = $s['PetType'];
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
                u.LastName,
                AES_DECRYPT(u.Email, '$salt') AS Email,
                u.Address1,
                u.Address2,
                u.City,
                u.State,
                u.ZipCode,
                u.Bio,
                r.BeginDate,
                r.PetType,
                r.DogWalking,
                r.Grooming,
                r.AdministerMeds,
                r.DeliverFood,
                r.Transport,
                r.FosterCare,
                r.Other,
                r.Comments 
            from 
                MatchUps m left outer join Users u on 
                    m.ClientId = u.Id 
                left outer join Requests r on 
                    m.ClientId = r.UserId
                    
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
            
            $slot = AddSlot($mySlots, "AM",$day);
            $slots[$day][] = $slot;

            $slot = AddSlot($mySlots, "PM",$day);
            $slots[$day][] = $slot;
        }
        echo json_encode($slots);
    }
    $userid = $_GET['userid'];
    GetVolunteerSlots($userid);

?>
