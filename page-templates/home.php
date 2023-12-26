<?php /*ěščřžýáíéúů*/
/*
Template Name: Homepage
Template Post Type: page, post
*/

the_post();
get_header();
?>

<section class="hero-section container">
    <div class="hero-section__col-left">
        <div class="hero-section__col-left-text">
            <div class="text-one">
                <h6>Surf School</h6>
                <h2>Matahari</h2>
            </div>
            <div class="text-two">
                <h6>& Camp</h6>
                <h2>Canggu Bali</h2>
            </div>
        </div>
    </div>
    <div class="hero-section__col-right">
        <div class="hero-section__col-right-second-box">
            <div class="box-gradient"></div>
            <div class="box-content">
                <div class="box-content__text">
                    <p class="subtitle">Watch Our</p>
                    <p class="subheader">Profile Video</p>
                </div>
                <div class="box-content__icon-play">
                    <a href="#"><?php Theme::read_svg(THEME_PATH . "/assets/images/play-button.svg") ?></a>
                </div>
            </div>
        </div>
        <div class="hero-section__col-right-third-box"></div>
    </div>
</section>


<?php
get_footer();
?>