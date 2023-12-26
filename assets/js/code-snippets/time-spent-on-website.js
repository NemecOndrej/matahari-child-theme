/*ěščřžýáíéúů*/

// script to measure time spent by user over the whole website

var spentTime = {
    timer: null,
    timerStart: null,
    time: null
};

function getTimeSpentOnSite(){
    spentTime.time = parseInt(localStorage.getItem('timeSpentOnSite'));
    spentTime.time = isNaN(spentTime.time) ? 0 : spentTime.time;
    return spentTime.time;
}

function startCountingTimeSpentOnSite(){
    spentTime.time = getTimeSpentOnSite();
    spentTime.timerStart = Date.now();
    spentTime.timer = setInterval(function() {
        spentTime.time = getTimeSpentOnSite() + (Date.now() - spentTime.timerStart);
        localStorage.setItem('timeSpentOnSite', spentTime.time);
        spentTime.timerStart = parseInt(Date.now());

        // Convert to seconds and write to console
        console.log(parseInt(spentTime.time / 1000));
    }, 1000);
}
startCountingTimeSpentOnSite();