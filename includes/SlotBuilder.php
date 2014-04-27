<?php
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
        if($s['Transport'] ==1)
        {
            $services[] = "Transportation";
        }
        if($s['Other'] != "")
        {
            $services[] = $s['Other'];
        }

        return $services;
    }

?>

