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
    result += "<td class='labelColumn' >" + days.Sunday[index].time +"</td>";
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

