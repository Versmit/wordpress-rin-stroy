<?php
$prefix      = 'osf_portfolio_';
$category    = get_the_category_list(', ');
$description = osf_get_metabox(get_the_ID(), $prefix . 'description', '');
$client      = osf_get_metabox(get_the_ID(), $prefix . 'client', '');
$date        = osf_get_metabox(get_the_ID(), $prefix . 'date', '');
$website     = osf_get_metabox(get_the_ID(), $prefix . 'website', '');
$location    = osf_get_metabox(get_the_ID(), $prefix . 'location', '');

?>
<section class="widget osf_widget_portfolio_info">
    <div class="osf-portfolio-info">

        <h2 class="osf-portfolio-info-title widget-title">
            <span><?php echo apply_filters('osf-portfolio-info-title', __('Projects Info', 'gifymo')); ?></span>
        </h2>
        <?php if (!empty($description) || !empty($client) || !empty($date) || !empty($website) || !empty($location) || !empty($category)) : ?>
            <div class="osf-event-content">
                <?php
                if (!empty($description)):
                    echo sprintf('<div class="osf-portfolio-description">%s</div>', $description);
                endif;
                ?>

                <ul>
                    <?php

                    if (!empty($client)):
                        echo sprintf(
                            '<li class="osf-portfolio-client"><i class="opal-icon-user"></i><span class="label">%1$s:</span><span class="value">%2$s</span></li>',
                            apply_filters('osf-portfolio-client', __('Client', 'gifymo')),
                            $client
                        );
                    endif;

                    if (!empty($category)):
                        echo sprintf(
                            '<li class="osf-portfolio-category"><i class="opal-icon-bookmark"></i><span class="label">%1$s:</span><span class="value">%2$s</span></li>',
                            apply_filters('osf-portfolio-category', __('Category', 'gifymo')),
                            $category
                        );
                    endif;

                    if (!empty($date)):
                        echo sprintf(
                            '<li class="osf-portfolio-date"><i class="opal-icon-calendar-alt"></i><span class="label">%1$s:</span><span class="value">%2$s</span></li>',
                            apply_filters('osf-portfolio-date', __('Date', 'gifymo')),
                            $date
                        );
                    endif;

                    if (!empty($website)):
                        echo sprintf(
                            '<li class="osf-portfolio-website"><i class="opal-icon-globe"></i><span class="label">%1$s:</span><span class="value">%2$s</span></li>',
                            apply_filters('osf-portfolio-website', __('Website', 'gifymo')),
                            $website
                        );
                    endif;

                    if (!empty($location)):
                        echo sprintf(
                            '<li class="osf-portfolio-location"><i class="opal-icon-map-marker-alt"></i><span class="label">%1$s:</span><span class="value">%2$s</span></li>',
                            apply_filters('osf-portfolio-location', __('Location', 'gifymo')),
                            $location);
                    endif;

                    ?>

                </ul>
            </div>
        <?php endif; ?>
    </div>
</section>