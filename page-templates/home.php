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
        <?php Theme::print_image('301', 'promo_image', 'fetchpriority=high') ?>
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
            <?php Theme::print_image('299', 'about_image', 'loading=lazy') ?>
        </div>
        <div class="about-us__content-right">
            <div class="about-us__content-right-image">
                <?php Theme::print_image('298', 'about_image', 'loading=lazy') ?>
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

<section class="course container" id="course">
    <div class="course__header">
        <h2>Course</h2>
        <p class="text-in-header">Surf</p>
        <p class="dt-2">Learn to surf step by step.</p>
    </div>
    <div class="course__items">
        <div class="course__items-card">
            <div class="course__items-card-image" id="image-1">
                <?php Theme::print_image('302', 'item_image', 'loading=lazy') ?>
                <div class="gradient"></div>
            </div>
            <div class="course__items-card-text">
                <h5>Private Lesson</h5>
                <div class="hover">
                    <p class="dt-5">Private one-on-one surf lessons at 560,000 Indonesian Rupiah.</p>
                    <div class="course__items-card-hover-buttons">
                        <a href="<?= esc_url(home_url('/private-lesson-2')) ?>" class="btn-secondary">Book Now</a>
                        <a href="#" class="btn-secondary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="course__items-card">
            <div class="course__items-card-image" id="image-2">
                <?php Theme::print_image('304', 'item_image') ?>
                <div class="gradient"></div>
            </div>
            <div class="course__items-card-text">
                <h5>Group Lesson</h5>
                <div class="hover">
                    <p class="dt-5">Join group surf lessons for 450,000 Indonesian Rupiah.</p>
                    <div class="course__items-card-hover-buttons">
                        <a href="<?= esc_url(home_url('/group-lesson')) ?>" class="btn-secondary">Book Now</a>
                        <a href="#" class="btn-secondary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="course__items-card">
            <div class="course__items-card-image" id="image-3">
                <?php Theme::print_image('305', 'item_image') ?>
                <div class="gradient"></div>
            </div>
            <div class="course__items-card-text">
                <h5>Family Lesson</h5>
                <div class="hover">
                    <p class="dt-5">Family surf lessons for four at Matahari Surf School for 2,000,000 Indonesian Rupiah.</p>
                    <div class="course__items-card-hover-buttons">
                        <a href="<?= esc_url(home_url('/family-lesson-2')) ?>" class="btn-secondary">Book Now</a>
                        <a href="#" class="btn-secondary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="gallery container" id="gallery">
    <div class="gallery__header">
        <h2><?= get_field('nadpis_galerie') ?></h2>
        <p class="text-in-header"><?= get_field('subnadpis_galerie') ?></p>
        <p class="dt-2"><?= get_field('popis_galerie') ?></p>
    </div>
    <div class="gallery__content">
        <div class="gallery__content-left">
            <div class="left-image-first">
                <?php
                $image_left_large = get_field('obrazek_vlevo_vetsi');

                if ($image_left_large) {

                    $image_large_url = wp_get_attachment_image_src($image_left_large, 'full')[0];

                    echo '<a href="' . esc_url($image_large_url) . '" data-fancybox="gallery" class="fancybox">';
                    Theme::print_image($image_left_large, 'gallery_image');
                    echo '</a>';
                }

                ?>
            </div>
            <div class="left-image-second">
                <?php
                $image_left_small = get_field('obrazek_vlevo_mensi');

                if ($image_left_small) {

                    $image_small_url = wp_get_attachment_image_src($image_left_small, 'full')[0];

                    echo '<a href="' . esc_url($image_small_url) . '" data-fancybox="gallery" class="fancybox">';
                    Theme::print_image($image_left_small, 'gallery_image');
                    echo '</a>';
                }
                ?>

            </div>
        </div>
        <div class="gallery__content-center">
            <?php
            $image_center = get_field('hlavni_obrazek');

            if ($image_center) {

                $image_center_url = wp_get_attachment_image_src($image_center, 'full')[0];

                echo '<a href="' . esc_url($image_center_url) . '" data-fancybox="gallery" class="fancybox">';
                Theme::print_image($image_center, 'gallery_image');
                echo '</a>';
            }
            ?>
        </div>

        <div class="gallery__content-right">
            <div class="right-image-first">
                <?php

                $image_right_small = get_field('obrazek_vpravo_mensi');

                if ($image_right_small) {

                    $image_right_small_url = wp_get_attachment_image_src($image_right_small, 'full')[0];

                    echo '<a href="' . esc_url($image_right_small_url) . '" data-fancybox="gallery" class="fancybox">';
                    Theme::print_image($image_right_small, 'gallery_image');
                    echo '</a>';
                }
                ?>

            </div>
            <div class="right-image-second">
                <?php

                $image_right_large = get_field('obrazek_vpravo_vetsi');

                if ($image_right_large) {

                    $image_right_large_url = wp_get_attachment_image_src($image_right_large, 'full')[0];

                    echo '<a href="' . esc_url($image_right_large_url) . '" data-fancybox="gallery" class="fancybox">';
                    Theme::print_image($image_right_large, 'gallery_image');
                    echo '</a>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="gallery__site">
        <a href="<?= esc_url('https://www.instagram.com/mataharisurfschool/') ?>" class="btn-site dt-1" target="_blank"><i><?php Theme::read_svg(THEME_PATH . '/assets/images/instagram.svg') ?></i> Follow us on @mataharisurfschool</a>
    </div>
</section>

<section class="hero-section container" id="blog">
    <div class="hero-section__header">
        <h2>News</h2>
        <p class="text-in-header">All</p>
        <p class="dt-2">Latest wave and surf news from around the world.</p>
    </div>

    <?php
    $args = ['post_type' => 'post'];
    $query = new WP_Query($args);
    ?>

    <div class="hero-section__boxes">
        <div class="swiper hero-section__col-left newsSwiper">
            <div class="swiper-wrapper">
                <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                        <a href="<?= get_permalink() ?>" class="swiper-slide news">
                            <div class="gradient-news"></div>
                            <?= $image_id = get_the_post_thumbnail($post->ID); ?>
                            <?php Theme::print_image($image_id, 'hero_boxes_image') ?>
                            <div class="hero-section__col-left-content">
                                <div class="header">
                                    <h4><?php the_title(); ?></h4>
                                </div>
                                <div class="author-date">
                                    <div class="author-icon">
                                        <?php Theme::print_image('300', 'hero_boxes_image') ?>
                                    </div>
                                    <div class="author-content">
                                        <div class="author-name">
                                            <p class="dt-5"><?php the_author(); ?></p>
                                        </div>
                                        <div class="date">
                                            <p class="date-text"><?php the_date('d. F Y'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endwhile ?>
                <?php endif; ?>
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
                <?php Theme::print_image('297', 'hero_boxes_image') ?>
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
        <p class="dt-5">Answers to your most common surfing questions, from lessons to surf trips.</p>
        <div class="dots"></div>
    </div>
    <div class="asked-question__col-right">
        <div class="asked-question__col-right-text">
            <a href="#" type="button" class="asked-question__col-right-text-content">
                <h5>How long does the lesson last?</h5>
                <div class="circle">
                    <?php Theme::print_image('315', 'asked_image') ?>
                </div>
            </a>
            <div class="content">
                Each surf lesson is meticulously planned to last 2 hours, which includes theoretical instructions as well as practical surfing in the water.
            </div>
        </div>
        <div class="asked-question__col-right-text">
            <a href="#" type="button" class="asked-question__col-right-text-content">
                <h5>How do we get to you?</h5>
                <div class="circle">
                    <?php Theme::print_image('315', 'asked_image') ?>
                </div>
            </a>
            <div class="content">
                Our surf school is located at Pantai Batu Bolong, Warung Magic Wave, Canggu, Indonesia, Bali. For detailed directions, please visit our website or contact us directly. The school is easily accessible by public transport or car.
            </div>
        </div>
        <div class="asked-question__col-right-text">
            <a href="#" type="button" class="asked-question__col-right-text-content">
                <h5>What should we bring?</h5>
                <div class="circle">
                    <?php Theme::print_image('315', 'asked_image') ?>
                </div>
            </a>
            <div class="content">
                We recommend bringing swimwear, a towel, sunscreen, and a water bottle. We provide all necessary surfing equipment, including surfboards and wetsuits.
            </div>
        </div>
        <div class="asked-question__col-right-text">
            <a href="#" type="button" class="asked-question__col-right-text-content">
                <h5>What is included in the price of the lesson?</h5>
                <div class="circle">
                    <?php Theme::print_image('315', 'asked_image') ?>
                </div>
            </a>
            <div class="content">
                The lesson price includes professional instruction, surfboard and wetsuit rental, and insurance. Transportation to the surf school is not included in the price.
            </div>
        </div>
    </div>

</section>


<?php
get_footer();
?>