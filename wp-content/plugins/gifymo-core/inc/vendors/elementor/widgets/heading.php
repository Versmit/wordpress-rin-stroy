<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class  OSF_Elementor_Heading extends Widget_Heading {

    public function get_title() {
        return __('Opal Heading', 'gifymo-core');
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Title', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __('Title', 'gifymo-core'),
                'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => __('Enter your title', 'gifymo-core'),
                'default'     => __('Add Your Heading Text Here', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'show_line',
            [
                'label'        => __('Show Line', 'gifymo-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Show', 'gifymo-core'),
                'label_off'    => __('Hide', 'gifymo-core'),
                'prefix_class' => 'elementor-show-line-',
            ]
        );

        $this->add_responsive_control(
            'underline_width',
            [
                'label'      => __('Width', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.elementor-show-line-yes .elementor-heading-title:before' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'show_line' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label'       => __('Sub Title', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('Enter your subtitle', 'gifymo-core'),
                'default'     => __('', 'gifymo-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'sub_title_position',
            [
                'label'        => __('Position', 'gifymo-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'below',
                'options'      => [
                    'above' => __('Above', 'gifymo-core'),
                    'below' => __('Below', 'gifymo-core'),
                ],
                'prefix_class' => 'elementor-position-',
            ]
        );


        $this->add_control(
            'link',
            [
                'label'     => __('Link', 'gifymo-core'),
                'type'      => Controls_Manager::URL,
                'dynamic'   => [
                    'active' => true,
                ],
                'default'   => [
                    'url' => '',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'size',
            [
                'label'   => __('Size', 'gifymo-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __('Default', 'gifymo-core'),
                    'small'   => __('Small', 'gifymo-core'),
                    'medium'  => __('Medium', 'gifymo-core'),
                    'large'   => __('Large', 'gifymo-core'),
                    'xl'      => __('XL', 'gifymo-core'),
                    'xxl'     => __('XXL', 'gifymo-core'),
                ],
            ]
        );

        $this->add_control(
            'header_size',
            [
                'label'   => __('HTML Tag', 'gifymo-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'h2',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'        => __('Alignment', 'gifymo-core'),
                'type'         => Controls_Manager::CHOOSE,
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
                        'title' => __('Justified', 'gifymo-core'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-position-',
                'default'      => '',
                'selectors'    => [
                    '{{WRAPPER}} .elementor-heading-wrapper' => 'text-align: {{VALUE}};',
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

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __('Title', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Text Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}}.elementor-widget-heading .elementor-heading-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'line_color',
            [
                'label'     => __('Line Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}}.elementor-show-line-yes  .elementor-heading-title:before' => 'background-image: radial-gradient(circle at 1.5px, {{VALUE}} .75px, rgba(255, 255, 255, 0) 1.5px);',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'text_shadow',
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_control(
            'blend_mode',
            [
                'label'     => __('Blend Mode', 'gifymo-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''            => __('Normal', 'gifymo-core'),
                    'multiply'    => 'Multiply',
                    'screen'      => 'Screen',
                    'overlay'     => 'Overlay',
                    'darken'      => 'Darken',
                    'lighten'     => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation'  => 'Saturation',
                    'color'       => 'Color',
                    'difference'  => 'Difference',
                    'exclusion'   => 'Exclusion',
                    'hue'         => 'Hue',
                    'luminosity'  => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_sub_title_style',
            [
                'label' => __('Sub Title', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sub_title_color',
            [
                'label'     => __('Text Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-heading .sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'subtitle_typography',
                'selector' => '{{WRAPPER}}.elementor-widget-heading .sub-title',
            ]
        );

        $this->add_responsive_control(
            'sub_title_spacing',
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
                    '{{WRAPPER}}.elementor-position-below .sub-title' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-above .sub-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    /**
     * Render heading widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['title'])) {
            return;
        }

        $this->add_render_attribute('title', 'class', 'elementor-heading-title');

        $this->add_render_attribute('title_wrapper', 'class', 'elementor-heading-wrapper');

        if (!empty($settings['size'])) {
            $this->add_render_attribute('title', 'class', 'elementor-size-' . $settings['size']);
        }

        $this->add_inline_editing_attributes('title');

        $title = $settings['title'];

        $title_html = '';

        if (!empty($settings['link']['url'])) {
            $this->add_render_attribute('url', 'href', $settings['link']['url']);

            if ($settings['link']['is_external']) {
                $this->add_render_attribute('url', 'target', '_blank');
            }

            if (!empty($settings['link']['nofollow'])) {
                $this->add_render_attribute('url', 'rel', 'nofollow');
            }

            $title = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $title);
        }

        $title_html .= sprintf('<div %1$s >', $this->get_render_attribute_string('title_wrapper'));

        $title_html .= '<div class="elementor-heading-wrapper-inner">';

        $title_html .= sprintf('<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string('title'), $title);

        if ($settings['sub_title']) {

            $title_html .= '<span class="sub-title">' . $settings['sub_title'] . '</span>';
        }
        $title_html .= '</div>';


        $title_html .= '</div>';

        echo $title_html;
    }

    /**
     * Render heading widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function content_template() {

    }
}

$widgets_manager->register(new OSF_Elementor_Heading());