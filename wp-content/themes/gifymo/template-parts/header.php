<div class="site-header">
    <?php
    if (gifymo_is_header_builder()) { ?>
        <div class="container">
            <?php gifymo_the_header_builder(); ?>
        </div>
    <?php } else {
        $container = get_theme_mod('osf_header_width', true) ? 'container1' : 'container-fluid';
        ?>
        <div id="opal-header-content" class="header-content osf-sticky-active">
            <div class="custom-header container">
                <div class="header-main-content d-flex flex-wrap align-items-center justify-content-between">
                    <?php get_template_part('template-parts/header/site', 'branding'); ?>

                    <?php if (has_nav_menu('top')) : ?>
                        <div class="navigation-top text-center">
                            <?php get_template_part('template-parts/header/navigation'); ?>
                        </div><!-- .navigation-top -->
                    <?php endif; ?>

                </div>
            </div>

        </div>
        <?php
    }
    ?>
</div>
