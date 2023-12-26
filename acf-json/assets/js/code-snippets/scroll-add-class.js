/*ěščřžýáíéúů*/

// Add / remove class on scroll
function scrollRevealing()
{
    $window.on('scroll', revealOnScroll);

    function revealOnScroll()
    {
        var scrolled = $window.scrollTop(),
            win_height_padded = $window.height() * 1.1;

        // Showed...
        $(".revealOnScroll:not(.animated)").each(function ()
        {
            var $this = $(this),
                offsetTop = $this.offset().top + 50;

            if (scrolled + win_height_padded > offsetTop)
            {
                if ($this.data('timeout'))
                {
                    window.setTimeout(function ()
                    {
                        $this.addClass('animated');
                    }, parseInt($this.data('timeout'), 10));
                } else
                {
                    $this.addClass('animated');
                }
            }
        });
        // Hidden...
        $(".revealOnScroll.animated").each(function (index)
        {
            var $this = $(this),
                offsetTop = $this.offset().top + 300;
            if (scrolled + win_height_padded < offsetTop)
            {
                $(this).removeClass('animated');
            }
        });
    }

    revealOnScroll();
}