<?php
get_header(); ?>
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <?php
                if (have_posts()) :

                    /* Start the Loop */
                    while (have_posts()) : the_post();

                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part('template-parts/post/content', get_post_format());

                    endwhile;

                    the_posts_pagination(array(
                        'prev_text'          => '<span class="opal-icon-angle-left"></span><span>' . esc_html__('Previous', 'gifymo') . '</span>',
                        'next_text'          => '<span>' . esc_html__('Next', 'gifymo') . '</span><span class="opal-icon-angle-right"></span>',
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__('Page', 'gifymo') . ' </span>',
                    ));

                else :

                    get_template_part('template-parts/post/content', 'none');

                endif;
                ?>

            </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div><!-- .wrap -->

<?php get_footer();
