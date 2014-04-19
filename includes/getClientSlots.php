<?php
    include 'constant/config.inc.php';

    function GetAvailableSlots($userId)
    { 
        $sql ="select * from MatchUps where ClientId = null or ClientId = $userId;";
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
                $tempArray = array();
                while($row = $result->fetch_object())
                {
                    $tempArray =$row;
                    array_push($matchups, $tempArray);
                }
                echo json_encode($matchups);
            }


        }
        $con->close();
    }

    
    $userid = $_POST['userid'];
    GetAvailableSlots($userid);

?>

