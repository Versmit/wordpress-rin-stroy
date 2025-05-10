<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;


class OSF_Elementor_Price_Table extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-price-table';
    }

    public function get_title() {
        return __('Opal Price Table', 'gifymo-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_header',
            [
                'label' => __('Header', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'heading',
            [
                'label'   => __('Title', 'gifymo-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Pricing Table', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'popular',
            [
                'label' => __('Popular', 'gifymo-core'),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'heading_description',
            [
                'label'       => __('Description', 'gifymo-core'),
                'type'        => Controls_Manager::TEXTAREA,
                'placeholder' => __('Enter your description', 'gifymo-core'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pricing',
            [
                'label' => __('Pricing', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'price',
            [
                'label'   => __('Price', 'gifymo-core'),
                'type'    => Controls_Manager::NUMBER,
                'default' => '39.99',
            ]
        );

        $this->add_control(
            'period',
            [
                'label'       => __('Period', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('month', 'gifymo-core'),
                'placeholder' => __('Period ...', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'currency_symbol',
            [
                'label'   => __('Currency Symbol', 'gifymo-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''             => __('None', 'gifymo-core'),
                    'dollar'       => '&#36; ' . _x('Dollar', 'Currency Symbol', 'gifymo-core'),
                    'euro'         => '&#128; ' . _x('Euro', 'Currency Symbol', 'gifymo-core'),
                    'baht'         => '&#3647; ' . _x('Baht', 'Currency Symbol', 'gifymo-core'),
                    'franc'        => '&#8355; ' . _x('Franc', 'Currency Symbol', 'gifymo-core'),
                    'guilder'      => '&fnof; ' . _x('Guilder', 'Currency Symbol', 'gifymo-core'),
                    'krona'        => 'kr ' . _x('Krona', 'Currency Symbol', 'gifymo-core'),
                    'lira'         => '&#8356; ' . _x('Lira', 'Currency Symbol', 'gifymo-core'),
                    'peseta'       => '&#8359 ' . _x('Peseta', 'Currency Symbol', 'gifymo-core'),
                    'peso'         => '&#8369; ' . _x('Peso', 'Currency Symbol', 'gifymo-core'),
                    'pound'        => '&#163; ' . _x('Pound Sterling', 'Currency Symbol', 'gifymo-core'),
                    'real'         => 'R$ ' . _x('Real', 'Currency Symbol', 'gifymo-core'),
                    'ruble'        => '&#8381; ' . _x('Ruble', 'Currency Symbol', 'gifymo-core'),
                    'rupee'        => '&#8360; ' . _x('Rupee', 'Currency Symbol', 'gifymo-core'),
                    'indian_rupee' => '&#8377; ' . _x('Rupee (Indian)', 'Currency Symbol', 'gifymo-core'),
                    'shekel'       => '&#8362; ' . _x('Shekel', 'Currency Symbol', 'gifymo-core'),
                    'yen'          => '&#165; ' . _x('Yen/Yuan', 'Currency Symbol', 'gifymo-core'),
                    'won'          => '&#8361; ' . _x('Won', 'Currency Symbol', 'gifymo-core'),
                    'custom'       => __('Custom', 'gifymo-core'),
                ],
                'default' => 'dollar',
            ]
        );

        $this->add_control(
            'currency_symbol_custom',
            [
                'label'     => __('Custom Symbol', 'gifymo-core'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'currency_symbol' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'currency_format',
            [
                'label'   => __('Currency Format', 'gifymo-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''  => '1,234.56 (Default)',
                    ',' => '1.234,56',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_features',
            [
                'label' => __('Features', 'gifymo-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_text',
            [
                'label'       => __('Text', 'gifymo-core'),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => __('List Item', 'gifymo-core'),
            ]
        );

        $repeater->add_control(
            'item_check',
            [
                'label'     => __('Check', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => 'Show',
                'label_off' => 'Hide',
            ]
        );

        $this->add_control(
            'features_list',
            [
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'item_text' => __('List Item #1', 'gifymo-core'),
                    ],
                    [
                        'item_text' => __('List Item #2', 'gifymo-core'),
                    ],
                    [
                        'item_text' => __('List Item #3', 'gifymo-core'),
                    ],
                ],
                'title_field' => '{{{ item_text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_footer',
            [
                'label' => __('Button', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label'        => __('Type', 'gifymo-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'primary',
                'options'      => [
                    'default'           => __('Default', 'gifymo-core'),
                    'primary'           => __('Primary', 'gifymo-core'),
                    'secondary'         => __('Secondary', 'gifymo-core'),
                    'outline_primary'   => __('Outline Primary', 'gifymo-core'),
                    'outline_secondary' => __('Outline Secondary', 'gifymo-core'),
                    'link'              => __('Link', 'gifymo-core'),
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
                'label'   => __('Size', 'gifymo-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'md',
                'options' => [
                    'xs' => __('Extra Small', 'gifymo-core'),
                    'sm' => __('Small', 'gifymo-core'),
                    'md' => __('Medium', 'gifymo-core'),
                    'lg' => __('Large', 'gifymo-core'),
                    'xl' => __('Extra Large', 'gifymo-core'),
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'   => __('Button Text', 'gifymo-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Click Here', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => __('Link', 'gifymo-core'),
                'type'        => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'gifymo-core'),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_wrapper_style',
            [
                'label'      => __('Wrapper', 'gifymo-core'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'wrapper_bg_color',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wrapper_alignment',
            [
                'label'        => __('Alignment', 'gifymo-core'),
                'type'         => Controls_Manager::CHOOSE,
                'label_block'  => false,
                'options'      => [
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
                'default'      => 'center',
                'selectors'    => [
                    '{{WRAPPER}} .elementor-price-table' => 'text-align: {{VALUE}}',
                ],
                'prefix_class' => 'elementor-price-table-',
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'     => __('Padding', 'gifymo-core'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_border_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-price-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'animation_moveup',
            [
                'label'     => __('Hover Move Up', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover' => 'transform: translateY(-5px);',
                ],
                'label_on'  => 'Show',
                'label_off' => 'Hide',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'price_table_heading_style',
            [
                'label'      => __('Header', 'gifymo-core'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'price_wrapper_header',
            [
                'label'     => __('Spacing Top Bottom', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'   => [
                    'size' => 45,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__wrapper-header' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: calc({{SIZE}}{{UNIT}} - 10px)',
                ],
            ]
        );

        $this->add_control(
            'popular_style',
            [
                'label'     => __('Popular', 'gifymo-core'),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'popular!' => ''
                ],
            ]
        );

        $this->add_control(
            'popular_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__popular' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'popular!' => ''
                ],
            ]
        );

        $this->add_control(
            'popular_bg',
            [
                'label'     => __('Background', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__popular' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'popular_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__popular',
            ]
        );

        $this->add_control(
            'popular_spacing',
            [
                'label'     => __('Spacing', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__popular' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'heading_heading_style',
            [
                'label'     => __('Title', 'gifymo-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__heading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__heading',
            ]
        );

        $this->add_control(
            'heading_spacing',
            [
                'label'     => __('Spacing', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'description_style',
            [
                'label'     => __('Description', 'gifymo-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__heading-description' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__heading-description',
            ]
        );

        $this->add_control(
            'description_spacing',
            [
                'label'     => __('Spacing', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__heading-description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pricing_element_style',
            [
                'label'      => __('Pricing', 'gifymo-core'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'sprice_spacing',
            [
                'label'     => __('Spacing', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__price' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'price_heading_value',
            [
                'label' => __('Value', 'gifymo-core'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__price span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'price_size',
            [
                'label'     => __('Value Size', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__price' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'price_heading_symbol',
            [
                'label'     => __('Symbol', 'gifymo-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'price_symbol_size',
            [
                'label'     => __('Size', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default'   => [
                    'size' => 35,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__currency' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'price_symbol_position',
            [
                'label'       => __('Position', 'gifymo-core'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'flex-start' => [
                        'title' => __('Top', 'gifymo-core'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center'     => [
                        'title' => __('Middle', 'gifymo-core'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'flex-end'   => [
                        'title' => __('Bottom', 'gifymo-core'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .elementor-price-table__currency' => 'align-self: {{VALUE}}',
                ],

            ]
        );

        $this->add_control(
            'price_heaing_period',
            [
                'label'     => __('Period', 'gifymo-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_control(
            'price_period_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__period' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'price_period_typo',
                'selector' => '{{WRAPPER}} .elementor-price-table__period',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_features_list_style',
            [
                'label'      => __('Features', 'gifymo-core'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'features_wrapper',
            [
                'label'     => __('Spacing Top Bottom', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'   => [
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__features-list' => 'padding: {{SIZE}}{{UNIT}} 0',
                ],
            ]
        );

        $this->add_control(
            'features_list_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__features-list' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'features_list_icon_color',
            [
                'label'     => __('Icon Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__features-list i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'features_list_icon_color_active',
            [
                'label'     => __('Icon Color Active', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__features-list .item-active i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'features_list_icon_border',
            [
                'label'     => __('Border Width', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__feature-inner' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'features_list_icon_border_color',
            [
                'label'     => __('Border Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__feature-inner' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'features_list_icon_spacing',
            [
                'label'     => __('Item Spacing', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__feature-inner' => 'padding: {{SIZE}}{{UNIT}} 0',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'features_list_icon_item_typo',
                'selector' => '{{WRAPPER}} .elementor-price-table__feature-inner',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_footer_style',
            [
                'label'      => __('Button', 'gifymo-core'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition'  => [
                    'button_text!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_alignment',
            [
                'label'        => __('Alignment', 'gifymo-core'),
                'type'         => Controls_Manager::CHOOSE,
                'label_block'  => false,
                'default'      => 'Center',
                'options'      => [
                    'left'    => [
                        'title' => __('Left', 'gifymo-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'  => [
                        'title' => __('Center', 'gifymo-core'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'   => [
                        'title' => __('Right', 'gifymo-core'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justify', 'gifymo-core'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'selectors'    => [
                    '{{WRAPPER}} .elementor-price-table__footer' => 'text-align: {{VALUE}}',
                ],
                'prefix_class' => 'elementor-button-',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '.elementor-price-table__button.elementor-button'
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __('Normal', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => __('Text Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __('Hover', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label'     => __('Text Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_background_hover_border_color',
            [
                'label'     => __('Border Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_animation',
            [
                'label' => __('Animation', 'gifymo-core'),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    private function get_currency_symbol($symbol_name) {
        $symbols = [
            'dollar'       => '&#36;',
            'euro'         => '&#128;',
            'franc'        => '&#8355;',
            'pound'        => '&#163;',
            'ruble'        => '&#8381;',
            'shekel'       => '&#8362;',
            'baht'         => '&#3647;',
            'yen'          => '&#165;',
            'won'          => '&#8361;',
            'guilder'      => '&fnof;',
            'peso'         => '&#8369;',
            'peseta'       => '&#8359',
            'lira'         => '&#8356;',
            'rupee'        => '&#8360;',
            'indian_rupee' => '&#8377;',
            'real'         => 'R$',
            'krona'        => 'kr',
        ];
        return isset($symbols[$symbol_name]) ? $symbols[$symbol_name] : '';
    }

    protected function render() {
        $settings = $this->get_settings();
        $symbol   = '';

        if (!empty($settings['currency_symbol'])) {
            if ('custom' !== $settings['currency_symbol']) {
                $symbol = $this->get_currency_symbol($settings['currency_symbol']);
            } else {
                $symbol = $settings['currency_symbol_custom'];
            }
        }
        $currency_format = empty($settings['currency_format']) ? '.' : $settings['currency_format'];

        $this->add_render_attribute('button_text', 'class', [
            'elementor-price-table__button',
            'elementor-button',
            'elementor-size-' . $settings['button_size'],
        ]);

        if (!empty($settings['link']['url'])) {
            $this->add_render_attribute('button_text', 'href', $settings['link']['url']);

            if (!empty($settings['link']['is_external'])) {
                $this->add_render_attribute('button_text', 'target', '_blank');
            }
        }

        if (!empty($settings['button_hover_animation'])) {
            $this->add_render_attribute('button_text', 'class', 'elementor-animation-' . $settings['button_hover_animation']);
        }

        if (!empty($settings['icon'])) {
            $this->add_render_attribute('i', 'class', $settings['icon']);
            $this->add_render_attribute('i', 'aria-hidden', 'true');
        }

        $this->add_render_attribute('heading', 'class', 'elementor-price-table__heading');
        $this->add_render_attribute('description', 'class', 'elementor-price-table__heading-description');
        $this->add_render_attribute('period', 'class', 'elementor-price-table__period');
        $this->add_render_attribute('item_repeater', 'class', 'item-active');

        $this->add_inline_editing_attributes('heading', 'none');
        $this->add_inline_editing_attributes('description');
        $this->add_inline_editing_attributes('button_text');

        ?>

        <div class="elementor-price-table">
            <div class="elementor-price-table__wrapper-header">
                <?php
                $pricing_number = '';
                if (!empty($settings['price'])) {
                    $pricing_string = (string)$settings['price'];
                    $pricing_array  = explode('.', $pricing_string);
                    if (isset($pricing_array[1]) && strlen($pricing_array[1]) < 2) {
                        $decimals = 1;
                    } else {
                        $decimals = 2;
                    }

                    if (count($pricing_array) < 2) {
                        $decimals = 0;
                    }

                    if (empty($settings['currency_format'])) {
                        $dec_point     = '.';
                        $thousands_sep = ',';
                    } else {
                        $dec_point     = ',';
                        $thousands_sep = '.';
                    }
                    $pricing_number = number_format($settings['price'], $decimals, $dec_point, $thousands_sep);
                }
                ?>
                <!-- icon box pricing-->
                <?php if (!empty($settings['popular'])): ?>
                    <div class="elementor-price-table__popular">
                        <span> <?php echo $settings['popular']; ?></span>
                    </div>
                <?php endif; ?>
                <!-- end icon box-->

                <?php if ($settings['heading']) : ?>
                    <div class="elementor-price-table__header">
                        <?php if (!empty($settings['heading'])) : ?>
                            <h3 <?php echo $this->get_render_attribute_string('heading'); ?>><?php echo $settings['heading']; ?></h3>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($settings['heading_description'])) : ?>
                    <div class="elementor-price-table__description">
                        <p <?php echo $this->get_render_attribute_string('description'); ?>><?php echo $settings['heading_description']; ?></p>
                    </div>
                <?php endif; ?>

                <div class="elementor-price-table__price-period">
                    <?php if (!empty($settings['price'])) : ?>
                        <div class="elementor-price-table__price">
                            <?php if (!empty($symbol)) : ?>
                                <span class="elementor-price-table__currency"><?php echo $symbol; ?></span>
                            <?php endif; ?>
                            <span class="elementor-price-table__integer-part"><?php echo $pricing_number; ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- html period-->
                    <?php if (!empty($settings['period'])): ?>

                        <div <?php echo $this->get_render_attribute_string('period'); ?>>
                            <?php echo esc_html('/'); ?>
                            <span><?php esc_html_e('Per ', 'gifymo-core') ?><span>
                            <span><?php echo $settings['period']; ?><span>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <!-- end header-->

            <?php if (!empty($settings['features_list'])) : ?>
                <ul class="elementor-price-table__features-list">
                    <?php foreach ($settings['features_list'] as $index => $item) :
                        $repeater_setting_key = $this->get_repeater_setting_key('item_text', 'features_list', $index);
                        $repeater_span_key = $this->get_repeater_setting_key('item_text_span', 'features_list', $index);
                        $this->add_render_attribute($repeater_setting_key, 'class', 'elementor-repeater-item-' . $item['_id']);
                        $icon = '<i class="fa fa-close"></i>';
                        if (!empty($item['item_text']) && $item['item_check']) {
                            $this->add_render_attribute($repeater_setting_key, 'class', 'item-active');
                            $icon = '<i class="fa fa-check"></i>';
                        }
                        $this->add_inline_editing_attributes($repeater_span_key);

                        ?>
                        <li <?php echo $this->get_render_attribute_string($repeater_setting_key); ?>>
                            <div class="elementor-price-table__feature-inner">
                                <?php if (!empty($item['item_text'])) : ?>
                                    <?php echo $icon; ?>
                                    <span <?php echo $this->get_render_attribute_string($repeater_span_key); ?>> <?php echo $item['item_text']; ?>  </span>
                                <?php else :
                                    echo '&nbsp;';
                                endif;
                                ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if (!empty($settings['button_text'])) : ?>
                <div class="elementor-price-table__footer">
                    <?php if (!empty($settings['button_text'])) : ?>
                        <a <?php echo $this->get_render_attribute_string('button_text'); ?>>
                            <?php echo $settings['button_text']; ?>
                            <i class="opal-icon-arrow-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
        <?php
    }
}

$widgets_manager->register(new OSF_Elementor_Price_Table());