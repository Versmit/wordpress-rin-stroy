<?php

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

class OSF_Elementor_Testimonials extends OSF_Elementor_Carousel_Base {

    /**
     * Get widget name.
     *
     * Retrieve testimonial widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-testimonials';
    }

    /**
     * Get widget title.
     *
     * Retrieve testimonial widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Opal Testimonials', 'gifymo-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Register testimonial widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_testimonial',
            [
                'label' => __('Testimonials', 'gifymo-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'testimonial_content',
            [
                'label'       => __('Content', 'gifymo-core'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                'label_block' => true,
                'rows'        => '10',
            ]
        );

        $repeater->add_control(
            'testimonial_image',
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
            'testimonial_name',
            [
                'label'   => __('Name', 'gifymo-core'),
                'default' => 'John Doe',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'testimonial_job',
            [
                'label'   => __('Job', 'gifymo-core'),
                'default' => 'Design',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'testimonial_link',
            [
                'label'       => __('Link to', 'gifymo-core'),
                'placeholder' => __('https://your-link.com', 'gifymo-core'),
                'type'        => Controls_Manager::URL,
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label'       => __('Testimonials Item', 'gifymo-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'testimonial_name'    => __('Testimonial #1', 'gifymo-core'),
                        'testimonial_job'     => __('Design', 'gifymo-core'),
                        'testimonial_content' => __('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'gifymo-core'),
                        'testimonial_image'   => [
                            'url' => Elementor\Utils::get_placeholder_image_src()
                        ],
                    ],
                    [
                        'testimonial_name'    => __('Testimonial #2', 'gifymo-core'),
                        'testimonial_job'     => __('Design', 'gifymo-core'),
                        'testimonial_content' => __('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'gifymo-core'),
                        'testimonial_image'   => [
                            'url' => Elementor\Utils::get_placeholder_image_src()
                        ],
                    ],
                    [
                        'testimonial_name'    => __('Testimonial #3', 'gifymo-core'),
                        'testimonial_job'     => __('Design', 'gifymo-core'),
                        'testimonial_content' => __('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'gifymo-core'),
                        'testimonial_image'   => [
                            'url' => Elementor\Utils::get_placeholder_image_src()
                        ],
                    ],

                ],
                'title_field' => '{{{ testimonial_name }}}',
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'testimonial_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `testimonial_image_size` and `testimonial_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'testimonial_image_position',
            [
                'label'          => __('Image Position', 'gifymo-core'),
                'type'           => Controls_Manager::SELECT,
                'default'        => 'aside',
                'options'        => [
                    'above' => __('Above', 'gifymo-core'),
                    'aside' => __('Aside', 'gifymo-core'),
                    'top'   => __('Top', 'gifymo-core'),
                ],
                'separator'      => 'before',
                'style_transfer' => true,
            ]
        );


        $this->add_control(
            'testimonial_alignment',
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
                'prefix_class' => 'elementor-testimonial-text-align-',
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'   => __('Columns', 'gifymo-core'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 1,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 6 => 6],
            ]
        );

        $this->add_control(
            'testimonial_layout',
            [
                'label'   => __('Layout', 'gifymo-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'layout_1',
                'options' => [
                    'layout_1' => __('Layout 1', 'gifymo-core'),
                ],
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
            'section_style_testimonial_item',
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
                    '{{WRAPPER}} .elementor-testimonial-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-testimonial-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-testimonial-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow_item',
                'selector' => '{{WRAPPER}} .elementor-testimonial-item',
            ]
        );

        $this->start_controls_tabs('tab_testimonial_item_style');

        $this->start_controls_tab(
            'tab_testimonial_item_style_normal',
            [
                'label' => __('Normal', 'gifymo-core'),
            ]
        );

        $this->add_responsive_control(
            'testimonial_item_background',
            [
                'label'     => __('Background', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-box' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_testimonial_item_style_hover',
            [
                'label' => __('Hover', 'gifymo-core'),
            ]
        );

        $this->add_responsive_control(
            'testimonial_item_background_hover',
            [
                'label'     => __('Background', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-box:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->end_controls_section();

        // Image.
        $this->start_controls_section(
            'section_style_testimonial_image',
            [
                'label' => __('Image', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'selector'  => '{{WRAPPER}}:not(.elementort-image-skew-yes) .elementor-testimonial-image img, {{WRAPPER}}.elementort-image-skew-yes .image-inner',
                'separator' => 'before',

            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Content style
        $this->start_controls_section(
            'section_testimonial_content_style',
            [
                'label' => __('Content', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_width',
            [
                'label'     => __('Width', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 400,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-opal-testimonials .item-box' => 'width: {{SIZE}}{{UNIT}}; max-width: 100%',
                ],
            ]
        );


        $this->add_control(
            'content_content_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_content_color_hover',
            [
                'label'     => __('Color Hover', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-box:hover .elementor-testimonial-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .elementor-testimonial-content',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'content_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-testimonial-content',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'content_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Name.
        $this->start_controls_section(
            'section_style_testimonial_name',
            [
                'label' => __('Name', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_text_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-name, {{WRAPPER}} .elementor-testimonial-name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'name_text_color_hover',
            [
                'label'     => __('Color Hover', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-box:hover .elementor-testimonial-name, {{WRAPPER}} .item-box:hover .elementor-testimonial-name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'selector' => '{{WRAPPER}} .elementor-testimonial-name',
            ]
        );

        $this->add_responsive_control(
            'name_spacing',
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
                    '{{WRAPPER}} .elementor-testimonial-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Job.
        $this->start_controls_section(
            'section_style_testimonial_job',
            [
                'label' => __('Job', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'job_text_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'job_text_color_hover',
            [
                'label'     => __('Color Hover', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-box:hover .elementor-testimonial-job' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'job_typography',
                'selector' => '{{WRAPPER}} .elementor-testimonial-job',
            ]
        );

        $this->end_controls_section();

        // Add Carousel Control
        $this->add_control_carousel();

    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['testimonials']) && is_array($settings['testimonials'])) {

            $this->add_render_attribute('wrapper', 'class', 'elementor-testimonial-wrapper');
            $this->add_render_attribute('wrapper', 'class', $settings['testimonial_layout']);
//            if ($settings['testimonial_alignment']) {
//                $this->add_render_attribute('wrapper', 'class', 'elementor-testimonial-text-align-' . $settings['testimonial_alignment']);
//            }

            // Item
            $this->add_render_attribute('item', 'class', 'elementor-testimonial-item');

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

            $this->add_render_attribute('meta', 'class', 'elementor-testimonial-meta');


            if ($settings['testimonial_image_position']) {
                $this->add_render_attribute('meta', 'class', 'elementor-testimonial-image-position-' . $settings['testimonial_image_position']);
            }


            ?>
            <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                <div <?php echo $this->get_render_attribute_string('row') ?>>
                    <?php foreach ($settings['testimonials'] as $testimonial): ?>

                        <?php
                        if ($testimonial['testimonial_image']['url']) {
                            $this->add_render_attribute('meta', 'class', 'elementor-has-image');
                        }

                        $has_content = !!$testimonial['testimonial_content'];
                        $has_image   = !!$testimonial['testimonial_image']['url'];
                        $has_name    = !!$testimonial['testimonial_name'];
                        $has_job     = !!$testimonial['testimonial_job'];

                        ?>
                        <div <?php echo $this->get_render_attribute_string('item'); ?>>

                            <div class="item-box">

                                <?php if ($settings['testimonial_image_position'] == 'above') : ?>
                                    <div class="elementor-testimonial-meta testimonial-image-position-above">
                                        <div class="elementor-testimonial-meta-inner">
                                            <?php $this->render_image($settings, $testimonial) ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($has_content) : ?>
                                    <div class="elementor-testimonial-content">
                                        <?php echo $testimonial['testimonial_content']; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (($settings['testimonial_image_position'] != 'above') || $has_name || $has_job) : ?>
                                    <div <?php echo $this->get_render_attribute_string('meta'); ?>>
                                        <div class="elementor-testimonial-meta-inner">

                                            <?php if (($settings['testimonial_image_position'] != 'above')) $this->render_image($settings, $testimonial); ?>

                                            <?php if ($has_name || $has_job) : ?>
                                                <div class="elementor-testimonial-details">

                                                    <?php if ($has_name) :
                                                        $testimonial_name_html = $testimonial['testimonial_name'];
                                                        if (!empty($testimonial['testimonial_link']['url'])) :
                                                            $testimonial_name_html = '<a href="' . esc_url($testimonial['testimonial_link']['url']) . '">' . $testimonial_name_html . '</a>';
                                                        endif;
                                                        ?>
                                                        <span class="elementor-testimonial-name"><?php echo $testimonial_name_html; ?></span>
                                                    <?php endif; ?>

                                                    <?php if ($has_job) : ?>
                                                        <span class="elementor-testimonial-job"><?php echo $testimonial['testimonial_job']; ?></span>
                                                    <?php endif; ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }
    }

    private function render_image($settings, $testimonial) {
        $has_image = !!$testimonial['testimonial_image']['url'];
        $no_image  = $has_image ? 'is-image' : 'no-image';
        if ($has_image) {
            $testimonial['testimonial_image_size']             = $settings['testimonial_image_size'];
            $testimonial['testimonial_image_custom_dimension'] = $settings['testimonial_image_custom_dimension'];
            $image_html                                        = Group_Control_Image_Size::get_attachment_image_html($testimonial, 'testimonial_image');
        }
        ?>

        <div class="elementor-testimonial-image <?php echo esc_attr($no_image) ?>">
            <?php if ($has_image) : ?>
                <div class="image-inner">
                    <?php echo $image_html; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php
    }

}

$widgets_manager->register(new OSF_Elementor_Testimonials());
