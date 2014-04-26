<?php
    include 'constant/config.inc.php';
    include 'SlotBuilder.php';

    function AddSlot($s)
    {
        $slot = array();
        $slot['Time'] = $s['Time'];
        $slot['Day'] = $s['Day'];
        $slot['ClientId'] = $s['ClientId'];
        $slot['VolunteerId'] = $s['VolunteerId'];
        $slot['FirstName'] = $s['FirstName'];
        $slot['LastName'] = $s['LastName'];

        $slot['Address'] = buildAddress($s);
        $slot['Services'] = buildServices($s);
        $slot['StartDate'] =['BeginDate'];

        return $slot;
    }

    function GetAvailableSlots($userId)
    { 
        $sql =
            "select 
                m.Time, 
                m.Day,
                m.ClientId,
                m.VolunteerId,
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
                r.Transport,
                r.FosterCare,
                r.Other,
                r.Comments
            from 
                MatchUps m left outer join Users u on 
                    m.VolunteerId = u.Id 
            left outer join Requests r on 
                    m.VolunteerId = r.UserId

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
                while($row = $result->fetch_array())
                {
                    $matchups [] =  AddSlot($row);
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

