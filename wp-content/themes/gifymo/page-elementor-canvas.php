<?php
/**
 * Template Name: Page Opal Elementor Canvas
 */
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="//gmpg.org/xfn/11">
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
    <?php gifymo_wp_body_open(); ?>
        <div id="wptime-plugin-preloader"></div>
        <div class="opal-wrapper">
            <div id="page" class="site">
                <div class="site-content-contain">
                    <div id="content" class="site-content">

                        <div class="wrap">
                            <div id="primary" class="content-area">
                                <main id="main" class="site-main">
                                    <?php
                                    while (have_posts()) : the_post();
                                        the_content();
                                    endwhile; // End of the loop.
                                    ?>
                                </main><!-- #main -->
                            </div><!-- #primary -->
                            <?php get_sidebar(); ?>
                        </div><!-- .wrap -->
                    </div><!-- #content -->
                </div><!-- .site-content-contain -->
            </div><!-- #page -->
            <?php do_action('opal_end_wrapper') ?>
        </div><!-- end.opal-wrapper-->
        <?php wp_footer(); ?>
    </body>
</html>
