<?php
get_header(); ?>
    <div class="wrap">
        <div id="primary" class="content-area 1102">
            <main id="main" class="site-main">
                <?php
                while (have_posts()) : the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">

                            <header class="entry-header">
                                <?php the_title('<h2 class="entry-title">', '</h2>'); ?>
                            </header><!-- .entry-header -->

                            <?php
                            the_content();

                            wp_link_pages(array(
                                'before'      => '<div class="page-links">' . esc_html__('Pages:', 'gifymo'),
                                'after'       => '</div>',
                                'link_before' => '<span class="page-number">',
                                'link_after'  => '</span>',
                            ));
                            ?>
                        </div><!-- .entry-content -->
                    </article><!-- #post-## -->
                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                endwhile; // End of the loop.
                ?>
            </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div><!-- .wrap -->
<?php get_footer();
