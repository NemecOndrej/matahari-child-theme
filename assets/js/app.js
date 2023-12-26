/*ěščřžýáíéúů*/

const cssVars = () => {
    const doc = document.documentElement
    doc.style.setProperty('--site-header-height', ($(".site-header").innerHeight())+'px');
    if($("#wpadminbar").length) {
        doc.style.setProperty('--adminbar-height', ($("#wpadminbar").innerHeight())+'px');
    }else {
        doc.style.setProperty('--adminbar-height', '0px');
    }
}
window.addEventListener('resize', cssVars);
cssVars();

var fancyboxCS = {
    cs: {
        CLOSE: "Zavřít",
        NEXT: "Další",
        PREV: "Přechozí",
        ERROR: "Požadovaný obsah se nepodařilo načíst. <br/>Pokuste se o to prosím později.",
        PLAY_START: "Spustit slideshow",
        PLAY_STOP: "Pozastavit slideshow",
        FULL_SCREEN: "Celá obrazovka",
        THUMBS: "Náhledy",
        DOWNLOAD: "Stáhnout",
        SHARE: "Sdílet",
        ZOOM: "Zvětšit"
    }
};

jQuery(document).ready(function ($) {
    window.$root = $('html, body');

    // iCheck
    $("input[type='radio'], input[type='checkbox']").iCheck({

    });

    // Gravity forms
    // - action when form loaded (e.g. on page load, after submit attempt)
    // $(document).on('gform_post_render', function(event, form_id, current_page){

    //     // iCheck
    //     $("input[type='radio'], input[type='checkbox']").iCheck({});

    //     // iCheck consent click icheck fix
    //     $('.gfield--type-consent .icheckbox').on('click',function(){ jQuery(this).siblings('.gfield_consent_label').trigger('click'); });

    //     // Add class to form when submitting
    //     $('#gform_'+form_id).submit(function(){
    //         $('#gform_'+form_id).addClass('loading');
    //     });
    // });
    // - action when form successfully submitted
    // $(document).on('gform_confirmation_loaded', function(event, formId){});

    $.fancybox.defaults.hash = false;
    $.fancybox.defaults.loop = true;
    // fancybox images inside text content
    $("#textPage a").filter(function () {
        return $(this).attr("href").match(/\.(jpg|jpeg|gif|png|bmp)$/i);
    }).fancybox({
        lang: "cs",
        i18n: fancyboxCS
    });

    // fancyboxes
    $(".fancybox").fancybox({
        lang: "cs",
        i18n: fancyboxCS
    });

    // manage animated scrolling
    $("body").on("click", "[data-scrollto]", function (e) {
        e.preventDefault();

        var $target = $($(this).attr("data-scrollto"));
        var minus = $(this).attr("data-scrollto-minus");
        if (minus == null) minus = 0;

        animateScroll($target, minus);

        return false;
    });

    // animated scroll for anchor links
    $("a[href^='#']").click(function(e) {
        e.preventDefault();

        if ($(this).attr("href") != "#") {
            var $elem = $($(this).attr("href"));
            if ($elem.length > 0) {
                animateScroll($elem, $("header").height());
                return false;
            }
        }
        
        return true;
    });

    $(".header__search-form").submit(function (e) { 
        if($(this).hasClass("active")) { //formulář je otevřený
            if($(this).find("input").val() == "") {
                e.preventDefault();
                $(this).removeClass("active");
            }
        } else {
            e.preventDefault();
            $(this).addClass("active");
        }
    });

    $(".header__menu-btn").click(function (e) { 
        e.preventDefault();
        if( $("header.header nav.menu-primary").hasClass("active")) {
            $(this).removeClass("active");
            $("header.header nav.menu-primary").removeClass("active");
        } else {
            $(this).addClass("active");
            $("header.header nav.menu-primary").addClass("active");
        }
    });

    // mobile menu
    $("#mobileMenu").click(function (e) {
        e.preventDefault();

        if ($("header").hasClass("withMenu")) {
            $("header").removeClass("withMenu");
            $("body,html").removeClass("withMenu");
            $(this).removeClass("is-active");
        }
        else {
            $("header").addClass("withMenu");
            $("body,html").addClass("withMenu");
            $(this).addClass("is-active");
        }

        return false;
    });
    $("header .menu li.current-menu-parent").addClass("opened");
    $("header .menu li.menu-item-has-children").append('<span></span>');
    $("header .menu span").click(function () {
        if ($(this).parent().hasClass("opened")) {
            $(this).parent().removeClass("opened");
        }
        else {
            $(this).parent().addClass("opened");
        }
    });
    //$("#mobileMenu").click();

    $(".site-header__search button").click(function (e) { 
        if($(".site-header__search").hasClass("active")) {
            if($(".site-header__search input[name='s']").val() == "") {
                e.preventDefault();
                $(".site-header__search").removeClass("active")
            }
        }else {
            e.preventDefault();
            $(".site-header__search").addClass("active")
        }

    });

    // page scrolled - adjust header
    $(window).scroll(function ()
    {
        if ($(window).scrollTop() > 20)
        {
            if (!$("header").hasClass("scrolled")) $("header").addClass("scrolled");
        }
        else
        {
            $("header").removeClass("scrolled");
        }
    });
    $(window).scroll();

    // Window is loaded or resized
    $(window).on('load resize', function(){
        // Wait until basic transitions ends
        setTimeout(() => {
            // equalizer
            multiEqualizer();
        }, 200);
    });

    // background images
    initBackgrounds();

    // Equalizer right when document loaded
    multiEqualizer();
});

