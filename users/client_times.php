<!DOCTYPE html >

<html>
    <head>

    <?php
        include '../includes/constant/config.inc.php';
        secure_page();
    ?>

       <title>Request Assistance</title>
        <style>
            #selected
            {
                background-color:blue;
            }
            table
            {
                border-collapse:collapse;
                border:1px solid #FF0000;
            }

            table td
            {
                border:0.1em solid #000000;
                width:10em;
            }
            
            table tr
            {
                height:8em;
            }

            table th
            {
                border:0.1em solid #000000;
                width 10em;
            }

            .slot
            {

            }
            .hover
            {
            }
            .hiddenTime
            {
                visibility:hidden;
                height: 0px;
            }
            .selected
            {
                background-color:green;
            }
            .hiddenDay
            {
                visibility:hidden;
                height:0px;
            }
        </style>

        <script src="<?php echo JS?>/jquery-1.10.2.js"></script>
        <script>

                                

            function buildColumn(dayName, day, index)
            {
                var result = "";
                result +="<td";
                
                if(day[index].client == true)
                {
                    result += " class ='selected' > ";
                    result +=" <p class='hover'> Click to Cancel Request </p>";
                }
                else
                {
                    result += " class ='slot' >";
                    result +=" <p class='hover'> Click to Request a Volunteer for this time</p>";
                }
                result += "<p>" + day[index].volunteer + "</p>";
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
                var clientAPI = "<?php echo SITE_BASE .'/includes/getClientSlots.php' ?>";
                var user = "<?php echo $_SESSION['UserId'] ?>";
                $.getJSON(clientAPI,
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
                    
                    $(".hover").hide();
                    $(".slot").hover(
                        function() 
                        {
                           $(this).children(".hover").show(100);
                        },
                        function()
                        {
                           $(this).children(".hover").hide(100);
                        }
                    );
                    $(".selected").hover(
                        function() 
                        {
                           $(this).children(".hover").show(100);
                        },
                        function()
                        {
                           $(this).children(".hover").hide(100);
                        }
                    );
                    $(".selected").click(function()
                        {
                            var clientAPI = "<?php echo SITE_BASE .'/includes/UpdateClientSlot.php' ?>";
                            var time = $(this).children(".hiddenTime").text();
                            var day = $(this).children(".hiddenDay").text();
                            var user = "<?php echo $_SESSION['UserId'] ?>";
                            $.post(clientAPI , { userid: user, time: time, day: day } ).done(function()
                            {
                                getSlots();
                            });
                        });
                        $(".slot").click(function()
                        {
                            var clientAPI = "<?php echo SITE_BASE .'/includes/UpdateClientSlot.php' ?>";
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
