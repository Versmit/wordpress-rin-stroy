<?php

class Gifymo_Setup_Sidebar {
    public function __construct() {
        add_action('widgets_init', array($this, 'init_sidebar'), 9);
        add_filter('body_class', array($this, 'body_class'));
        add_filter('opal_theme_sidebar', array($this, 'set_sidebar'));
    }

    public function body_class($classes) {
        if (is_active_sidebar('sidebar-blog') && !is_404() && !is_single()) {
            $classes[] = 'opal-content-layout-2cr';
            if (gifymo_is_woocommerce_activated() && (is_shop() || is_cart() || is_checkout() || is_product_taxonomy() || is_product_category() || is_product_tag())) {
                $classes = array_diff($classes, array(
                    'opal-content-layout-2cl',
                    'opal-content-layout-2cr',
                    'opal-content-layout-1c'
                ));
            }
        }

        $classes[] = 'opal-default-content-layout';

        return $classes;
    }

    public function init_sidebar() {
        register_sidebar(array(
            'name'          => esc_html__('Blog Sidebar', 'gifymo'),
            'id'            => 'sidebar-blog',
            'description'   => esc_html__('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'gifymo'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }

    public function set_sidebar($sidebar) {

        if (is_active_sidebar('sidebar-blog') && !is_404() && !is_single()) {
            $sidebar = 'sidebar-blog';
            if (gifymo_is_woocommerce_activated() && (is_shop() || is_cart() || is_checkout() || is_product_taxonomy() || is_product_category() || is_product_tag())) {
                $sidebar = '';
            }

        }

        return $sidebar;
    }
}

return new Gifymo_Setup_Sidebar();