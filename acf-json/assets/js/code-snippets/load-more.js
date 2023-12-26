/*ěščřžýáíéúů*/

// HTML base:
/*
<div class="list">

</div><!-- /.list -->

<div class="loading hidden"></div>

<a href="#" 
    data-loadmore="load-more-posts"
    data-loadmore-count="<?php echo $articles_count; ?>"
    data-category="<?php echo $term_id; ?>"
    class="loadMore">Načíst další</a>
*/

function initLoadMore()
{
    $("a[data-loadmore]").each(function() {
        $(this).click(function(e) {
            e.preventDefault();

            var $link = $(this);
            var $parent = $link.parent();
            var $list = $parent.find(".list");

            // AJAX service name
            var service = $link.attr("data-loadmore");
            
            // ids of existing records (required for randomized lists)
            /*var existingIds = "";
            $list.find("article[data-id]").each(function() {
                existingIds += existingIds.length > 0 ? "," : "";
                existingIds += $(this).attr("data-id");
            });
            $link.attr("data-ids", existingIds);*/

            // current page
            var page = 1;
            if ($link.attr("data-page") != null)
            {
                page = $link.attr("data-page");
            }
            page++;
            $link.attr("data-page", page);

            // collect all data attributes
            var postData = {};
            $.each(this.attributes, function() {
                if (this.specified && this.name.indexOf("data-") == 0)
                {
                    postData[this.name.replace("data-", "")] = this.value;
                }
            });

            // get count of all records
            var totalCount = $(this).attr("data-loadmore-count");
            if (totalCount == null) totalCount = 9999999;

            // show loading
            $link.css("transform", "scale(0)");
            $parent.find("div.loading").removeClass("hidden");

            // load data
            $.ajax({
                url: formServicesDirectory + service + ".php",
                type: "POST",
                dataType: "text",
                cache: false,
                data: postData
            }).done(function (data)
            {
                $parent.find("div.loading").addClass("hidden");

                if (data.length > 0)
                {
                    $list.append(data);
                    
                    initBackgrounds();
                    $link.css("transform", "scale(1)");
                }
                if ($list.children().length == totalCount)
                {
                    $link.hide();
                }
            });

            return false;
        });
    });
}