<?php
if (!defined('ABSPATH')) {
    exit;
}
require get_theme_file_path('inc/admin/tgm/class-tgm-plugin-activation.php');

/**
 * Class Gifymo_Theme_Admin
 */
class Gifymo_Theme_Admin {
    public static $instance;
    private       $include_screens_path;
    private       $plugins_required = [];
    private       $plugins          = [];
    private       $tabs_menu        = [];


    public function __construct() {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        $this->include_screens_path = trailingslashit(get_template_directory()) . 'inc/admin/screens/';

        add_filter('opal_theme_customize_layout_content', array($this, 'layout_content'));
        add_filter('pt-ocdi/plugin_page_setup', array($this, 'custom_menu_import'));
        add_filter('pt-ocdi/plugin_page_title', array($this, 'render_page_demos'), 1);
        add_filter('tgmpa_notice_action_links', array($this, 'edit_tgmpa_notice_action_links'));

        add_action('admin_menu', array($this, 'create_admin_menus'), 9);
        add_action('admin_menu', array($this, 'edit_admin_menus'), 999);

        add_action('admin_enqueue_scripts', array($this, 'dashboard_scrips'));

        // TGM Plugins
        add_filter('tgmpa_admin_menu_args', array($this, 'edit_menu_title_plugin'));
    }


    public function edit_menu_title_plugin($args) {
        $count = $this->get_plugins_count();
        if ($count > 0) {
            $args['menu_title'] = esc_html__('Install Plugins', 'gifymo') . ' <span class="update-plugins"><span class="update-count">' . esc_html($count) . '</span></span>';
        }

        return $args;
    }

    public function dashboard_scrips($hook) {
        $listPage = [
            'toplevel_page_lexus-theme',
            'themelexus_page_lexus-theme-tutorials',
            'themelexus_page_lexus-theme-changelog',
            'themelexus_page_one-click-demo-import',
            'themelexus_page_pt-one-click-demo-import',
            'themelexus_page_lexus-theme-plugins',
            'themelexus_page_opal-settings',
            'themelexus_page_tgmpa-install-plugins'
        ];
        if (in_array(get_current_screen()->base, $listPage)) {
            remove_all_actions('admin_notices');
            wp_enqueue_style('gifymo_dashboard_css', get_template_directory_uri() . '/inc/admin/css/admin.css');
        }
        if ($hook === 'lexus-theme_page_lexus-theme-tutorials') {
            wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/inc/admin/css/magnific-popup.css');
            wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/inc/admin/js/jquery.magnific-popup.min.js', array('jquery'), false, true);
            wp_add_inline_script('magnific-popup', $this->tutorial_script_inline());
        }
    }

