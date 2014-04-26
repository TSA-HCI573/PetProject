<?php

    include 'constant/config.inc.php';
    //error_reporting(E_ALL | E_STRICT);
    error_reporting(E_ERROR);

    function buildAddress($s)
    {
        $address = "";

        if($s['Address1'] != null)
        {
            $address .= $s['Address1'] . "<br>";
        }

        if($s['Address2'] != null)
        {
            $address .= $s['Address2'] . "<br>";
        }

        if($s['City'] != null)
        {
            $address .= $s['City'] . "<br>";
        }

        if($s['State'] != null)
        {
            $address .= $s['State'] . "<br>";
        }

        if($s['ZipCode'] != null)
        {
            $address .= $s['ZipCode'] . "<br>";
        }
        
        return $address;
    }

    function buildServices($s)
    {
        $services = array();
        if($s['DogWalking'] ==1)
        {
            $services[] = "Dog Walking";
        }
        if($s['Grooming'] ==1)
        {
            $services[] = "Grooming";
        }
        if($s['AdministerMeds'] ==1)
        {
            $services[] = "Administer Meds";
        }
        if($s['DeliverFood'] ==1)
        {
            $services[] = "Deliver Food";
        }
        if($s['FosterCare'] ==1)
        {
            $services[] = "Foster Care";
        }

        if($s['Other'] != "")
        {
            $services[] = $s['Other'];
        }

        return $services;
    }
    

    function AddSlot($mySlots, $time, $day)
    {
        $slot = array();
        $slot['time'] = $time; 
        $slot['client'] = "";
        $slot['volunteer'] = false;
        

        foreach($mySlots as $s)
        {
            $dbTime =$s['Time'];
            if( $dbTime == $time && $s['Day'] == $day)
            {
                $slot['volunteer'] = true;
                $name ="";
                if($s['FirstName'] != null
                    && $s['LastName'] != null)
                {
                    $name = $s['FirstName']. " " . $s['LastName'];
                }

                $slot['address'] = buildAddress($s);
                $slot['client'] = $name;
                $slot['services'] = buildServices($s);
                $slot['startDate'] = $s['BeginDate'];
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
