<?php

/**
 * Class Gifymo_Setup_Theme
 */
class Gifymo_Setup_Theme {
    function __construct() {
        add_action('after_setup_theme', array($this, 'setup'));
        add_action('wp_enqueue_scripts', array($this, 'add_scripts'), 20);
//        add_action('yith_woocompare_popup_head', array($this, 'add_scripts'), 20);
        add_action('wp_head', array($this, 'pingback_header'));
        add_action('widgets_init', array($this, 'widgets_init'));

        add_filter('body_class', array($this, 'add_body_class'));
        add_filter('excerpt_more', array($this, 'excerpt_more'), 1);
        add_filter('frontpage_template', array($this, 'front_page_template'));

        add_filter('wp_resource_hints', array($this, 'resource_hints'), 10, 2);

        add_action('opal_end_wrapper', array($this, 'render_menu_canvas'));
        add_filter('comment_form_default_fields', array($this, 'comment_fields'));
        add_filter('comment_form_fields', array($this, 'move_comment_field_to_bottom'));
        add_filter('the_content_more_link', array($this, 'morelink'), 10, 2);

    }

    /**
     * Enqueue scripts and styles.
     */
    public function add_scripts() {
        $rtl  = is_rtl() ? '-rtl' : '';
        $deps = [];
        if (!class_exists('OSF_Scripts')) {
            $google_fonts_url = '//fonts.googleapis.com/css2?family=Jost:wght@400;500&family=Sacramento&display=swap';
            if ($google_fonts_url) {
                wp_enqueue_style('gifymo-google-fonts', $google_fonts_url, array(), null);
            }
        }

        if (!get_theme_mod('osf_dev_mode', false)) {
            wp_enqueue_style('gifymo-opal-icon', get_theme_file_uri("assets/css/opal-icons{$rtl}.css"));

            wp_enqueue_style('gifymo-carousel', get_theme_file_uri("assets/css/carousel{$rtl}.css"));

            wp_enqueue_style('opal-boostrap', get_theme_file_uri("assets/css/opal-boostrap{$rtl}.css"));
            $deps = ['opal-boostrap'];

            if (gifymo_is_woocommerce_activated()) {
                wp_enqueue_style('gifymo-woocommerce', get_theme_file_uri("assets/css/woocommerce{$rtl}.css"));
            }

            if (!class_exists('OSF_Scripts')) {
                wp_enqueue_style('gifymo-colors', get_theme_file_uri("assets/css/color{$rtl}.css"), array('gifymo-style'));
            }
        }

        $deps[] = 'wp-block-library';
        if (gifymo_is_elementor_activated()) {
            $deps[] = 'elementor-frontend';
        }
        // Add custom fonts, used in the main stylesheet.
        wp_enqueue_style('gifymo-style', get_parent_theme_file_uri("style{$rtl}.css"), $deps);

        // Owl Carousel
        wp_enqueue_script('owl-carousel', get_theme_file_uri('/assets/js/libs/owl.carousel.js'), array('jquery'), '2.2.1', true);

        // MainJs
        wp_enqueue_script('gifymo-theme-js', get_theme_file_uri('/assets/js/theme.js'), array('jquery'), '1.0', true);
        wp_localize_script('gifymo-theme-js', 'osfAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

        // Sticky Sidebar
        wp_enqueue_script('gifymo-theme-sticky-layout-js', get_theme_file_uri('/assets/js/sticky-layout.js'), array('jquery', 'wp-util'), false, true);


        // Load the html5 shiv.
        wp_enqueue_script('html5', get_theme_file_uri('/assets/js/libs/html5.js'), array(), '3.7.3');
        wp_script_add_data('html5', 'conditional', 'lt IE 9');

        wp_register_script('pushmenu', get_theme_file_uri('/assets/js/libs/mlpushmenu.js'), array(), false, true);
        wp_register_script('pushmenu-classie', get_theme_file_uri('/assets/js/libs/classie.js'), array(), false, true);
        wp_register_script('modernizr', get_theme_file_uri('/assets/js/libs/modernizr.custom.js'), array(), false, false);

        $opal_l10n = array(
            'quote'          => '<i class="fa-quote-right"></i>',
            'smoothCallback' => '',
        );

        // ================================================================================
        // ================================================================================
        // ================================================================================
        if (has_nav_menu('top')) {
            wp_enqueue_script('pushmenu');
            wp_enqueue_script('pushmenu-classie');
            wp_enqueue_script('modernizr');
            wp_enqueue_script('gifymo-navigation', get_theme_file_uri('/assets/js/navigation.js'), array('jquery'), '1.0', true);
            $opal_l10n['expand']   = esc_html__('Expand child menu', 'gifymo');
            $opal_l10n['collapse'] = esc_html__('Collapse child menu', 'gifymo');
            $opal_l10n['icon']     = '<i class="fa fa-angle-down"></i>';
        }

        wp_localize_script('gifymo-theme-js', 'gifymoJS', $opal_l10n);

        wp_enqueue_script("jquery-ui-tabs");

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    /**
     * Add preconnect for Google Fonts.
     *
     *
     * @param array $urls URLs to print for resource hints.
     * @param string $relation_type The relation type the URLs are printed.
     *
     * @return array $urls           URLs to print for resource hints.
     */
    public function resource_hints($urls, $relation_type) {
        if (wp_style_is('otf-fonts', 'queue') && 'preconnect' === $relation_type) {
            $urls[] = array(
                'href' => '//fonts.gstatic.com',
                'crossorigin',
            );
        }

        return $urls;
    }

    /**
     * Adds custom classes to the array of body classes.
     *
     * @param array $classes Classes for the body element.
     *
     * @return array
     */
    public function add_body_class($classes) {

        $layoutMode = get_theme_mod('osf_layout_general_layout_mode', 'boxed');
        $classes[]  = 'opal-layout-' . esc_attr($layoutMode);

        // Add class of group-blog to blogs with more than 1 published author.
        if (is_multi_author()) {
            $classes[] = 'group-blog';
        }

        // Add class of hfeed to non-singular pages.
        if (!is_singular()) {
            $classes[] = 'hfeed';
        }

        // Add class on front page.
        if (is_front_page() && 'posts' !== get_option('show_on_front')) {
            $classes[] = 'gifymo-front-page';
        }

        if (has_nav_menu('top')) {
            $classes[] = 'opal-has-menu-top';
        }

        return $classes;
    }

    /**
     * Register widget area.
     *
     * @link h//developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     */
    public function widgets_init() {

    }


    /**
     * Replaces "[...]" (appended to automatically generated excerpts) with ... and
     * a 'Continue reading' link.
     *
     * @param string $link Link to single post/page.
     *
     * @return string 'Continue reading' link prepended with an ellipsis.
     */
    public function excerpt_more($link) {
        if (is_admin()) {
            return $link;
        }

        $link = sprintf('<p class="more-link-wrap"><a href="%1$s" class="more-link"><span>%2$s</span><i class="opal-icon-angle-double-right" aria-hidden="true"></i></a></p>',
            esc_url(get_permalink(get_the_ID())),
            /* translators: %s: Name of current post */
            sprintf(esc_html__('Read More', 'gifymo') . '<span class="screen-reader-text"> "%s"</span>', get_the_title(get_the_ID()))
        );

        return ' &hellip; ' . $link; // WPCS: XSS ok.
    }

    /**
     * Add a pingback url auto-discovery header for singularly identifiable articles.
     */
    public function pingback_header() {
        if (is_singular() && pings_open()) {
            printf('<link rel="pingback" href="%s">' . "\n", get_bloginfo('pingback_url'));
        }
    }

    /**
     * Use front-page.php when Front page displays is set to a static page.
     *
     * @param string $template front-page.php.
     *
     * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
     */
    public function front_page_template($template) {
        return is_home() ? '' : $template;
    }

    public function setup() {
        load_theme_textdomain('gifymo', get_template_directory() . '/languages');

        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('custom-header');
        // Set the default content width.
        $GLOBALS['content_width'] = 600;

        register_nav_menus(array(
            'top'      => esc_html__('Top Menu', 'gifymo'),
            'vertical' => esc_html__('Vertical Menu', 'gifymo'),
        ));

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, and column width.
          */
        add_editor_style(array('assets/css/editor-style.css'));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         *
         * See: //codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'audio',
            'status',
        ));

        // Add theme support for Custom Logo.
        add_theme_support('custom-logo', array(
            'width'       => 250,
            'height'      => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ));

        add_image_size('gifymo-featured-image-full', 1400, 700, true);
        add_image_size('gifymo-featured-image-large', 410, 250, true);
        add_image_size('gifymo-featured-image-blog', 690, 340, true);
        add_image_size('gifymo-gallery-image', 700, 9999, false);
        add_image_size('gifymo-product-thumbnail', 220, 280, true);
        add_image_size('gifymo-thumbnail', 100, 100, true);

        // This theme allows users to set a custom background.
        add_theme_support('custom-background', array(
            'default-color' => 'fff',
        ));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        add_theme_support('opal-customize-css');
        add_theme_support('opal-admin-menu');
        add_theme_support('opal-custom-page-field');
        add_theme_support('opal-portfolio');
        add_theme_support('opal-footer-builder');
        add_theme_support('opal-header-builder');
    }

