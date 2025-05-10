<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!osf_is_woocommerce_activated()) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;


class OSF_Elementor_Cart extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-cart';
    }

    public function get_title() {
        return __('Opal WooCommerce Cart', 'gifymo-core');
    }

    public function get_icon() {
        return 'eicon-woocommerce';
    }

    public function get_categories() {
        return ['opal-addons'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'cart_content',
            [
                'label' => __('WooCommerce Cart', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label'   => __('Choose Icon', 'gifymo-core'),
                'type'    => Controls_Manager::ICON,
                'default' => 'opal-icon-cart',
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __('Title', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Cart:', 'gifymo-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'title_hover',
            [
                'label'       => __('Title Hover', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('View your shopping cart', 'gifymo-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'show_items',
            [
                'label' => __('Show Count Text', 'gifymo-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_subtotal',
            [
                'label' => __('Show Amount', 'gifymo-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_count',
            [
                'label' => __('Show Count', 'gifymo-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'cart_align',
            [
                'label'     => __('Align', 'gifymo-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'flex-end',
                'options'   => array(
                    'flex-start' => esc_html__('Left', 'gifymo-core'),
                    'center'     => esc_html__('Center', 'gifymo-core'),
                    'flex-end'   => esc_html__('Right', 'gifymo-core'),
                ),
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        //Icon
        $this->start_controls_section(
            'section_lable_icon',
            [
                'label' => __('Icon', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_icon_cart_style');

        $this->start_controls_tab(
            'tab_icon_cart_normal',
            [
                'label' => __('Normal', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'icon_cart_color',
            [
                'label' => __('Color', 'gifymo-core'),
                'type'  => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .site-header-cart i' => 'color: {{VALUE}};',
                ],

            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_cart_hover',
            [
                'label' => __('Hover', 'gifymo-core'),
            ]
        );


        $this->add_control(
            'icon_cart_color_hover',
            [
                'label' => __('Color', 'gifymo-core'),
                'type'  => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .site-header-cart .cart-contents:hover i' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'icon_cart_bg_color_hover',
            [
                'label' => __('Background Color', 'gifymo-core'),
                'type'  => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .site-header-cart .cart-contents:hover i' => 'background-color: {{VALUE}};',
                ],

            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => __('Size', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .site-header-cart i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_cart_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .site-header-cart i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Tilte
        $this->start_controls_section(
            'section_lable_title',
            [
                'label' => __('Title', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'cart_title_typography',
                'selector' => '{{WRAPPER}} .site-header-cart .title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Title Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .site-header-cart .title' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .site-header-cart .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        //Amount
        $this->start_controls_section(
            'section_lable_amount',
            [
                'label' => __('Amount', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'cart_amount_typography',
                'selector' => '{{WRAPPER}} .cart-contents .amount',
            ]
        );

        $this->add_control(
            'amount_color',
            [
                'label'     => __('Amount Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-contents .amount' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'amount_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .cart-contents .amount' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Count Text
        $this->start_controls_section(
            'section_lable_count_text',
            [
                'label' => __('Count Text', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'cart_count_text_typography',
                'selector' => '{{WRAPPER}} .site-header-cart .count-text',
            ]
        );

        $this->add_control(
            'count_text_color',
            [
                'label'     => __('Count Text Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .site-header-cart .count-text' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'count_text_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .site-header-cart .count-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Count
        $this->start_controls_section(
            'section_lable_count',
            [
                'label' => __('Count', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'cart_count_typography',
                'selector' => '{{WRAPPER}} .site-header-cart .count',
            ]
        );

        $this->add_control(
            'count_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .site-header-cart .count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'count_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .site-header-cart .count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings();
        $class    = '';
        if (apply_filters('woocommerce_widget_cart_is_hidden', is_cart() || is_checkout())) {
            $class = 'cart_is_hidden';
        }
        ?>
        <div class="site-header-cart menu <?php echo esc_attr($class); ?>">
            <a data-toggle="toggle" class="cart-contents header-cart d-flex align-items-center"
               href="<?php echo esc_url(wc_get_cart_url()); ?>"
               title="<?php echo esc_attr($settings['title_hover']); ?>">
                <i class="<?php echo esc_attr($settings['icon']); ?>" aria-hidden="true"></i>
                <span>
                    <span class="title"><?php echo esc_html($settings['title']); ?></span>

                    <?php if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart): ?>

                        <?php if ($settings['show_count']): ?>
                            <span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
                        <?php endif; ?>

                        <?php if ($settings['show_items']): ?>
                            <span class="count-text"><?php echo wp_kses_data(_n("item", "items", WC()->cart->get_cart_contents_count(), "gifymo-core")); ?></span>
                        <?php endif; ?>

                        <?php if ($settings['show_subtotal']): ?>
                            <span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span>
                        <?php endif; ?>

                    <?php endif; ?>
                </span>
            </a>

            <ul class="shopping_cart">
                <li><?php the_widget('WC_Widget_Cart', 'title='); ?></li>
            </ul>
        </div>
        <?php
    }
}

$widgets_manager->register(new OSF_Elementor_Cart());

