<?php
get_header(); ?>
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <?php if (get_theme_mod('osf_page_404_page_enable') != 'default' && !empty(get_theme_mod('osf_page_404_page_custom'))): ?>
                    <?php $query = new WP_Query('page_id=' . get_theme_mod('osf_page_404_page_custom'));
                    if ($query->have_posts()):
                        while ($query->have_posts()) : $query->the_post();
                            the_content();
                        endwhile;
                    endif; ?>
                <?php else: ?>
                    <section class="error-404 not-found">
                        <div class="page-content">
                            <div class="error-404-content text-center">
                                <h1 class="error-title p-0 m-0">
                                    <span class="screen-reader-text"><?php esc_html_e('404', 'gifymo'); ?></span>
                                </h1>
                                <img src="<?php echo esc_url(get_parent_theme_file_uri('/assets/images/img-404.png')) ?>" title="404">
                                <h2 class="error-subtitle p-0 m-0"><?php esc_html_e('Oops! That link is broken.', 'gifymo'); ?></h2>
                                <div class="error-text">
                                    <span class=""><?php esc_html_e("Page does not exist or some other error occured", 'gifymo') ?></span>
                                    <br/>
                                    <a href="javascript: history.go(-1)"
                                       class="go-back button-dark"><?php esc_html_e('Previous page', 'gifymo'); ?></a>
                                    <a href="<?php echo esc_url(home_url('/')); ?>"
                                       class="return-home button-primary"><?php esc_html_e('Back to home', 'gifymo'); ?></a>
                                </div>
                            </div>
                        </div><!-- .page-content -->
                    </section><!-- .error-404 -->
                <?php endif; ?>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- .wrap -->
<?php get_footer();
