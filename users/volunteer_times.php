<!DOCTYPE html >

<html>
    <head>

    <?php
        include '../includes/constant/config.inc.php';
        secure_page();
    ?>

       <title>Post Volunteer Availability</title>
        <style>
            #selected
            {
                background-color:blue;
            }
            table
            {
                border-collapse:collapse;
                border:1px solid #AAAAAA;
            }

            table td
            {
                border:0.1em solid #AAAAAA;
                color:#dd6b05;
                width:10em;
                background:white
            }
            
            table tr
            {
                height:10em;
            }

            table th
            {
                border:0.1em solid #AAAAAA;
                color:#dd6b05;
                background:white;
                width 10em;
            }

            .slot
            {
                opacity: 0.5;
                background:#BFE54B;
                color:black;
            }
            .hover
            {
            }
            .hiddenTime
            {
                visibility:hidden;
                height: 0px;
            }
            .client
            {
                background:#dd6b05;
                color:white;
                border-radius:0.2em;
                margin: 0.3em;
            }
            .selected
            {
                color: white;
                background:#8CB217;
                opacity: 1.0;
            }
            .hiddenDay
            {
                visibility:hidden;
                height:0px;
            }
        </style>

        <script src="<?php echo JS?>/jquery-1.10.2.js"></script>
        <!--<script src="<?php echo JS?>/jquery-ui-1.7.2.custom.min.js"></script>-->
        <script src="<?php echo JS?>/jquery.approach.min.js"></script>
        <script>

                                

            function buildColumn(dayName, day, index)
            {
                var result = "";
                result +="<td";
                
                if(day[index].volunteer == true)
                {
                    result += " class ='selected' > ";
                    result +=" <p class='hover'> Click to Cancel</p>";
                }
                else
                {
                    result += " class ='slot' >";
                    result +=" <p class='hover'>Click here post availability for this time</p>";
                }
                result += "<p class='client'>" + day[index].client + "</p>";
                result += "<p class='hiddenTime'>"+day[index].time +"</p>";
                result += "<p class='hiddenDay'>"+dayName+"</td>";
                return result;
            }
            function buildRow(days, index)
            {
                var result = "";
                result += "<tr>";
                result += "<td>" + days.Sunday[index].time +"</td>";
                result += buildColumn('Sunday',days.Sunday, index);
                result += buildColumn('Monday',days.Monday, index);
                result += buildColumn('Tuesday',days.Tuesday, index);
                result += buildColumn('Wednesday',days.Wednesday, index);
                result += buildColumn('Thursday',days.Thursday, index);
                result += buildColumn('Friday', days.Friday, index);
                result += buildColumn('Saturday',days.Saturday, index);
                result += "</tr>";
                return result;

            }
            
            
            function getSlots()
            {
                var volunteerAPI = "<?php echo SITE_BASE .'/includes/getVolunteerSlots.php' ?>";
                var user = "<?php echo $_SESSION['UserId'] ?>";
                $.getJSON(volunteerAPI,
                {
                    userid: user 
                }).done(function(days)
                {
                    $("#scheduleTable").html(
                        "<tr>"
                        +"<th></th>"
                        +"<th>Sunday</th>" 
                        +"<th>Monday</th>" 
                        +"<th>Tuesday</th>"
                        +"<th>Wednesday</th>"
                        +"<th>Thursday</th>"
                        +"<th>Friday</th>"
                        +"<th>Saturday</th>"
                        +"</tr>");

                    $.each(days.Monday, function(i, item)
                    {
                        $("#scheduleTable").append(buildRow(days,i));
                    });
                    
                    $(".slot").approach(
                    {
                            "opacity": 1.0 
                    }, 200);                    
                    $(".selected").approach(
                    {
                        "opacity": 0.8 
                    }, 200);                    
                    $(".selected").click(function()
                    {
                        var volunteerAPI = "<?php echo SITE_BASE .'/includes/UpdateVolunteerSlot.php' ?>";
                        var time = $(this).children(".hiddenTime").text();
                        var day = $(this).children(".hiddenDay").text();
                        var user = "<?php echo $_SESSION['UserId'] ?>";
                        $.post(volunteerAPI , { userid: user, time: time, day: day } ).done(function()
                        {
                            getSlots();
                        });
                    });
                    $(".slot").click(function()
                    {
                        var clientAPI = "<?php echo SITE_BASE .'/includes/UpdateVolunteerSlot.php' ?>";
                        var time = $(this).children(".hiddenTime").text();
                        var day = $(this).children(".hiddenDay").text();
                        var user = "<?php echo $_SESSION['UserId'] ?>";
                        $.post(clientAPI , { userid: user, time: time, day: day } ).done(function()
                        {
                            getSlots();
                        });
                    });

                });
            }
            $(document).ready(function()
                {
                    getSlots();
               });
        </script> 
    </head>

    <body>
        <table id='scheduleTable'>
        </table>
    </body>
</html>