    public function render_menu_canvas() {
        echo '<nav id="opal-canvas-menu" class="opal-menu-canvas mp-menu">';

        wp_nav_menu(
            array(
                'theme_location'  => 'top',
                'menu_id'         => 'offcanvas-menu',
                'menu_class'      => 'offcanvas-menu menu menu-canvas-default',
                'container_class' => 'mainmenu'
            )
        );
        echo '</nav>';
    }

    public function comment_fields($fields) {
        $commenter = wp_get_current_commenter();
        $req       = get_option('require_name_email');
        $html_req  = ($req ? " required='required'" : '');

        $fields['author'] = sprintf(
            '<p class="comment-form-author">%s</p>',
            sprintf('<input id="author" name="author" type="text" value="%s" size="30" placeholder="%s" maxlength="245"%s />', esc_attr($commenter['comment_author']), esc_attr__("Name", "gifymo"), $html_req)
        );
        $fields['email']  = sprintf(
            '<p class="comment-form-email">%s</p>',
            sprintf('<input id="email" name="email" type="email" value="%s" placeholder="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />', esc_attr($commenter['comment_author_email']), esc_attr__("Email", "gifymo"), $html_req)
        );
        $fields['url']    = sprintf(
            '<p class="comment-form-url">%s</p>',
            sprintf('<input id="url" name="url" type="url" value="%s" placeholder="%s" size="30" maxlength="200" %s/>', esc_attr($commenter['comment_author_url']), esc_attr__("Website", "gifymo"), $html_req)
        );
        unset($fields['url']);
        return $fields;
    }

    public function move_comment_field_to_bottom($fields) {
        $cookies_field = $fields['cookies'];
        unset($fields['cookies']);

        $fields['cookies'] = $cookies_field;
        return $fields;
    }

    public function morelink($more_link, $more_link_text) {
        return '<span class="more-link-wrap">' . $more_link . '</span>';
    }
}

return new Gifymo_Setup_Theme();