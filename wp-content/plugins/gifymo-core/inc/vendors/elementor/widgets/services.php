<?php
//namespace Elementor;
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Css_Filter;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Icons_Manager;

class OSF_Elementor_Services extends OSF_Elementor_Carousel_Base {

    /**
     * Get widget name.
     *
     * Retrieve service widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-services';
    }

    /**
     * Get widget title.
     *
     * Retrieve service widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Opal Services', 'gifymo-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve service widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Register service widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_service',
            [
                'label' => __('Services', 'gifymo-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'selected_icon',
            [
                'label'            => __('Icon', 'gifymo-core'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => [
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );
        $repeater->add_control(
            'service_name',
            [
                'label'   => __('Name', 'gifymo-core'),
                'default' => 'John Doe',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'service_content',
            [
                'label'       => __('Content', 'gifymo-core'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                'label_block' => true,
                'rows'        => '10',
            ]
        );

        $repeater->add_control(
            'service_image',
            [
                'label'      => __('Choose Image', 'gifymo-core'),
                'default'    => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'service_link',
            [
                'label'       => __('Link to', 'gifymo-core'),
                'placeholder' => __('https://your-link.com', 'gifymo-core'),
                'type'        => Controls_Manager::URL,
            ]
        );

        $this->add_control(
            'services',
            [
                'label'       => __('Testimonials Item', 'gifymo-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'service_name'    => __('Services #1', 'gifymo-core'),
                        'service_content' => __('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'gifymo-core'),
                    ],
                    [
                        'service_name'    => __('Services #2', 'gifymo-core'),
                        'service_content' => __('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'gifymo-core'),
                    ],
                    [
                        'service_name'    => __('Services #3', 'gifymo-core'),
                        'service_content' => __('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'gifymo-core'),
                    ],

                ],
                'title_field' => '{{{ service_name }}}',
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'service_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `service_image_size` and `service_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
                'condition' => [
                    'service_layout' => 'layout-2'
                ],
            ]
        );


        $this->add_control(
            'service_alignment',
            [
                'label'        => __('Alignment', 'gifymo-core'),
                'type'         => Controls_Manager::CHOOSE,
                'default'      => 'center',
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
                'label_block'  => false,
                'prefix_class' => 'elementor-service-text-align-',
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'   => __('Columns', 'gifymo-core'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 3,
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

        $this->add_control(
            'service_layout',
            [
                'label'        => __('Layout', 'gifymo-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'layout-1',
                'options'      => [
                    'layout-1' => __('Layout 1', 'gifymo-core'),
                    'layout-2' => __('Layout 2', 'gifymo-core')
                ],
                'prefix_class' => 'elementor-service-',
            ]
        );
        $this->add_control(
            'view',
            [
                'label'   => __('View', 'gifymo-core'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );
        $this->end_controls_section();


        // Item Style
        $this->start_controls_section(
            'section_style_service_item',
            [
                'label' => __('Item', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'padding_item',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-item-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'margin_item',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-item-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius_item',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-item-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow_item',
                'selector' => '{{WRAPPER}} .elementor-item-box',
            ]
        );

        $this->start_controls_tabs('tab_service_item_style');

        $this->start_controls_tab(
            'tab_service_item_style_normal',
            [
                'label' => __('Normal', 'gifymo-core'),
            ]
        );

        $this->add_responsive_control(
            'service_item_background',
            [
                'label'     => __('Background', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-item-box' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_service_item_style_hover',
            [
                'label' => __('Hover', 'gifymo-core'),
            ]
        );

        $this->add_responsive_control(
            'service_item_background_hover',
            [
                'label'     => __('Background', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-service-item-inner:hover .elementor-item-box' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->end_controls_section();

        // Content style
        $this->start_controls_section(
            'section_service_content_style',
            [
                'label' => __('Content', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_icon_heading',
            [
                'label' => __('Icon', 'gifymo-core'),
                'type'  => Controls_Manager::HEADING,
            ]
        );
        $this->add_responsive_control(
            'icon_font_size',
            [
                'label'     => __('Size', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label'     => __('Spacing', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_title_heading',
            [
                'label' => __('Title', 'gifymo-core'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-service-name',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'     => __('Spacing', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-service-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_content_heading',
            [
                'label' => __('Content', 'gifymo-core'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .elementor-service-content',
            ]
        );

        $this->add_responsive_control(
            'content_spacing',
            [
                'label'     => __('Spacing', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-service-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs('tab_service_content_style');

        $this->start_controls_tab(
            'tab_service_content_style_normal',
            [
                'label' => __('Normal', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'content_content_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-item-box' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Title Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-service-name, {{WRAPPER}} .elementor-service-name a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'     => __('Icon Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_service_content_style_hover',
            [
                'label' => __('Hover', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'content_content_color_hover',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-service-item-inner:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'     => __('Title Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-service-item-inner:hover .elementor-service-name, {{WRAPPER}} .elementor-service-item-inner:hover .elementor-service-name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label'     => __('Icon Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-service-item-inner:hover .elementor-icon i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-service-item-inner:hover .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // Add Carousel Control
        $this->add_control_carousel();

    }


    /**
     * Render service widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['services']) && is_array($settings['services'])) {

            $this->add_render_attribute('wrapper', 'class', 'elementor-service-wrapper');
            $this->add_render_attribute('wrapper', 'class', $settings['service_layout']);

            // Item
            $this->add_render_attribute('item', 'class', 'elementor-service-item');

            // Item inner
            $this->add_render_attribute('item-inner', 'class', 'elementor-service-item-inner');

            if ($settings['enable_carousel'] === 'yes') {
                $this->add_render_attribute('row', 'class', 'owl-carousel owl-theme');
                $carousel_settings = $this->get_carousel_settings();
                $this->add_render_attribute('row', 'data-settings', wp_json_encode($carousel_settings));
            } else {
                // Row
                $this->add_render_attribute('row', 'class', 'row');
                $this->add_render_attribute('row', 'data-elementor-columns', $settings['column']);

                if (!empty($settings['column_tablet'])) {
                    $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['column_tablet']);
                }
                if (!empty($settings['column_mobile'])) {
                    $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['column_mobile']);
                }
                $this->add_render_attribute('item', 'class', 'column-item ');
            }
            $count = 0;

            ?>
            <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                <div <?php echo $this->get_render_attribute_string('row') ?>>
                    <?php foreach ($settings['services'] as $service): ?>

                        <?php

                        $migrated = isset($service['__fa4_migrated']['selected_icon']);
                        $is_new   = empty($service['icon']) && Icons_Manager::is_migration_allowed();

                        if (empty($service['icon']) && !Icons_Manager::is_migration_allowed()) {
                            // add old default
                            $service['icon'] = 'fa fa-star';
                        }

                        $count++;
                        $has_content = !!$service['service_content'];
                        $has_image   = !!$service['service_image']['url'];
                        $has_name    = !!$service['service_name'];


                        $service_name_html = $service['service_name'];

                        if (!empty($service['service_link']['url']) && $has_name) {

                            $this->add_render_attribute('link' . $count, 'href', $service['service_link']['url']);

                            if ($service['service_link']['is_external']) {
                                $this->add_render_attribute('link' . $count, 'target', '_blank');
                            }

                            if ($service['service_link']['nofollow']) {
                                $this->add_render_attribute('link' . $count, 'rel', 'nofollow');
                            }

                            $service_name_html = '<a ' . $this->get_render_attribute_string('link' . $count) . '>' . $service_name_html . '</a>';
                        }


                        ?>

                        <div <?php echo $this->get_render_attribute_string('item'); ?>>
                            <div <?php echo $this->get_render_attribute_string('item-inner'); ?>>

                                <?php if ($settings['service_layout'] == 'layout-2'): ?>
                                    <?php if ($has_image) : ?>
                                        <?php $this->render_image($settings, $service); ?>
                                    <?php endif; ?>

                                    <div class="overlay flex-middle">
                                        <div class="elementor-service-box-content">
                                            <div class="elementor-icon">
                                                <?php if ($is_new || $migrated) :
                                                    Icons_Manager::render_icon($service['selected_icon'], ['aria-hidden' => 'true']);
                                                else : ?>
                                                    <i <?php echo $this->get_render_attribute_string('icon'); ?>></i>
                                                <?php endif; ?>
                                            </div>

                                            <?php if ($has_name) : ?>
                                                <h3 class="elementor-service-name">
                                                    <?php echo $service_name_html; ?>
                                                </h3>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="elementor-item-box">

                                    <div class="elementor-service-box-content">
                                        <div class="elementor-icon">
                                            <?php if ($is_new || $migrated) :
                                                Icons_Manager::render_icon($service['selected_icon'], ['aria-hidden' => 'true']);
                                            else : ?>
                                                <i <?php echo $this->get_render_attribute_string('icon'); ?>></i>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($has_name) : ?>
                                            <h3 class="elementor-service-name">
                                                <?php echo $service_name_html; ?>
                                            </h3>
                                        <?php endif; ?>

                                        <?php if (!empty($service['service_content'])) : ?>
                                            <div class="elementor-service-content">
                                                <?php echo $service['service_content']; ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }
    }

    private function render_image($settings, $service) { ?>
        <div class="elementor-service-image">
            <div class="image-inner">
                <?php
                $service['service_image_size']             = $settings['service_image_size'];
                $service['service_image_custom_dimension'] = $settings['service_image_custom_dimension'];
                if (!empty($service['service_image']['url'])) :
                    $image_html = Group_Control_Image_Size::get_attachment_image_html($service, 'service_image');
                    echo $image_html;
                endif;
                ?>
            </div>
        </div>
        <?php
    }

}

$widgets_manager->register(new OSF_Elementor_Services());
