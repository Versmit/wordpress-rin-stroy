<?php

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class OSF_Elementor_Addons {
    public function __construct() {
        $this->include_addons();
        add_action('elementor/init', array($this, 'add_category'));
        add_action('elementor/widgets/register', array($this, 'include_widgets'));

        add_action('wp', [$this, 'regeister_scripts_frontend']);

        add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_scripts_frontend']);
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'add_scripts_editor']);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_icons'], 99);

        add_action('widgets_init', array($this, 'register_wp_widgets'));


        add_action('after_switch_theme', array($this, 'set_elementor_option'));
        add_action('customize_save_after', array($this, 'set_elementor_option'));

        add_action('init', array($this, 'setup_global_css'));

//        add_filter('elementor/shapes/additional_shapes', [$this, 'custom_shapes']);

        // Custom Animation Scroll
        add_filter('elementor/controls/animations/additional_animations', [$this, 'add_animations_scroll']);

        add_action('wp_ajax_osf_ajax_loadmore_post', array($this, 'ajax_get_more_post'));
        add_action('wp_ajax_nopriv_osf_ajax_loadmore_post', array($this, 'ajax_get_more_post'));
//        add_action('elementor/controls/controls_registered', [$this, 'modify_controls'], 10, 1);
    }

    /**
     * Responsible to modify the fonts list in the font control.
     */
