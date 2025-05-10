<?php $post_class = !is_single() ? "archive-post" : ""; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
    <div class="post-inner">

        <?php if (!is_single()) gifymo_post_thumbnail(); ?>

        <header class="entry-header">

            <?php

            if ('post' === get_post_type()) : ?>
                <div class="entry-meta">
                    <?php
                    if (is_single()) {
                        gifymo_entry_meta_single();
                    } else {
                        gifymo_entry_meta();
                    }
                    ?>
                </div><!-- .entry-meta -->
            <?php endif;

            if (is_single()) {
                the_title('<h1 class="entry-title">', '</h1>');
            } elseif (is_front_page() && is_home()) {
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            } else {
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            } ?>

        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php

            $post = get_post($post);
            if (!is_singular() && !empty($post->post_excerpt)) {
                the_excerpt();
            } else {
                the_content(
                    sprintf(
                    /* translators: %s: Post title. */
                        __('<span>%1$s</span><span class="screen-reader-text"> "%2$s"</span> <i class="opal-icon-angle-double-right" aria-hidden="true"></i>', 'gifymo'),
                        esc_html__('Read more', 'gifymo'),
                        get_the_title()
                    )
                );
            }

            wp_link_pages(array(
                'before'      => '<div class="page-links">' . esc_html__('Pages:', 'gifymo'),
                'after'       => '</div>',
                'link_before' => '<span class="page-number">',
                'link_after'  => '</span>',
            ));

            ?>
        </div><!-- .entry-content -->

        <?php if (is_single()) {
            gifymo_entry_footer();
        } ?>

    </div> <!-- #Post-inner -## -->
</article><!-- #post-<?php the_ID(); ?> -->