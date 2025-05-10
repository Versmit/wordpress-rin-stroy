<?php
add_action('after_switch_theme', 'gifymo_starter_settings');

function gifymo_starter_settings() {
    set_theme_mod('background_color', 'fff');
    set_theme_mod('osf_layout_general_layout_mode', 'wide');

    if (!get_theme_mod('osf_starter_settings', false)) {
        $content = wp_remote_fopen(get_theme_file_uri('assets/data/settings.json'));
        if ($content) {
            $content = json_decode($content, true);
            if (isset($content['thememods'])) {
                foreach ($content['thememods'] as $key => $mod) {
                    set_theme_mod($key, $mod);
                }
            }
        }
        remove_theme_mod('custom_logo');

        set_theme_mod('osf_dev_mode', false);
        set_theme_mod('osf_starter_settings', true);

        update_option('revslider-valid', 'true');
        update_option('revslider-temp-active-notice', 'false');
        update_option('yith_wcwl_show_on_loop', 'no');
    }
}