function initBackgrounds()
{
    // background images
    $("[data-background]").each(function ()
    {
        var bg = $(this).attr("data-background");
        if (bg.length > 0)
        {
            $(this).css("background-image", "url(" + bg + ")");
        }
    });
}

function animateScroll($target, minus)
{
    /// <summary>
    /// Animated scrolling.
    /// </summary>
    /// <param name="$target" type="element">jQuery element to scroll to.</param>
    /// <param name="minus" type="int">Amount of pixels to decrease the position.</param>

    if (minus == null) minus = 0;

    $root.animate({
        scrollTop: $target.offset().top - minus
    }, 500);
}

// This function initializes multiequalizer

// - container: data-equal="key1,key2", data-equal-on="640"

// - items: data-equal-watch="key1", data-equal-watch="key2"

function multiEqualizer() {

	$("[data-equal]").each(function(){
		var $parent = $(this),
			types = $parent.attr('data-equal').split(","),
			equalOn = $parent.attr('data-equal-on'),
			equalInRow = String($parent.attr('data-equal-in-row')).toLowerCase();

		if(typeof equalOn == 'undefined' || window.innerWidth>=parseInt(equalOn)) {
			$.each(types,function(i,e){
				// Equalize in row
				if ( equalInRow === 'true' || equalInRow === '1' ) {
					// Current item position from top
					let rowPosY = 0;
					let rows = [],
						rowItems = [],
						rowsH = [];
					var H = 0;

					// Prepare array of items in row
					// Only visible - useful when filtration
					let items = $parent.find("[data-equal-watch="+e+"]:visible");

					items.each(function(){
						let item = $(this),
							itemPosY = item.offset().top;
						if ( itemPosY != rowPosY ) {
							rowPosY = itemPosY;
							// Push only nonempty array (e.g. skip the first)
							if ( rowItems.length > 0 ) {
								rows.push(rowItems);
								rowsH.push(H);
							}

							rowItems = [];
							H = 0;
						}

						var h = $(this).height();
						if( h > H ){ H = h; }
						rowItems.push(item);
					});

					// Add final row
					rows.push(rowItems);
					rowsH.push(H);
					rows.forEach(function(row,i){
						let H = rowsH[i];
						row.forEach(function(item){
							$(item).height(H);
						});
					});

				// Equalize all
				} else {
					var H = 0;
					// Reset the height for proper calculation on resize
					$parent.find("[data-equal-watch="+e+"]").height('auto');
					// Find the highest value
					$parent.find( "[data-equal-watch="+e+"]" ).each(function(){
						var h = $(this).height();
						if( h > H ){ H = h; }
					});

					// Set the highest value to all items
					$parent.find("[data-equal-watch="+e+"]").height(H);

				}
			});

		} else {
			$.each(types,function(i,e){
				$parent.find("[data-equal-watch="+e+"]").height('auto'); // Reset the height
			});
		}

	});
}