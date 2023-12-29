<?php /*ěščřžýáíéúů*/
/*
Template Name: Homepage
Template Post Type: page, post
*/

the_post();
get_header();
?>

<section class="promo-section container">
    <div class="promo-section__image">
        <?php Theme::print_image('301', 'fullsize') ?>

        <div class="promo-section__content">
            <div class="promo-section__content-header">
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
    </div>
</section>

<section class="about-us container" id="about-us">
    <div class="about-us__header">
        <h2>About us</h2>
        <p class="text-in-header">Welcome to Matahari</p>
        <p class="dt-2">Surf School & Camp in Canggu, Bali, where your wave adventure begins.</p>
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
                </div>
            </div>
        </div>
    </div>
</section>

<section class="our-values container">
    <div class="our-values__header">
        <h2>Our Values</h2>
        <p class="text-in-header">Values</p>
    </div>
    <div class="our-values__items">
        <div class="our-values__items-box">
            <div class="our-values__items-box-icon" id="happy">
                <?php Theme::read_svg(THEME_PATH . '/assets/images/happy.svg') ?>
            </div>
            <div class="our-values__items-box-content">
                <p class="dt-1">Customer Delight</p>
                <p class="dt-4">We deliver the best service and experience for our customer.</p>
            </div>
        </div>
        <div class="our-values__items-box">
            <div class="our-values__items-box-icon" id="tour">
                <?php Theme::read_svg(THEME_PATH . '/assets/images/tour.svg') ?>
            </div>
            <div class="our-values__items-box-content">
                <p class="dt-1">Expert Guide</p>
                <p class="dt-4">We deliver only expert tour guides for our customer.</p>
            </div>
        </div>
        <div class="our-values__items-box">
            <div class="our-values__items-box-icon" id="time">
                <?php Theme::read_svg(THEME_PATH . '/assets/images/time.svg') ?>
            </div>
            <div class="our-values__items-box-content">
                <p class="dt-1">Time Flexibility</p>
                <p class="dt-4">We welcome time flexibility of traveling for our customer.</p>
            </div>
        </div>
    </div>
</section>

<section class="course container">
    <div class="course__header">
        <h2>Course</h2>
        <p class="text-in-header">Surf</p>
        <p class="dt-2">Learn to surf step by step.</p>
    </div>
    <div class="course__items">
        <div class="course__items-card">
            <div class="course__items-card-image" id="image-1">
                <?php Theme::print_image('302', 'fullsize') ?>
                <div class="gradient"></div>
            </div>
            <div class="course__items-card-text">
                <h5>Private Lesson</h5>
            </div>
            <div class="course__items-card-hover-text">
                <h5>Private Lesson</h5>
                <p class="dt-5">Private one-on-one surf lessons at 560,000 Indonesian Rupiah.</p>
                <div class="course__items-card-hover-buttons">
                    <a href="#" class="btn-primary-white">Book Now</a>
                    <a href="#" class="btn-secondary">Book Now</a>
                </div>
            </div>
        </div>
        <div class="course__items-card">
            <div class="course__items-card-image" id="image-2">
                <?php Theme::print_image('304', 'fullsize') ?>
                <div class="gradient"></div>
            </div>
            <div class="course__items-card-text">
                <h5>Group Lesson</h5>
            </div>
            <div class="course__items-card-hover-text">
                <h5>Group Lesson</h5>
                <p class="dt-5">Join group surf lessons for 450,000 Indonesian Rupiah.</p>
                <div class="course__items-card-hover-buttons">
                    <a href="#" class="btn-primary-white">Book Now</a>
                    <a href="#" class="btn-secondary">Book Now</a>
                </div>
            </div>
        </div>
        <div class="course__items-card">
            <div class="course__items-card-image" id="image-3">
                <?php Theme::print_image('305', 'fullsize') ?>
                <div class="gradient"></div>
            </div>
            <div class="course__items-card-text">
                <h5>Family Lesson</h5>
            </div>
            <div class="course__items-card-hover-text">
                <h5>Family Lesson</h5>
                <p class="dt-5">Family surf lessons for four at Matahari Surf School for 2,000,000 Indonesian Rupiah.</p>
                <div class="course__items-card-hover-buttons">
                    <a href="#" class="btn-primary-white">Book Now</a>
                    <a href="#" class="btn-secondary">Book Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="gallery container" id="gallery">
    <div class="gallery__header">
        <h2>Gallery</h2>
        <p class="text-in-header">Surf</p>
        <p class="dt-2">Discover the beauty of surfing through the lens.</p>
    </div>
    <div class="gallery__content">
        <div class="gallery__content-left">
            <div class="left-image-first">
                <?php Theme::print_image('306', 'fullsize') ?>
            </div>
            <div class="left-image-second">
                <?php Theme::print_image('309', 'fullsize') ?>

            </div>
        </div>
        <div class="gallery__content-center">
            <?php Theme::print_image('308', 'fullsize') ?>

        </div>

        <div class="gallery__content-right">
            <div class="right-image-first">
                <?php Theme::print_image('310', 'fullsize') ?>

            </div>
            <div class="right-image-second">
                <?php Theme::print_image('307', 'fullsize') ?>
            </div>
        </div>
    </div>
    <div class="gallery__site">
        <a href="<?= esc_url('https://www.instagram.com/mataharisurfschool/') ?>" class="btn-site dt-1" target="_blank"><i><?php Theme::print_image('311', 'fullsize') ?></i> Follow us on @mataharisurfschool</a>
    </div>