    /**
     * A CMB2 options-page display callback override which adds tab navigation among
     * CMB2 options pages which share this same display callback.
     *
     * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
     */
    public function options_display_with_tabs($cmb_options) {
        $this->get_tab_menu('settings');
        $tabs = $this->options_page_tabs($cmb_options);
        ?>
        <div class="wrap cmb2-options-page option-<?php echo esc_attr($cmb_options->option_key); ?>">
            <?php if (get_admin_page_title()) : ?>
                <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
            <?php endif; ?>
            <h2 class="nav-tab-wrapper">
                <?php foreach ($tabs as $option_key => $tab_title) : ?>
                    <a class="nav-tab<?php if (isset($_GET['page']) && $option_key === $_GET['page']) : ?> nav-tab-active<?php endif; ?>"
                       href="<?php menu_page_url($option_key); ?>"><?php echo esc_html($tab_title); ?></a>
                <?php endforeach; ?>
            </h2>
            <form class="cmb-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST"
                  id="<?php echo esc_attr($cmb_options->cmb->cmb_id); ?>" enctype="multipart/form-data"
                  encoding="multipart/form-data">
                <input type="hidden" name="action" value="<?php echo esc_attr($cmb_options->option_key); ?>">
                <?php $cmb_options->options_page_metabox(); ?>
                <?php submit_button(esc_attr($cmb_options->cmb->prop('save_button')), 'primary', 'submit-cmb'); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Gets navigation tabs array for CMB2 options pages which share the given
     * display_cb param.
     *
     * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
     *
     * @return array Array of tab information.
     */
    public function options_page_tabs($cmb_options) {
        $tab_group = $cmb_options->cmb->prop('tab_group');
        $tabs      = array();
        foreach (CMB2_Boxes::get_all() as $cmb_id => $cmb) {
            if ($tab_group === $cmb->prop('tab_group')) {
                $tabs[$cmb->options_page_keys()[0]] = $cmb->prop('tab_title')
                    ? $cmb->prop('tab_title')
                    : $cmb->prop('title');
            }
        }

        return $tabs;
    }

    public function add_license_page() {
        /**
         * Registers options page menu item and form.
         */
        $cmb = new_cmb2_box(array(
            'id'           => 'lexus-theme-license',
            'title'        => esc_html__('License', 'gifymo'),
            'object_types' => array('options-page'),
            'option_key'   => 'lexus-theme-license',
            'parent_slug'  => 'lexus-theme',
        ));
        $cmb->add_field(array(
            'name'    => esc_html__('User Name Envato', 'gifymo'),
            'id'      => 'username',
            'type'    => 'text',
            'default' => '',
        ));

        $cmb->add_field(array(
            'name'    => esc_html__('Purchase Code', 'gifymo'),
            'id'      => 'purchased_code',
            'type'    => 'text',
            'default' => '',
        ));
    }


    public function edit_tgmpa_notice_action_links($action_links) {
        $current_screen = get_current_screen();

        if ('lexus-theme-plugins' == $current_screen->id) {
            $link_template = '<a id="manage-plugins" class="button-primary mt-3" href="#opal-install-plugins">' . esc_html__('Manage Plugins Below', 'gifymo') . '</a>';
        } else {
            $link_template = '<a id="manage-plugins" class="button-primary mt-3" href="' . esc_url(self_admin_url('admin.php?page=lexus-theme-plugins')) . '#opal-install-plugins">' . esc_html__('Go Manage Plugins', 'gifymo') . '</a>';
        }

        $action_links = array('install' => $link_template, 'dismiss' => $action_links['dismiss']);

        return $action_links;
    }

    public function render_page_demos($content) {
        ob_start();
        $this->get_tab_menu('demos');
        $content .= ob_get_clean();

        return $content;
    }

    public function create_admin_menus() {
        global $pagenow;
        $this->set_plugins_required();
        $this->setup_tab_menus();
        add_menu_page(
            'ThemeLexus',
            'ThemeLexus',
            'import',
            'lexus-theme',
            array($this, 'welcome_screen'),
            get_theme_file_uri('inc/admin/images/menu-icon-red.png'),
            2
        );
        if (isset($this->tabs_menu['tutorials'])) {
            add_submenu_page('lexus-theme',
                'Tutorials',
                'Tutorials',
                'manage_options',
                'lexus-theme-tutorials',
                array($this, 'tutorials_screen')
            );
        }

        add_submenu_page('lexus-theme',
            'Changelog',
            'Changelog',
            'manage_options',
            'lexus-theme-changelog',
            array($this, 'changelog_screen')
        );

        // Redirect to Opal welcome page after activating theme.
        if (is_admin() && 'themes.php' == $pagenow && isset($_GET['activated']) && $_GET['activated'] == 'true') {
            // Redirect
            wp_redirect(admin_url('admin.php?page=lexus-theme'));
        }
    }

    public function edit_admin_menus() {
        global $submenu;

        if (current_user_can('edit_theme_options')) {
            $submenu['lexus-theme'][0][0] = esc_html__('Welcome', 'gifymo');
        }
    }

    /**
     * @param $args array
     */
    public function custom_menu_import($args) {
        $args['parent_slug'] = 'lexus-theme';
        $args['menu_title']  = esc_html__('Import Demos', 'gifymo');

        if ($this->get_plugins_require_count() > 0) {
            foreach ($args as $key => $value) {
                $args[$key] = false;
            }
        }

        return $args;
    }

    public function welcome_screen() {
        require_once $this->include_screens_path . 'welcome.php';
    }

    public function tutorials_screen() {
        require_once $this->include_screens_path . 'tutorials.php';
    }

    public function changelog_screen() {
        require_once $this->include_screens_path . 'changelog.php';
    }

    public function layout_content() {
        return is_front_page();
    }

    private function setup_tab_menus() {
        $this->tabs_menu['welcome'] = [
            'name' => esc_html__('Dashboard', 'gifymo'),
            'path' => 'admin.php?page=lexus-theme',
        ];
        if (TGM_Plugin_Activation::$instance->is_tgmpa_complete() !== true) {
            $this->tabs_menu['plugins'] = [
                'name' => esc_html__('Plugins', 'gifymo'),
                'path' => 'admin.php?page=lexus-theme-plugins',
            ];
        }

        if ($this->get_plugins_require_count() <= 0) {
            $this->tabs_menu['demos'] = [
                'name' => esc_html__('Demo Importer', 'gifymo'),
                'path' => 'admin.php?page=pt-one-click-demo-import',
            ];
        }

        $this->tabs_menu['tutorials'] = [
            'name' => esc_html__('Tutorials', 'gifymo'),
            'path' => 'admin.php?page=lexus-theme-tutorials',
        ];
        unset($this->tabs_menu['tutorials']);

        $this->tabs_menu['changelog'] = [
            'name' => 'Changelog',
            'path' => 'admin.php?page=lexus-theme-changelog',
        ];
    }

    /**
     * Renders the admin screens header with title, logo and tabs.
     *
     * @since   5.0.0
     *
     * @access  public
     *
     * @param string $screen The current screen.
     *
     * @return void
     */
    public function get_tab_menu($screen = 'welcome') {
        $my_theme = wp_get_theme();
        ?>

        <div class="opal-dashboard-wrapper">
            <div class="wrapper-bg"></div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="inner theme-infomation">
                            <a class="pull-right" href="//themelexus.com/" title="Themelexus" target="_blank">
                                <img src="<?php echo esc_url(get_theme_file_uri('inc/admin/images/themelexus_avatar.jpg')); ?>"
                                     title="Theme Lexus">
                            </a>
                            <h1 class="theme-title"><?php esc_html_e('Welcome to', 'gifymo'); ?>

                                <?php echo esc_html($my_theme->get('Name')); ?> !
                            </h1>
                            <span class="theme-version"><?php echo esc_html__('Version', 'gifymo') . ' ' . $my_theme->get('Version');// WPCS: XSS ok.  ?></span>
                        </div>
                        <ul class="opal-tabs">
                            <?php foreach ($this->tabs_menu as $key => $tab) { ?>
                                <li class="opal-nav-item">
                                    <a href="<?php echo esc_url_raw(($key === $screen) ? '#' : admin_url($tab['path'])); ?>"
                                       class="<?php echo esc_attr($key === $screen ? 'active' : ''); ?> opal-nav-link"><?php echo esc_html($tab['name']); ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }


    private function set_plugins_required() {
        $tgm = TGM_Plugin_Activation::get_instance();
        foreach ($tgm->plugins as $slug => $plugin) {
            if ($plugin['required'] && !$tgm->is_tgm_plugin_active($slug)) {
                $this->plugins_required[] = $plugin;
            }

            if (!$tgm->is_tgm_plugin_active($slug) || $tgm->does_plugin_have_update($slug)) {
                $this->plugins[] = $plugin;
            }
        }
    }

    private function tutorial_script_inline() {
        return <<<JS
		
	jQuery(document).ready(function() {
		jQuery('.opal-popup-tutorial').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});
	});
    
JS;

    }

    public function get_plugins_required() {
        return $this->plugins_required;
    }

    public function get_plugins_require_count() {
        return count($this->plugins_required);
    }

    public function get_plugins_count() {
        return count($this->plugins);
    }

    public static function getInstance() {
        if (!isset(self::$instance) && !(self::$instance instanceof Gifymo_Theme_Admin)) {
            self::$instance = new Gifymo_Theme_Admin();
        }

        return self::$instance;
    }
}

Gifymo_Theme_Admin::getInstance();