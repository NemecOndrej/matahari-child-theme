/*ěščřžýáíéúů*/

function initBackgrounds()
{
    // background images - load instantly
    /*$("[data-background]").each(function ()
    {
        var bg = $(this).attr("data-background");
        if (bg.length > 0)
        {
            $(this).css("background-image", "url(" + bg + ")");
        }
    });*/
	
    // background images - lazy loading
	// SOLUTION: html attribute data-background="image url"
    $(window).scroll(function() {
        $("[data-background]").each(function ()
        {
            // preload more when sroll started
            var more = $(window).scrollTop() > 0 ? 100 : 0;

            if ($(this).attr("data-background-loaded") == null && $(window).scrollTop() > $(this).offset().top - $(this).height() - $(window).height() - more)
            {
                var bg = $(this).attr("data-background");
                if (bg.length > 0)
                {
                    $(this).css("background-image", "url('" + bg + "')");
                    $(this).removeAttr("data-background");
                }
                $(this).attr("data-background-loaded", "1");
            }
        });
    });
    $(window).scroll();

    // background images - lazy loading
    // SOLUTION: background image is set in CSS file, html attribute data-lazyload-bg is used for elements with lazy loading
	// ADD TO CSS: [data-lazyload-bg] { background-image: none !important; }
    $(window).scroll(function() {
        $("[data-lazyload-bg]").each(function ()
        {
            // preload more when sroll started
            var more = $(window).scrollTop() > 0 ? 100 : 0;

            if ($(window).scrollTop() > $(this).offset().top - $(this).height() - $(window).height() - more)
            {
                $(this).removeAttr('data-lazyload-bg');
            }
        });
    });
    $(window).scroll();
}