</section>

<section class="hero-section container" id="blog    ">
    <div class="hero-section__header">
        <h2>News</h2>
        <p class="text-in-header">All</p>
        <p class="dt-2">Latest wave and surf news from around the world.</p>
    </div>
    <div class="hero-section__boxes">
        <div class="swiper hero-section__col-left newsSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <?php Theme::print_image('296', 'fullsize') ?>
                </div>
                <div class="swiper-slide">
                    <?php Theme::print_image('296', 'fullsize') ?>
                </div>
                <div class="swiper-slide">
                    <?php Theme::print_image('296', 'fullsize') ?>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="autoplay-progress">
                <svg viewBox="0 0 48 48">
                    <circle cx="24" cy="24" r="20"></circle>
                </svg>
                <span></span>
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
                <a href="#" class="text-content">
                    <?php Theme::read_svg(THEME_PATH . "/assets/images/plane.svg") ?>
                    <p class="subheader">Let us take you on a journey of discovery, adventure, and relaxation. Book now or contact us for more information.</p>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="asked-question container">
    <div class="asked-question__col-left">
        <div class="asked-question__col-left-header">
            <h3>FREQUENTLY ASKED QUESTION</h3>
        </div>
        <p class="dt-5">What our clients usually asked about our services and tours.</p>
        <div class="dots"></div>
    </div>
    <div class="asked-question__col-right">
        <div class="asked-question__col-right-text">
            <div class="asked-question__col-right-text-content">
                <h5>What type of travel packages does Vacasky offer?</h5>
                <div class="circle">
                    <?php Theme::print_image('315', 'fullsize') ?>
                </div>
            </div>
            <div class="content" style="display: none;">
                Zde bude podrobný obsah odpovědi.
            </div>
        </div>
        <div class="asked-question__col-right-text">
            <div class="asked-question__col-right-text-content">
                <h5>What type of travel packages does Vacasky offer?</h5>
                <div class="circle">
                    <?php Theme::print_image('315', 'fullsize') ?>
                </div>
            </div>
            <div class="content" style="display: none;">
                Zde bude podrobný obsah odpovědi.
            </div>
        </div>
        <div class="asked-question__col-right-text">
            <div class="asked-question__col-right-text-content">
                <h5>What type of travel packages does Vacasky offer?</h5>
                <div class="circle">
                    <?php Theme::print_image('315', 'fullsize') ?>
                </div>
            </div>
            <div class="content" style="display: none;">
                Zde bude podrobný obsah odpovědi.
            </div>
        </div>
        <div class="asked-question__col-right-text">
            <div class="asked-question__col-right-text-content">
                <h5>What type of travel packages does Vacasky offer?</h5>
                <div class="circle">
                    <?php Theme::print_image('315', 'fullsize') ?>
                </div>
            </div>
            <div class="content" style="display: none;">
                Zde bude podrobný obsah odpovědi.
            </div>
        </div>
    </div>

</section>


<?php
get_footer();
?>