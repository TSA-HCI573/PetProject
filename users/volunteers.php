<?php

include_once '../includes/constant/config.inc.php';
secure_page(); ?>

<head>
<title>Volunteer My Services</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/styles/styles.css" />
<link rel="stylesheet" href="../includes/js/jquery-ui.css">
<link rel="stylesheet" href="../includes/styles/volunteer.css">

<script src="<?php echo JS?>/jquery-1.10.2.js"></script>
<script src="<?php echo JS?>/jquery-ui-1.10.4.js"></script>
<script>
    //Form processing function start
    $(function()
    {
        $(".submit").click(function()
        {
            //create three variables to store the data entered into the form
            var startDate = $('#datepicker').val();
            var petType = $('#petType').val();

            if(startDate == "" || petType == "")
            {
                $('.error').fadeIn(2000).show().html(
                    'Please choose a start date and pet type to continue').fadeOut(6000); 
                return false;
            }

            //day / times
            //requested services

            var dogwalking = $('#dogwalking').prop('checked') ? 1:0;
            var grooming = $('#grooming').prop('checked') ? 1:0;
            var administermeds = $('#administermeds').prop('checked') ? 1:0;
            var deliverfood = $('#deliverfood').prop('checked') ? 1:0;
            var transportation = $('#transport').prop('checked') ? 1:0;
            var fostercare = $('#fostercare').prop('checked') ? 1:0;
            var other =$("#other").val();
            //additional comments
            var comments =$("#comments").val();
            //construct the data string ]
            var datastring = "&dogwalking=" + dogwalking + "&grooming=" + grooming + 
                "&administermeds=" + administermeds + "&deliverfood=" + deliverfood + 
                "&transportation=" + transportation + "&fostercare=" + fostercare + 
                "&other=" + other + "&comments=" + comments + "&startDate=" + startDate 
                + "&petType=" + petType;
            /*
            Make the AJAX request. The request is made to $_SERVER['PHP_SELF'], i.e., clients_form.php
            The request is handled by checking for $_POST data -- see line 6
            After the $_POST data is processed, we use the exit() function because we don't need to actually
            show the page as the request is made in the background
            */
            $.ajax(
            {
                type: "POST",
                url: "<?php echo SITE_BASE . "/includes/VolunteerInfo.php" ?>",
                data: datastring,
                success: function()
                {
                    //Show, then hide success msg
                    $('.success').fadeIn(2000).show().html('Volunteer Info Updated. ').fadeOut(6000); 
                    resetForm('form');
                    getVolunteerInfo();
                    $('.error').fadeOut(2000).hide(); //If showing error, fade out
                }
            });
            //return false to prevent reloading page
            return false;
        });
    });
    
    function getVolunteerInfo()
    {
        var volunteerAPI = 
            $.getJSON("<?php echo SITE_BASE . "/includes/VolunteerInfo.php" ?>").done(function(info)
        {
            $('#datepicker').val(info.BeginDate);
            $('#petType').val(info.PetType);
            $('#dogwalking').prop('checked',info.DogWalking ==1);
            $('#grooming').prop('checked', info.Grooming == 1);
            $('#administermeds').prop('checked', info.AdministerMeds == 1);
            $('#transport').prop('checked', info.Transport == 1);
            $('#deliverfood').prop('checked', info.DeliverFood == 1);
            $('#fostercare').prop('checked', info.FosterCare == 1);
            $('#other').val(info.Other);
            $('#comments').val(info.Comments);
        });
    }


    $(function() 
    {
        $( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
        getVolunteerInfo();
    });

    function resetForm(formid) {
    $(':input','#'+formid) .not(':button, :submit, :reset, :hidden') .val('') .removeAttr('checked') .removeAttr('selected');
    }


</script>
<?php include "volunteerJS.php"?>

</head>
<body>
<div id="container">
<div id="headerplaced">
<?php include_once '../includes/constant/nav.inc.php'; ?>
</div>
<div class="content">
<div class="main">

<h1>Volunteer</h1>
<h2>Times/days available</h2>
<p>Click on grid to show the days and times you're available.</p>
<table id='scheduleTable'>
</table>
<span class="success" style="display:none;"></span>
<span class="error" style="display:none;"></span>
<h2>Preferences and requirements </h2>
<form method="post" name="form" id="form">
<table>
<tr><td><label>Start Date</label> </td>
<td><input type="text" id="datepicker" name="datepicker" ></td>
</tr>
<tr>
<td><label>Pet Type</label></td>
<td>
<select name="petType" id="petType">
<option VALUE"" selected="selected"></option>
<option name="petType" id="petType"VALUE="Dog"> Dog </option>
<option VALUE="Cat"> Cat </option>
<option VALUE="Bird"> Bird </option>
<option VALUE="Other"> Other </option>
</select> </td>
</tr>
</table><br/>
<table>
<tr>Services Provided</tr>
<tr>
<td><input type="checkbox" id="dogwalking" name="dogwalking" value="True">
<label for="dogwalking">Dog Walking</label>
</td>
<td><input type="checkbox" id="grooming" name="grooming" value="True">
<label for="grooming">Grooming</label></td>
<td><input type="checkbox" id="administermeds" name="administermeds" value="True">
<label for="administermeds">Administer Meds</label></td>
</tr>
<tr>
<td><input type="checkbox" id="transport" name="transport" value="True">
<label for="transport">Transportation</label></td>
<td ><input type="checkbox" id="deliverfood" name="deliverfood" value="True">
<label for="deliverfood">Deliver Food</label></td>
<td><input type="checkbox" id="fostercare" name="fostercare" value="True">
<label for="fostercare">Foster Care</label></td>
</tr>
</table>
<table>
<tr>
<td valign="top">
<label for="OtherChk">Other</label></td>
<td width="350" valign="top">
<textarea name="other" id="other" rows="3" style="width:100%" maxlength="200"></textarea>
</td>

</tr>
</table><br/>
<table>
<tr><label>Additional Comments</label></tr>
</table>
<tr>
<textarea name="comments" id="comments" rows="5" style="width:73%" maxlength="300"></textarea>
</tr>
</table>
<p><button type="submit" class="submit" value="insert">Volunteer</button></p>
</form>
<p>
</p>
</div>
</div>
<div id="footer">
<?php include '../includes/constant/footer.inc.php'; ?>
</div>
</div>
</body>
</html>
