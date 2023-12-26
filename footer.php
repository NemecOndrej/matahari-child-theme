<?php /*ěščřžýáíéúů*/
?>

</main>

<?php ob_start(); ?>
<footer class="site-footer">
    <?php
    wp_nav_menu( array(
        'theme_location'  => 'menu-footer',
        'menu'            => '',
        'container'       => '',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => '',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => '',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul>%3$s</ul>',
        'depth'           => 0,
        'walker'          => ''
    ) );
    ?>
</footer>

<script type="text/javascript">
	var formServicesDirectory = '<?= THEME_URI; ?>' + '/services/';
</script>

<?php
$footer = ob_get_clean();
$footer = Theme::strip_spaces_between_tags($footer);
echo $footer;
?>

<?php wp_footer(); ?>

<?php the_field("addedcode_bodyend", "option"); ?>
</body>
</html>