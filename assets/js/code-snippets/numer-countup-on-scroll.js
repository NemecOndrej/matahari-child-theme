/*ěščřžýáíéúů*/

function initNumberCounting()
{
    /// <summary>
    /// Number counting on scroll.
    /// </summary>

    // init elements with value for counting
    $("strong.counter").each(function ()
    {
        var value = parseFloat($(this).text().replace(" ", "").replace(",", "."));
        $(this).attr("data-maxvalue", value);
        $(this).text("0");
    });

    $(window).scroll(function ()
    {
        $("strong.counter").each(function ()
        {
            var maxvalue = parseFloat($(this).attr("data-maxvalue"));

            var oTop = $(this).offset().top - window.innerHeight;
            if ($(window).scrollTop() > oTop && parseInt($(this).text().replace(" ", "")) != maxvalue)
            {
                $(this).animate({
                    countNum: maxvalue
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function ()
                    {
                        if (this.countNum != null)
                        {
                            var num = this.countNum;
                            if ($(this).attr("data-maxvalue").indexOf(".") > 0)
                            {
                                num = Math.floor(this.countNum * 10);
                                num = num / 10;
                            }
                            else
                            {
                                num = Math.floor(this.countNum);
                            }
                            $(this).text(num.toString().replace(".", ",")); // $(this).text(num.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1 '));
                        }
                    },
                    complete: function ()
                    {
                        var num = this.countNum;
                        if ($(this).attr("data-maxvalue").indexOf(".") > 0)
                        {
                            num = Math.floor(this.countNum * 10);
                            num = num / 10;
                        }
                        else
                        {
                            num = Math.floor(this.countNum);
                        }
                        $(this).text(num.toString().replace(".", ",")); // $(this).text(num.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1 '));
                        //alert('finished');
                    }

                });
            }

        });
    });
    $(window).scroll();
}