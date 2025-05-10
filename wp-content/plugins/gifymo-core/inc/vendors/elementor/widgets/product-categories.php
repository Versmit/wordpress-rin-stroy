<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!osf_is_woocommerce_activated()) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Products_Categories extends OSF_Elementor_Carousel_Base {

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'opal-product-categories';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return __('Opal Product Categories', 'gifymo-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-tabs';
    }


    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {

        //Section Query
        $this->start_controls_section(
            'section_setting',
            [
                'label' => __('Settings', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'categories_name',
            [
                'label'       => __('Alternate Name', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Alternate Name',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label'      => __('Choose Image', 'gifymo-core'),
                'default'    => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,

            ]
        );

        $repeater->add_control(
            'categories',
            [
                'label'       => __('Categories', 'gifymo-core'),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->get_product_categories(),
                'multiple'    => false,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'categories_items',
            [
                'label'       => __('Categories Items', 'gifymo-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'categories_name' => __('Categories #1', 'gifymo-core'),
                        'image'           => [
                            'url' => Elementor\Utils::get_placeholder_image_src()
                        ]
                    ],
                    [
                        'categories_name' => __('Categories #2', 'gifymo-core'),
                        'image'           => [
                            'url' => Elementor\Utils::get_placeholder_image_src()
                        ]
                    ],
                    [
                        'categories_name' => __('Categories #3', 'gifymo-core'),
                        'image'           => [
                            'url' => Elementor\Utils::get_placeholder_image_src()
                        ]
                    ],
                ],
                'title_field' => '{{{ categories_name }}}',
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `testimonial_image_size` and `testimonial_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'categories_layout',
            [
                'label'        => __('Layout', 'gifymo-core'),
                'type'         => \Elementor\Controls_Manager::SELECT,
                'default'      => 'grid',
                'options'      => [
                    'grid'  => 'grid',
                    'list'  => 'List',
                    'cover' => 'Cover'
                ],
                'prefix_class' => 'elementor-categories-layout-',
            ]
        );
        $this->add_responsive_control(
            'column',
            [
                'label'   => __('Columns', 'gifymo-core'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 4,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6],
            ]
        );

        $this->add_responsive_control(
            'gutter',
            [
                'label'     => __('Gutter', 'gifymo-core'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-wrapper .row'         => 'margin-left: calc({{SIZE}}{{UNIT}} / -2); margin-right: calc({{SIZE}}{{UNIT}} / -2);',
                    '{{WRAPPER}} .elementor-product-categories-wrapper .column-item' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2); padding-bottom: calc({{SIZE}}{{UNIT}})',
                ],
                'condition' => [
                    'enable_carousel!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_number_item',
            [
                'label' => __('Show Number Item', 'gifymo-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'button',
            [
                'label'     => __('Button Text', 'gifymo-core'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Shop now', 'gifymo-core'),
                'separator' => 'before',

            ]
        );

        $this->add_control(
            'icon_cta',
            [
                'label'       => __('Icon', 'gifymo-core'),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'default'     => 'opal-icon-next',
            ]
        );

        $this->end_controls_section();

        //Item
        $this->start_controls_section(
            'section_item_style',
            [
                'label' => __('Items', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'item_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-item-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'item_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .elementor-product-categories-meta',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'item_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-product-categories-item-inner',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-product-categories-item-inner',
            ]
        );

        $this->end_controls_section();


        //IMAGE
        $this->start_controls_section(
            'section_image_style',
            [
                'label' => __('Image', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'image_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-product-categories-image img',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-product-categories-image img',
            ]
        );

        $this->end_controls_section();

        //STYLE
        $this->start_controls_section(
            'section_content_style',
            [
                'label' => __('Content', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_align',
            [
                'label'     => __('Alignment', 'gifymo-core'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'gifymo-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'gifymo-core'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'gifymo-core'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-meta' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'content_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .elementor-product-categories-meta',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'content_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-product-categories-meta',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'content_border_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'content_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-product-categories-meta',
            ]
        );

        $this->add_control(
            'heading_title_style',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __('Title', 'gifymo-core'),
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'category_name_typography',
                'selector'  => '{{WRAPPER}} .elementor-product-categories-title',
                'label'     => 'Typography',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'name_spacing',
            [
                'label'      => __('Spacing', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-title' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_name_color_style');

        $this->start_controls_tab(
            'tab_color_normal',
            [
                'label' => __('Normal', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label'     => __('Title Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-item-inner .elementor-product-categories-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_color_hover',
            [
                'label' => __('Hover', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'name_color_hover',
            [
                'label'     => __('Title Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-item-inner .elementor-product-categories-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'heading_categories_total_style',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __('Categories Total', 'gifymo-core'),
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'categories_total_typography',
                'selector'  => '{{WRAPPER}} .cats-total',
                'label'     => 'Typography',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'categories_total_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-item-inner .cats-total' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'categories_total_spacing',
            [
                'label'      => __('Spacing', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .cats-total' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //button
        $this->start_controls_section(
            'button_style',
            [
                'label'     => __('Button', 'gifymo-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'button!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label'        => __('Type', 'gifymo-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'link',
                'options'      => [
                    'primary'           => __('Primary', 'gifymo-core'),
                    'secondary'         => __('Secondary', 'gifymo-core'),
                    'dark'              => __('Dark', 'gifymo-core'),
                    'light'             => __('Light', 'gifymo-core'),
                    'link'              => __('Link', 'gifymo-core'),
                    'outline_primary'   => __('Outline Primary', 'gifymo-core'),
                    'outline_secondary' => __('Outline Secondary', 'gifymo-core'),
                    'outline_dark'      => __('Outline Dark', 'gifymo-core'),
                    'info'              => __('Info', 'gifymo-core'),
                    'success'           => __('Success', 'gifymo-core'),
                    'warning'           => __('Warning', 'gifymo-core'),
                    'danger'            => __('Danger', 'gifymo-core'),
                ],
                'prefix_class' => 'elementor-button-',
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label'     => __('Size', 'gifymo-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'sm',
                'options'   => [
                    'xs' => __('Extra Small', 'gifymo-core'),
                    'sm' => __('Small', 'gifymo-core'),
                    'md' => __('Medium', 'gifymo-core'),
                    'lg' => __('Large', 'gifymo-core'),
                    'xl' => __('Extra Large', 'gifymo-core'),
                ],
                'condition' => [
                    'button_type!' => 'link',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'label'    => __('Typography', 'gifymo-core'),
                'selector' => '{{WRAPPER}} .elementor-cta__button',
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab('button_normal',
            [
                'label' => __('Normal', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => __('Text Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button:not(:hover)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button-hover',
            [
                'label' => __('Hover', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label'     => __('Text Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => __('Border Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button:hover' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'button_border',
                'selector'  => '{{WRAPPER}} .elementor-cta__button',
                'separator' => 'before',
            ]);

        $this->add_control(
            'button_border_radius',
            [
                'label'     => __('Border Radius', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label'     => __('Icon Button', 'gifymo-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon!' => '',
                ]
            ]
        );


        $this->add_control(
            'icon_align',
            [
                'label'     => __('Position', 'gifymo-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left'  => __('Before', 'gifymo-core'),
                    'right' => __('After', 'gifymo-core'),
                ],
                'condition' => [
                    'icon_cta!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_size_cta',
            [
                'label'     => __('Size', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'default'   => [
                    'size' => 14,
                ],
                'condition' => [
                    'icon!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-button-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label'     => __('Spacing', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'default'   => [
                    'size' => 15,
                ],
                'condition' => [
                    'icon!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_icon_style');

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => __('Normal', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'button_icon_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button .elementor-button-icon, {{WRAPPER}} .elementor-button .elementor-button-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_icon_bgcolor',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button .elementor-button-icon, {{WRAPPER}} .elementor-button .elementor-button-icon' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => __('Hover', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'button_icon_hover_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:hover .elementor-button-icon, {{WRAPPER}} .elementor-button:hover .elementor-button-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_icon_hover_bgcolor',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:hover .elementor-button-icon, {{WRAPPER}} .elementor-button:hover .elementor-button-icon' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon-rotate',
            [
                'label'     => __('Icon Rotate', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover .elementor-button-icon' => 'transform: rotate({{SIZE}}deg);',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        //carousel
        $this->add_control_carousel();

    }


    protected function get_product_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            )
        );
        $results    = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }
        return $results;
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('item', 'class', 'elementor-product-categories-item');

        if ($settings['enable_carousel'] === 'yes') {

            $this->add_render_attribute('row', 'class', 'owl-carousel owl-theme');
            $carousel_settings = $this->get_carousel_settings();
            $this->add_render_attribute('row', 'data-settings', wp_json_encode($carousel_settings));

        } else {

            $this->add_render_attribute('item', 'class', 'column-item');
            // Row
            $this->add_render_attribute('row', 'class', 'row');
            $this->add_render_attribute('row', 'data-elementor-columns', $settings['column']);

            if (!empty($settings['column_tablet'])) {

                $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['column_tablet']);
            }

            if (!empty($settings['column_mobile'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['column_mobile']);
            }
        }

        $this->add_render_attribute('button', 'class', [
            'elementor-button',
            'elementor-size-' . $settings['button_size'],
        ]);

        $this->add_render_attribute('icon-align', 'class',
            [
                'elementor-button-icon',
                'elementor-align-icon-' . $settings['icon_align'],
            ]
        );

        $this->add_inline_editing_attributes('button');
        $this->add_inline_editing_attributes('icon-align');

        ?>
        <div class="elementor-product-categories-wrapper">
            <div <?php echo $this->get_render_attribute_string('row') ?>>
                <?php
                foreach ($settings['categories_items'] as $item):
                    if ($item['categories']) {
                        $category = get_term_by('slug', $item['categories'], 'product_cat');

                        if ($category && !is_wp_error($category)) {
//                            $this->add_render_attribute('button', 'href', get_term_link($category));
                            if (!empty($item['image']['id'])) {
                                $item['image_size']             = $settings['image_size'];
                                $item['image_custom_dimension'] = $settings['image_custom_dimension'];
                                $image                          = Group_Control_Image_Size::get_attachment_image_html($item, 'image');
                            } else {
                                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                                if (!empty($thumbnail_id)) {
                                    $image = '<img src="' . wp_get_attachment_url($thumbnail_id) . '" alt="" >';
                                } else {
                                    $image = '<img src="' . wc_placeholder_img_src() . '" alt="" >';
                                }
                            } ?>
                            <div <?php echo $this->get_render_attribute_string('item'); ?>>
                                <div class="elementor-product-categories-item-inner">
                                    <div class="elementor-product-categories-image">
                                        <a href="<?php echo esc_url(get_term_link($category)); ?>" title="<?php echo esc_attr($category->name); ?>"><?php echo $image; ?></a>
                                    </div>
                                    <div class="elementor-product-categories-meta">

                                        <div class="elementor-product-categories-title">
                                            <a href="<?php echo esc_url(get_term_link($category)); ?>" title="<?php echo esc_attr($category->name); ?>">
                                                <span class="elementor-product-categories-title-text"><?php echo empty($item['categories_name']) ? esc_html($category->name) : wp_kses_post($item['categories_name']); ?></span>
                                            </a>
                                        </div>

                                        <?php if ($settings['show_number_item'] && isset($category->count)): ?>
                                            <div class="cats-total">
                                                <?php echo esc_html($category->count) . esc_html__(' шт.', 'gifymo-core'); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($settings['button'])) : ?>
                                            <div class="elementor-product-categories-button">
                                                <a <?php echo $this->get_render_attribute_string('button'); ?> href="<?php echo esc_url(get_term_link($category)) ?>">
                                                    <span class="elementor-button-content-wrapper">
                                                        <?php if (!empty($settings['icon_cta'])) : ?>
                                                            <span <?php echo $this->get_render_attribute_string('icon-align'); ?>>
                                                                <i class="<?php echo esc_attr($settings['icon_cta']); ?>" aria-hidden="true"></i>
                                                            </span>
                                                        <?php endif; ?>
                                                        <span class="elementor-button-text"><?php echo $settings['button']; ?></span>
                                                    </span>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                endforeach; ?>
            </div>
        </div>
        <?php
    }

}

$widgets_manager->register(new OSF_Elementor_Products_Categories());

