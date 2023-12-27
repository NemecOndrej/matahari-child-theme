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
        <?php Theme::print_image('296', 'fullsize') ?>
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
            <?php Theme::print_image('297', 'fullsize') ?>
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
        <div class="hero-section__col-right-third-box">
            <div class="text-content">
                <?php Theme::read_svg(THEME_PATH . "/assets/images/plane.svg") ?>
                <p class="subheader">Let us take you on a journey of discovery, adventure, and relaxation. Book now or contact us for more information.</p>
            </div>
        </div>
    </div>
</section>

<section class="about-us container">
    <div class="about-us__header">
        <h4>About us</h4>
        <p class="dt-2">Welcome to Matahari Surf School & Camp in Canggu, Bali, where your wave adventure begins.</p>
    </div>

    <div class="about-us__content">
        <div class="about-us__content-image">
            <?php Theme::print_image('299', 'fullsize') ?>
        </div>
        <div class="about-us__content-right">
            <div class="about-us__content-right-image">
                <?php Theme::print_image('298', 'fullsize') ?>
            </div>
            <div class="header-description">
                <div class="text-col-left">
                    <h3>SURFERS PARADISE</h3>
                </div>
                <div class="text-col-right">
                    <p class="dt-3">At Matahari Surf School, we are passionate about sharing the joy and thrill of surfing with enthusiasts of all levels. Whether you're a beginner looking to catch your first wave or an experienced surfer seeking to improve your skills, our dedicated team of instructors is here to guide you on your surfing journey.</p>
                    <a href="#" class="btn-primary">Book Now</a>
                </div>
            </div>
        </div>
    </div>

</section>


<?php
get_footer();
?>