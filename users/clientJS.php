<script>

function getSlots()
{
    var clientAPI = "<?php echo SITE_BASE .'/includes/getClientSlots.php' ?>";
    var user = "<?php echo $_SESSION['UserId'] ?>";
    $.getJSON(clientAPI,
    {
        userid: user 
    }).done(function(slots)
    {
        buildTable(slots,user);
        applyJQuery();
    });

}

function buildSlotBoxes(slots, day, time, userid)
{
    slotsBoxHtml = "";

    var length = slots.length;
    for(var i =0; i < length; i++)
    {
        var slot = slots[i];
        if(slot.Day == day && slot.Time == time)
        {
            slotsBoxHtml += "<div class=\"volunteer\" ";
            //Begin Tooltip;
            slotsBoxHtml += " title=\"";
            slotsBoxHtml += "<span class='tooltip1'> <p class='tooltipName'>"
            + slot.FirstName + " " + slot.LastName + "</p>" + slot.Address +
            "</span> <span class='tooltip2'> Provides: <br />";  

            for(var j=0; j < slot.Services.length; j++)
            {
                var s = slot.Services[j];
                slotsBoxHtml += "<div class='serviceBlock'>" + s + "</div>";
            }
            slotsBoxHtml +="<strong>For a " + slot.PetType + "</strong>"; 
            slotsBoxHtml += "<br /><br /> Starting On: <br />"
                + slot.StartDate +"</span>";

                
            slotsBoxHtml +="\">"; 
            //End Tooltip

            slotsBoxHtml += "<input type=\"checkbox\" value=\"" + 
                day + "," +time + "," + slot.VolunteerId +"\" ";                    
            if(slot.ClientId ==userid)
            {
                slotsBoxHtml += "checked ";
            }
            slotsBoxHtml += ">";
            
            slotsBoxHtml += slot.FirstName + " <br /> " + slot.LastName; 
            slotsBoxHtml += "</input></div> <br />";
        }
    } 
    return slotsBoxHtml;
}

function buildRow(time, days, slots, userid)
{
    var tableHtml = "";
    tableHtml += "<tr>";
    if(time == "Header")
    {
        tableHtml += "<th></th>";
    }
    else
    {
        tableHtml += "<td>"+time+"</td>";
    }
    
    var length = days.length;
    for(var i =0; i < length; i++)
    {
        if(time == "Header")
        {
            tableHtml += "<th>" + days[i] +"</th>" ;
        }
        else
        {
            tableHtml += "<td class='slot'>";
            tableHtml += buildSlotBoxes(slots,days[i],time,userid);
            tableHtml += "</td>" ;
        }
    }

    tableHtml += "</tr>";
    $('#scheduleTable').append(tableHtml);
}

function buildTable(slots, userid)
{
    var days = new Array( "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday",
        "Friday", "Saturday");
    $('#scheduleTable').html("");
    buildRow("Header", days, slots, userid);
    buildRow("AM", days, slots, userid);
    buildRow("PM", days, slots, userid);

}

function applyJQuery()
{
    $("input:checkbox").change(function() 
    { 
        var checked = false;
        if($(this).is(":checked")) 
        { 
            checked =true; 
        }
        var stringVal = $(this).val();
        var arrayVal = stringVal.split(",");
        var user = "<?php echo $_SESSION['UserId'] ?>";
        var day = arrayVal[0]; 
        var time = arrayVal[1]; 
        var volunteer = arrayVal[2];

        var updateAPI = "<?php echo SITE_BASE .'/includes/UpdateClientSlot.php' ?>";
        $.post(updateAPI,
        {
              userid: user,
              time: time,
              day: day,
              volunteer: volunteer
        }).done(function()
        {
            getSlots();
        });
    }); 

    $(document).tooltip(
    {
        content: function() 
        {
            return $(this).attr('title');
        }
    });

}
$(document).ready(function()
{
    getSlots();
});
</script> 
