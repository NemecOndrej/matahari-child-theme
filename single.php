<?php /*ěščřžýáíéúů*/
the_post();
get_header();
?>
<div class="single-post container">
    <div class="single-post__header">
        <h2><?php the_title(); ?></h2>
    </div>
    <div class="single-post__content">
        <?php the_content(); ?>
    </div>
</div>

<?php
get_footer();
?>