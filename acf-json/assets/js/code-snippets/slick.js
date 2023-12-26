/*ěščřžýáíéúů*/

// slider TEMPLATE
var $list = $("#XXXX .slider");
$list.append('<a href="#" class="arrow prev" title="Předchozí"></a>');
$list.append('<a href="#" class="arrow next" title="Další"></a>');
var $prev = $list.find("a.arrow.prev");
var $next = $list.find("a.arrow.next");
$list.slick({
    slide: 'div',
    fade: false,
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    prevArrow: $prev,
    nextArrow: $next,
    dots: true,
    appendDots: $("#XXX .center"),
    autoplay: true,
    autoplaySpeed: 5000,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ]
});