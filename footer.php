<?php /*ěščřžýáíéúů*/
?>

</main>

<?php ob_start(); ?>
<footer class="site-footer container">
    <div class="site-footer__col-left">
        <div class="site-footer__col-left-content">
            <h3>NEWSLETTER</h3>
            <p class="dt-5">Sign up for our newsletter and receive exclusive travel deals. Join us today!</p>
            <input type="text" class="newsletter" placeholder="Email Address">
            <a href="#" class="btn-newsletter">Send</a>
        </div>
    </div>
    <div class="site-footer__col-right">
        <div class="site-footer__col-right-logo">
            <?php Theme::print_image('300', 'fullsize') ?>
        </div>
        <div class="site-footer__col-right-links">
            <a href="#">
                <h5>Homepage</h5>
            </a>
            <a href="#">
                <h5>About Us</h5>
            </a>
            <a href="#">
                <h5>Gallery</h5>
            </a>
            <a href="#">
                <h5>Team</h5>
            </a>
        </div>
        <div class="site-footer__col-right-social">
            <a href="">
                <?php Theme::print_image('314', 'fullsize') ?>
            </a>
            <a href="">
                <?php Theme::print_image('312', 'fullsize') ?>
            </a>
            <a href="">
                <?php Theme::print_image('313', 'fullsize') ?>
            </a>
        </div>

        <div class="site-footer__col-right-copywrite">
            <p class="dt-4">Copyright © 2023 Matahari. All rights reserved.</p>
            <p class="dt-4"><a href="">Privacy Policy</a> | <a href="">Terms & Condition</a></p>
        </div>
    </div>
    <?php
    wp_nav_menu(array(
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
    ));
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