//    function modify_controls($controls_registry) {
//        // retrieve fonts list from Elementor
//        $fonts = $controls_registry->get_control('font')->get_settings('options');
//        // add your new custom font
//        $new_fonts = array_merge(['Gifymo' => 'system'], $fonts);
//        // return the new list of fonts
//        $controls_registry->get_control('font')->set_settings('options', $new_fonts);
//    }


    public function add_animations_scroll($animations) {
        $animations['Opal Animation'] = [
            'opal-move-up'    => 'Move Up',
            'opal-move-down'  => 'Move Down',
            'opal-move-left'  => 'Move Left',
            'opal-move-right' => 'Move Right',
            'opal-flip'       => 'Flip',
            'opal-helix'      => 'Helix',
            'opal-scale-up'   => 'Scale',
            'opal-am-popup'   => 'Popup',
        ];

        return $animations;
    }

    public function enqueue_editor_icons() {
        wp_enqueue_style(
            'gifymo-editor-icon',
            trailingslashit(GIFYMO_CORE_PLUGIN_URL) . "assets/css/elementor/icons.css",
            [],
            GIFYMO_CORE_VERSION
        );
    }

    public function custom_shapes($additional_shapes) {
        $additional_shapes['opal-wave'] = [
            'title'        => _x('Opal Wave', 'Shapes', 'gifymo-core'),
            'has_negative' => true,
            'path'         => trailingslashit(GIFYMO_CORE_PLUGIN_DIR) . 'assets/images/shapes/wave.svg'
        ];

        return $additional_shapes;
    }

    public function setup_global_css() {
        if (!get_transient('opal-customizer-update-color')) {
            return;
        }
        delete_transient('opal-customizer-update-color');
        $global = new Elementor\Core\Files\CSS\Global_CSS('global.css');
        $global->update_file();

    }

    public function set_elementor_option() {
        $color_primary   = get_theme_mod('osf_colors_general_primary', '#0160b4');
        $color_secondary = get_theme_mod('osf_colors_general_secondary', '#00c484');
        $body_color      = get_theme_mod('osf_colors_general_body', '#222222');
        $scheme_colors   = array_values(get_option('elementor_scheme_color'));
        if ($color_primary != $scheme_colors[0] || $color_secondary != $scheme_colors[1] || $body_color != $scheme_colors[2]) {
            update_option('elementor_scheme_color', [
                '1' => $color_primary,
                '2' => $color_secondary,
                '3' => $body_color,
                '4' => $scheme_colors[3],
            ]);
            set_transient('opal-customizer-update-color', true, MINUTE_IN_SECONDS);
        }
    }

    private function include_addons() {
        $files = glob(trailingslashit(GIFYMO_CORE_PLUGIN_DIR) . 'inc/vendors/elementor/addons/*.php');
        foreach ($files as $file) {
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }

    public function register_wp_widgets() {
        require_once 'widgets/wp_template.php';
        register_widget('Opal_WP_Template');
    }

    function regeister_scripts_frontend() {
        $rtl      = is_rtl() ? '-rtl' : '';
        $dev_mode = get_theme_mod('osf_dev_mode', false);
        wp_register_style('magnific-popup', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . "assets/css/magnific-popup{$rtl}.css");
        wp_register_style('tooltipster', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . "assets/css/tooltipster.bundle.min{$rtl}.css", array(), GIFYMO_CORE_VERSION, 'all');
        wp_register_style('scrollbar', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . "assets/css/jquery.scrollbar{$rtl}.css", array(), GIFYMO_CORE_VERSION, 'all');

        wp_register_script('magnific-popup', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.magnific-popup.min.js', array('jquery'), false, true);
        wp_register_script('spritespin', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/spritespin.js');


        wp_register_script('tweenmax', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/TweenMax.min.js', array('jquery'), GIFYMO_CORE_VERSION, true);
        wp_register_script('parallaxmouse', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/jquery-parallax.js', array('jquery'), GIFYMO_CORE_VERSION, true);
        wp_register_script('tilt', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/universal-tilt.min.js', array('jquery'), GIFYMO_CORE_VERSION, true);
        wp_register_script('waypoints', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.waypoints.js', array('jquery'), GIFYMO_CORE_VERSION, true);

        wp_register_script('smartmenus', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.smartmenus.min.js', array('jquery'), GIFYMO_CORE_VERSION, true);
        wp_register_script('tooltipster', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/tooltipster.bundle.min.js', array(), GIFYMO_CORE_VERSION, true);
        wp_register_script('scrollbar', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.scrollbar.min.js', array(), GIFYMO_CORE_VERSION, true);

        wp_register_script('fullpage', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/fullpage.min.js', array('jquery'), GIFYMO_CORE_VERSION, true);

        wp_register_script('pushmenu', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/mlpushmenu.js', array(), GIFYMO_CORE_VERSION, true);
        wp_register_script('pushmenu-classie', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/classie.js', array(), GIFYMO_CORE_VERSION, true);
        wp_register_script('modernizr', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/modernizr.custom.js', array(), GIFYMO_CORE_VERSION, false);

        wp_register_script('hoverdir', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.hoverdir.js', array(), GIFYMO_CORE_VERSION, true);

        wp_register_script('imagesloaded', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/imagesloaded.pkgd.min.js', array(), GIFYMO_CORE_VERSION, true);
        wp_register_script('masonry', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/masonry.pkgd.min.js', array(), GIFYMO_CORE_VERSION, true);
        wp_register_script('anime', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/anime.min.js', array(), GIFYMO_CORE_VERSION, true);
        wp_register_script('chart', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/chart.min.js', array(), GIFYMO_CORE_VERSION, true);

        wp_register_script('isotope', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/isotope.pkgd.min.js', array(), GIFYMO_CORE_VERSION, true);
        wp_enqueue_script('tweenmax');

        wp_register_script('wavify', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/wavify.js', array('jquery'), GIFYMO_CORE_VERSION, true);

        wp_register_script('jquery-wavify', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.wavify.js', array('jquery'), GIFYMO_CORE_VERSION, true);
        wp_register_script('osf-vscroll', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/libs/vscroll.js', array('jquery'), GIFYMO_CORE_VERSION, true);

        if (osf_is_elementor_activated() && !$dev_mode) {
            wp_enqueue_style('osf-elementor-addons', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . "assets/css/elementor/style{$rtl}.css", array('gifymo-style'), GIFYMO_CORE_VERSION, 'all');
        }

        wp_enqueue_script('tooltipster');
        wp_enqueue_style('tooltipster');
    }

    public function add_scripts_editor() {
        wp_enqueue_script('opal-elementor-admin-editor', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/elementor/admin-editor.js', [], false, true);
    }

    public function enqueue_scripts_frontend() {
        wp_enqueue_script('opal-elementor-frontend', trailingslashit(GIFYMO_CORE_PLUGIN_URL) . 'assets/js/elementor/frontend.js', ['jquery'], false, true);
    }

    public function add_category() {
        Elementor\Plugin::instance()->elements_manager->add_category(
            'opal-addons',
            array(
                'title' => __('Opal Addons', 'gifymo-core'),
                'icon'  => 'fa fa-plug',
            ));
    }

    /**
     * @param $widgets_manager Elementor\Widgets_Manager
     */
    public function include_widgets($widgets_manager) {
        require 'abstract/carousel.php';
        require 'abstract/button.php';
        $files = glob(trailingslashit(GIFYMO_CORE_PLUGIN_DIR) . 'inc/vendors/elementor/widgets/*.php');

        foreach ($files as $file) {
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }

    public function ajax_get_more_post() {
        $response            = [];
        $query_args          = $_POST['data'];
        $query_args['paged'] = $_POST['paged'] + 1;
        $posts               = new WP_Query($query_args);

        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                ob_start();
                $item_classes = '__all ';
                $item_cats    = get_the_terms(get_the_ID(), 'osf_portfolio_cat');
                foreach ((array)$item_cats as $item_cat) {
                    if (!empty($item_cats) && !is_wp_error($item_cats)) {
                        $item_classes .= $item_cat->slug . ' ';
                    }
                }
                echo '<div class="column-item portfolio-entries ' . esc_attr($item_classes) . '">';
                get_template_part('template-parts/portfolio/content');
                echo '</div>';
                $response['posts'][] = ob_get_clean();
            }
            $response['disable']  = false;
            $response['settings'] = $query_args;
            $response['paged']    = $query_args['paged'];
            if ($query_args['paged'] == $posts->max_num_pages) {
                $response['disable'] = true;
            }
        }

        wp_send_json($response);

    }

}

new OSF_Elementor_Addons();

