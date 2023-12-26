/*ěščřžýáíéúů*/

function initCountdowns()
{
    if ($("[data-countdown]").length == 0) return;

    window.setInterval(function() {
        $("[data-countdown]").each(function() {
            var rest = getTimeRemaining($(this).attr("data-countdown"));
            
            if (rest.total <= 0)
            {
                window.location = window.location.toString();
            }
            else
            {
                var text = "";
                if (rest.days > 0)
                {
                    text += rest.days + " ";

                    switch (parseInt(rest.days))
                    {
                        case 1:
                            text += "den";
                            break;
                        case 2:
                        case 3:
                        case 4:
                            text += "dny";
                            break;
                        default:
                            text += "dní";
                            break;
                    }

                    text += " ";
                }

                text += (rest.hours < 10 ? "0" : "") + rest.hours.toString() + ":";
                text += (rest.minutes < 10 ? "0" : "") + rest.minutes.toString() + ":";
                text += (rest.seconds < 10 ? "0" : "") + rest.seconds.toString();

                /*if (rest.days <= 0 && rest.hours <= 0 && rest.minutes <= 0)
                {
                    // countdown seconds
                    text = "0:" + (rest.seconds < 10 ? "0" : "") + rest.seconds;
                }
                else
                {
                    // countdown hours / minutes / seconds
                    if (rest.hours > 0) text += rest.hours + " hod. ";
                    if (rest.minutes > 0) text += rest.minutes + " min. ";
                    text += rest.seconds + " sek.";
                }*/

                $(this).text(text);
            }
        });
    }, 1000);
}

function getTimeRemaining(endtime)
{
    /// <summary>
    /// Get remaining time to some date and time.
    /// </summary>

    var endDate = endtime.split(" ");
    var date = endDate[0].split("-");
    var time = endDate[1].split(":");
    endDate = new Date(parseInt(date[0]), parseInt(date[1]) - 1, parseInt(date[2]), parseInt(time[0]), parseInt(time[1]), parseInt(time[2]));
    endDate = endDate.getTime();

    const total = endDate - Date.parse(new Date());//Date.parse(endtime) - Date.parse(new Date());
    const seconds = Math.floor((total / 1000) % 60);
    const minutes = Math.floor((total / 1000 / 60) % 60);
    const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
    const days = Math.floor(total / (1000 * 60 * 60 * 24));

    return {
        total: total,
        days: days,
        hours: hours,
        minutes: minutes,
        seconds: seconds
    };
}