<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Products_Tabs extends OSF_Elementor_Carousel_Base {

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-products-tabs';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Opal Products Tabs', 'gifymo-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
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

        $this->start_controls_section(
            'section_tabs',
            [
                'label' => __('Tabs', 'gifymo-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label'       => __('Tab Title', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('#Product Tab', 'gifymo-core'),
                'placeholder' => __('Product Tab Title', 'gifymo-core'),
            ]
        );

        $repeater->add_control(
            'advanced',
            [
                'label' => __('Advanced', 'gifymo-core'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $repeater->add_control(
            'orderby',
            [
                'label'   => __('Order By', 'gifymo-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date'       => __('Date', 'gifymo-core'),
                    'id'         => __('Post ID', 'gifymo-core'),
                    'menu_order' => __('Menu Order', 'gifymo-core'),
                    'popularity' => __('Number of purchases', 'gifymo-core'),
                    'rating'     => __('Average Product Rating', 'gifymo-core'),
                    'title'      => __('Product Title', 'gifymo-core'),
                    'rand'       => __('Random', 'gifymo-core'),
                ],
            ]
        );

        $repeater->add_control(
            'order',
            [
                'label'   => __('Order', 'gifymo-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'  => __('ASC', 'gifymo-core'),
                    'desc' => __('DESC', 'gifymo-core'),
                ],
            ]
        );

        $repeater->add_control(
            'categories',
            [
                'label'    => __('Categories', 'gifymo-core'),
                'type'     => Controls_Manager::SELECT2,
                'options'  => $this->get_product_categories(),
                'multiple' => true,
            ]
        );

        $repeater->add_control(
            'cat_operator',
            [
                'label'     => __('Category Operator', 'gifymo-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => __('AND', 'gifymo-core'),
                    'IN'     => __('IN', 'gifymo-core'),
                    'NOT IN' => __('NOT IN', 'gifymo-core'),
                ],
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );

        $repeater->add_control(
            'product_type',
            [
                'label'   => __('Product Type', 'gifymo-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'newest',
                'options' => [
                    'newest'       => __('Newest Products', 'gifymo-core'),
                    'on_sale'      => __('On Sale Products', 'gifymo-core'),
                    'best_selling' => __('Best Selling', 'gifymo-core'),
                    'top_rated'    => __('Top Rated', 'gifymo-core'),
                    'featured'     => __('Featured Product', 'gifymo-core'),
                ],
            ]
        );

        $repeater->add_control(
            'enable_two_row',
            [
                'label'     => __('Enable Two Row', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label'       => '',
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'tab_title' => __('#Product Tab 1', 'gifymo-core'),
                    ],
                    [
                        'tab_title' => __('#Product Tab 2', 'gifymo-core'),
                    ]
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_product',
            [
                'label' => __('Product', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'limit',
            [
                'label'   => __('Posts Per Page', 'gifymo-core'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'   => __('columns', 'gifymo-core'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 4,
                'options' => [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                    6 => 6
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_tabs_style',
            [
                'label' => __('Tabs', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_tabs',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_tab_header_style',
            [
                'label' => __('Header', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_tab_header',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align_items',
            [
                'label'        => __('Align', 'gifymo-core'),
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
                'default'      => '',
                'prefix_class' => 'elementor-tabs-h-align-',
                'selectors'    => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'header_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'header_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-tabs-wrapper',
                'separator'   => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __('Title', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tab_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-title',
            ]
        );

        $this->add_responsive_control(
            'tab_title_width',
            [
                'label'      => __('Width', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-title' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_title_style');

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => __('Normal', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_background_color',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'background-color: {{VALUE}};'
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label' => __('Hover', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_background_hover_color',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title:hover' => 'background-color: {{VALUE}} !important;'
                ],
            ]
        );

        $this->add_control(
            'title_hover_border_color',
            [
                'label'     => __('Border Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title:hover' => 'border-color: {{VALUE}} !important;'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_active',
            [
                'label' => __('Active', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'title_active_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title.elementor-active'        => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .elementor-tab-title.elementor-active:before' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'title_background_active_color',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title.elementor-active' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'title_active_border_color',
            [
                'label'     => __('Border Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title.elementor-active' => 'border-color: {{VALUE}}!important;'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'tab_title_align',
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
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_tabs_title',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-tab-title',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'tabs_title_border_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_title_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_title_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style',
            [
                'label' => __('Content', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-content',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_background',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_content',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-tab-content',
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
                    '{{WRAPPER}} .elementor-tab-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->add_control_carousel();
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
        $tabs     = $settings['tabs'];
        $id_int   = substr($this->get_id_int(), 0, 3);
        ?>
        <div class="elementor-tabs" role="tablist">
            <div class="elementor-tabs-wrapper">
                <?php
                foreach ($tabs as $index => $item) :
                    $tab_count = $index + 1;
                    $class_item = 'elementor-repeater-item-' . $item['_id'];
                    $class = ($index == 0) ? 'elementor-active' : '';

                    $tab_title_setting_key = $this->get_repeater_setting_key('tab_title', 'tabs', $index);

                    $this->add_render_attribute($tab_title_setting_key, [
                        'id'            => 'elementor-tab-title-' . $id_int . $tab_count,
                        'class'         => [
                            'elementor-tab-title',
                            'elementor-tab-desktop-title',
                            $class,
                            $class_item
                        ],
                        'data-tab'      => $tab_count,
                        'tabindex'      => $id_int . $tab_count,
                        'role'          => 'tab',
                        'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                    ]);
                    ?>
                    <div <?php echo $this->get_render_attribute_string($tab_title_setting_key); ?>><?php echo $item['tab_title']; ?></div>
                <?php endforeach; ?>
            </div>
            <div class="elementor-tabs-content-wrapper">
                <?php
                foreach ($tabs as $index => $item) :
                    $tab_count = $index + 1;
                    $class_item = 'elementor-repeater-item-' . $item['_id'];
                    $class_content = ($index == 0) ? 'elementor-active' : '';
                    $tab_title_mobile_setting_key = $this->get_repeater_setting_key('tab_title_mobile', 'tabs', $index);
                    $tab_content_setting_key = $this->get_repeater_setting_key('tab_content', 'tabs', $index);

                    $this->add_render_attribute($tab_content_setting_key, [
                        'id'              => 'elementor-tab-content-' . $id_int . $tab_count,
                        'class'           => [
                            'elementor-tab-content',
                            'elementor-clearfix',
                            $class_content,
                            $class_item
                        ],
                        'data-tab'        => $tab_count,
                        'role'            => 'tabpanel',
                        'aria-labelledby' => 'elementor-tab-title-' . $id_int . $tab_count,
                    ]);

                    $this->add_render_attribute($tab_title_mobile_setting_key, [
                        'class'         => [
                            'elementor-tab-title',
                            'elementor-tab-mobile-title',
                            $class_content,
                            $class_item
                        ],
                        'data-tab'      => $tab_count,
                        'tabindex'      => $id_int . $tab_count,
                        'role'          => 'tab',
                        'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                    ]);

                    $this->add_inline_editing_attributes($tab_content_setting_key, 'advanced');
                    $this->add_inline_editing_attributes($tab_title_mobile_setting_key, 'advanced');
                    ?>
                    <div <?php echo $this->get_render_attribute_string($tab_title_mobile_setting_key); ?>><?php echo $item['tab_title']; ?></div>
                    <div <?php echo $this->get_render_attribute_string($tab_content_setting_key); ?>>
                        <?php $this->woocommerce_default($settings, $item); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    private function woocommerce_default($settings, $item) {
        $type = 'products';
        $atts = [
            'limit'          => $settings['limit'],
            'columns'        => $settings['column'],
            'orderby'        => $item['orderby'],
            'order'          => $item['order'],
            'product_layout' => 'grid',
            'class'          => '',

        ];

        $atts = $this->get_product_type($atts, $item['product_type']);

        if (isset($atts['on_sale']) && wc_string_to_bool($atts['on_sale'])) {
            $type = 'sale_products';
        } elseif (isset($atts['best_selling']) && wc_string_to_bool($atts['best_selling'])) {
            $type = 'best_selling_products';
        } elseif (isset($atts['top_rated']) && wc_string_to_bool($atts['top_rated'])) {
            $type = 'top_rated_products';
        }

        if (!empty($item['categories'])) {
            $atts['category']     = implode(',', $item['categories']);
            $atts['cat_operator'] = $item['cat_operator'];
        }

        if ($item['enable_two_row'] == 'yes') {
            $atts['class'] = 'product-two-row';
        }

        //Carousel
        if ($settings['enable_carousel'] === 'yes') {
            $atts['product_layout']    = 'carousel';
            $atts['enable_carousel']   = 'yes';
            $atts['carousel_settings'] = json_encode(wp_slash($this->get_carousel_settings()));

        } else {
            if (!empty($settings['column_tablet'])) {
                $atts['class'] .= ' columns-tablet-' . $settings['column_tablet'];
            }

            if (!empty($settings['column_mobile'])) {
                $atts['class'] .= ' columns-mobile-' . $settings['column_mobile'];
            }
        }

        $shortcode = new WC_Shortcode_Products($atts, $type);

        echo $shortcode->get_content();
    }

    protected function get_product_type($atts, $product_type) {
        switch ($product_type) {
            case 'featured':
                $atts['visibility'] = "featured";
                break;

            case 'on_sale':
                $atts['on_sale'] = true;
                break;

            case 'best_selling':
                $atts['best_selling'] = true;
                break;

            case 'top_rated':
                $atts['top_rated'] = true;
                break;

            default:
                break;
        }

        return $atts;
    }

    protected function get_product_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            )
        );

        $results = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }

        return $results;
    }
}

$widgets_manager->register(new OSF_Elementor_Products_Tabs());
