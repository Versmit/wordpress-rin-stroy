<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

//add_action('init', function(){
////    update_option('elementor_pro_license_key', false);
//    if (!get_option('elementor_pro_license_key', false)) {
//        $data = [
//            'success'          => true,
//            'license'          => 'valid',
//            'item_id'          => false,
//            'item_name'        => 'Elementor Pro',
//            'is_local'         => false,
//            'license_limit'    => '1000',
//            'site_count'       => '1000',
//            'activations_left' => 1,
//            'expires'          => 'lifetime',
//            'customer_email'   => 'info@themelexus.com'
//        ];
//        update_option('elementor_pro_license_key', 'Licence Hacked');
//        ElementorPro\License\API::set_license_data($data, '+2 years');
//    }
//});

add_action( 'elementor/theme/before_do_header', function () {
	echo '<div class="opal-wrapper"><div id="page" class="site">';
} );

add_action( 'elementor/theme/after_do_header', function () {
	echo '<div class="site-content-contain"><div id="content" class="site-content">';
} );

add_action( 'elementor/theme/before_do_footer', function () {
	echo '</div></div>';
} );

add_action( 'elementor/theme/after_do_footer', function () {
	echo '</div>' . do_action( 'opal_end_wrapper' ) . '</div>';
} );