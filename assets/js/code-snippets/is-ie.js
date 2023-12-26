/*ěščřžýáíéúů*/

// check if current browser is Internet Explorer
function isIE()
{
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
    {
        var version = parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)));
        return true;
    }

    return false;
}