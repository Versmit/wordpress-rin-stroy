<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Osf_Template_Loader {
	/**
	 * Initialize template loader
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_filter( 'template_include', array( __CLASS__, 'templates' ) );
	}

	/**
	 * Default templates
	 *
	 * @access public
	 *
	 * @param $template
	 *
	 * @return string
	 * @throws Exception
	 */
	public static function templates( $template ) {
		$post_type         = get_post_type();
		$custom_post_types = array( 'osf_service', 'portfolio' );

		if ( in_array( $post_type, $custom_post_types ) ) {
			if ( is_single() ) {
				return self::locate( 'single-' . $post_type );
			}
			if ( is_archive() ) {
				return self::locate( 'archive-' . $post_type );
			}
		}

		return $template;
	}

	/**
	 * Gets template path
	 *
	 * @access public
	 *
	 * @param $name
	 * @param $plugin_dir
	 *
	 * @return string
	 * @throws Exception
	 */
	public static function locate( $name, $plugin_dir = GIFYMO_CORE_PLUGIN_DIR ) {
		$template  = '';
		$post_type = get_post_type();

		// Current theme base dir
		if ( ! empty( $name ) ) {
			$template = locate_template( "{$name}.php" );
		}

		// Child theme
		if ( ! $template && ! empty( $name ) && file_exists( get_stylesheet_directory() . "/template-parts/{$post_type}/{$name}.php" ) ) {
			$template = get_stylesheet_directory() . "/template-parts/{$post_type}/{$name}.php";
		}

		// Original theme
		if ( ! $template && ! empty( $name ) && file_exists( get_template_directory() . "/template-parts/{$post_type}/{$name}.php" ) ) {
			$template = get_template_directory() . "/template-parts/{$post_type}/{$name}.php";
		}

		// Plugin
		if ( ! $template && ! empty( $name ) && file_exists( $plugin_dir . "/templates/{$name}.php" ) ) {
			$template = $plugin_dir . "/templates/{$name}.php";
		}

		// Nothing found
		if ( empty( $template ) ) {
			throw new Exception( "Template /templates/{$name}.php in plugin dir {$plugin_dir} not found." );
		}


		return $template;
	}


	/**
	 * Loads template content
	 *
	 * @param string $name
	 * @param array $args
	 * @param string $plugin_dir
	 *
	 * @return string
	 * @throws Exception
	 */
	public static function get_template_part( $name, $args = array(), $plugin_dir = GIFYMO_CORE_PLUGIN_DIR ) {
		if ( is_array( $args ) && count( $args ) > 0 ) {
			extract( $args, EXTR_SKIP );
		}

		$path = self::locate( $name, $plugin_dir );
		ob_start();
		include $path;
		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}
}

Osf_Template_Loader::init();
