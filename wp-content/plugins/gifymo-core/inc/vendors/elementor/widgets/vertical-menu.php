<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class OSF_Elementor_Vertical_Menu extends Elementor\Widget_Base {

	public function get_name() {
		return 'opal-vertical-menu';
	}

	public function get_title() {
		return __( 'Vertical Menu', 'gifymo-core' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_categories() {
		return array( 'opal-addons' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'menu_content',
			[
				'label' => __( 'Menu', 'gifymo-core' ),
			]
		);

		$this->add_control(
			'type_menu',
			[
				'label'        => __( 'Type', 'gifymo-core' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'default',
				'options'      => [
					'default' => __( 'Default', 'gifymo-core' ),
					'hover'   => __( 'Hover', 'gifymo-core' ),
				],
				'prefix_class' => 'menu-vertical-type-'
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
        osf_vertical_navigation();
	}

}

$widgets_manager->register( new OSF_Elementor_Vertical_Menu() );
