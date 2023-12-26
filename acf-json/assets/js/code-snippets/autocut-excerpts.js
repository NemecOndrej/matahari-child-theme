/*ěščřžýáíéúů*/

var optimizingExcerpts = false;
function optimizeArticlesExcerpt()
{
    $("article").each(function() {
        if ($(this).find(".headerExcerpt").length > 0)
        {
            $(this).find(".headerExcerpt .h").attr("data-text", $(this).find(".headerExcerpt .h span").text());
            $(this).find(".headerExcerpt p").attr("data-text", $(this).find(".headerExcerpt p").text());
        }
    });

    $(window).resize(function() {
        if (optimizingExcerpts) return;

        optimizingExcerpts = true;

        $("article").each(function() {
            if ($(this).find(".headerExcerpt").length > 0)
            {
                var $holder = $(this).find(".headerExcerpt");
                var $h = $(this).find(".h");
                var $p = $(this).find("p");
                var text = $p.attr("data-text");
                $p.text(text);

                if ($holder.height() - $h.outerHeight() > 20 && text.length > 0 && text.indexOf(" ") > 0)
                {
                    var runs = 1;
                    while ($h.outerHeight() + $p.outerHeight() > $holder.height())
                    {
                        text = text.split(" ");
                        text.pop();
                        text = text.join(" ");
                        $p.text(text + "...");

                        runs++;
                        if (runs > 150) break;
                    }
                }

                if ($(this).hasClass("shortHeader"))
                {
                    var $hContent = $h.find("span");
                    text = $h.attr("data-text");
                    $hContent.text(text);

                    var runs = 1;
                    while ($hContent.outerHeight() > $h.height())
                    {
                        text = text.split(" ");
                        text.pop();
                        text = text.join(" ");
                        $hContent.text(text + "...");

                        runs++;
                        if (runs > 30) break;
                    }
                }
            }
        });

        optimizingExcerpts = false;
    });
    $(window).resize();
}