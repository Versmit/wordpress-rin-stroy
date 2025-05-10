<?php

defined( 'ABSPATH' ) || exit();

/**
 * OSF_Megamenu_Walker
 *
 * extends Walker_Nav_Menu
 */
class OSF_Menu_Item_Post_Type {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'template_include', array( $this, 'template_include' ), 99 );
	}

	/**
	 * register post types
	 */
	public function register_post_types() {
		$labels = array(
			'name'               => _x( 'Menu Item', 'post type general name', 'gifymo-core' ),
			'singular_name'      => _x( 'Menu', 'post type singular name', 'gifymo-core' ),
			'menu_name'          => _x( 'Menu Items', 'admin menu', 'gifymo-core' ),
			'name_admin_bar'     => _x( 'Menu', 'add new on admin bar', 'gifymo-core' ),
			'add_new'            => _x( 'Add New', 'book', 'gifymo-core' ),
			'add_new_item'       => __( 'Add New Menu', 'gifymo-core' ),
			'new_item'           => __( 'New Menu', 'gifymo-core' ),
			'edit_item'          => __( 'Edit Menu', 'gifymo-core' ),
			'view_item'          => __( 'View Menu', 'gifymo-core' ),
			'all_items'          => __( 'All Menu', 'gifymo-core' ),
			'search_items'       => __( 'Search Items', 'gifymo-core' ),
			'parent_item_colon'  => __( 'Parent Items:', 'gifymo-core' ),
			'not_found'          => __( 'No menus found.', 'gifymo-core' ),
			'not_found_in_trash' => __( 'No menus found in Trash.', 'gifymo-core' )
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => null,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => true,
			'can_export'          => true,
			'capability_type'     => 'post',
			'supports'            => array( 'title', 'editor' ),
			'rewrite'             => array( 'slug' => 'opal-menus' )
		);

		register_post_type( 'opal_menu_item', apply_filters( 'opal_elementor_menu_item_post_type', $args ) );

		add_post_type_support( 'opal_menu_item', 'elementor' );
	}

	/**
	 * template include function callback
	 */
	public function template_include( $template ) {
		if ( get_query_var( 'post_type' ) !== 'opal_menu_item' ) {
			return $template;
		}

		$template = locate_template( $this->get_templates() );


		if ( ! $template ) {
			$template = OM_PLUGIN_TEMPLATE_DIR . 'single-menu.php';
		}

		return $template;
	}

	/**
	 * templates
	 */
	public function get_templates() {
		$templates   = array();
		$object      = get_queried_object();
		$templates[] = 'single-menu-' . $object->post_name . '.php';
		$templates[] = 'single-menu.php';

		return $templates;
	}

}

new OSF_Menu_Item_Post_Type();