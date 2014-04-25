<?php

include_once 'constant/config.inc.php';
secure_page();

$userId = $_SESSION['UserId'];
$selectSql = "select * from " . VOLUNTEERS . " where UserId = $userId ;";
//Check for post data

if($_POST)
{
    //Assign variables and sanitize POST data
    $startDate = mysql_real_escape_string($_POST['startDate']);

    $petType = mysql_real_escape_string($_POST['petType']);	

    $dogwalking = mysql_real_escape_string($_POST['dogwalking']);
    $grooming = mysql_real_escape_string($_POST['grooming']);
    $administermeds = mysql_real_escape_string($_POST['administermeds']);
    $deliverfood = mysql_real_escape_string($_POST['deliverfood']);
    $transportation = mysql_real_escape_string($_POST['transportation']);
    $fostercare = mysql_real_escape_string($_POST['fostercare']);
    $other = mysql_real_escape_string($_POST['other']);
    $comments = mysql_real_escape_string($_POST['comments']);
    //check if user is in table

    $result = mysql_query($selectSql);

    if(mysql_num_rows($result) > 0)
    {
        // update current volunteer entry
        $sql = "update " . VOLUNTEERS . " 
            set UserId = $userId, 
            BeginDate = date('$startDate'), 
            PetType = '$petType',
            dogwalking = '$dogwalking',
            grooming = '$grooming',
            administermeds = '$administermeds',
            deliverfood = '$deliverfood',
            transport = '$transportation',
            fostercare = '$fostercare',
            other = '$other',
            comments = '$comments';";
        mysql_query($sql) 
            or die(mysql_error());
            
    }
    else
    {
        //insert new Voluneteer record
        $sql ="
            INSERT INTO ". VOLUNTEERS . " (
                UserId, 
                BeginDate, 
                PetType,
                dogwalking, 
                grooming, 
                administermeds, 
                deliverfood, 
                transport, 
                fostercare, 
                other, 
                comments )
            VALUES (
                $userId, 
                date('$startDate') , 
                '$petType', 
                '$dogwalking', 
                '$grooming',
                '$administermeds',
                '$deliverfood', 
                '$transportation', 
                '$fostercare',
                '$other', 
                '$comments');";
        mysql_query($sql) 
            or die(mysql_error());
    }
}
else
{
    $result = mysql_query($selectSql);
    $resultObject = mysql_fetch_object($result);
    echo json_encode($resultObject);
}



function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

?> 
