<?php


use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class OSF_Elementor_Countdown extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-countdown';
    }

    public function get_title() {
        return __('Opal Countdown', 'gifymo-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_icon() {
        return 'eicon-countdown';
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_countdown',
            [
                'label' => __('Countdown', 'gifymo-core'),
            ]
        );

        $this->add_control(
            'due_date',
            [
                'label'       => __('Due Date', 'gifymo-core'),
                'type'        => Controls_Manager::DATE_TIME,
                'default'     => date('Y-m-d H:i', strtotime('+1 month') + (get_option('gmt_offset') * HOUR_IN_SECONDS)),
                /* translators: %s: Time zone. */
                'description' => sprintf(__('Date set according to your timezone: %s.', 'gifymo-core'), Utils::get_timezone_string()),
            ]
        );

        $this->add_control(
            'show_days',
            [
                'label'     => __('Days', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'gifymo-core'),
                'label_off' => __('Hide', 'gifymo-core'),
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'show_hours',
            [
                'label'     => __('Hours', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'gifymo-core'),
                'label_off' => __('Hide', 'gifymo-core'),
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'show_minutes',
            [
                'label'     => __('Minutes', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'gifymo-core'),
                'label_off' => __('Hide', 'gifymo-core'),
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'show_seconds',
            [
                'label'     => __('Seconds', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'gifymo-core'),
                'label_off' => __('Hide', 'gifymo-core'),
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'show_labels',
            [
                'label'     => __('Show Label', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'gifymo-core'),
                'label_off' => __('Hide', 'gifymo-core'),
                'default'   => 'yes',
                'separator' => 'before',
            ]
        );


        $this->add_control(
            'custom_labels',
            [
                'label'     => __('Custom Label', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'show_labels!' => '',
                ],
            ]
        );

        $this->add_control(
            'label_days',
            [
                'label'       => __('Days', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Days', 'gifymo-core'),
                'placeholder' => __('Days', 'gifymo-core'),
                'condition'   => [
                    'show_labels!'   => '',
                    'custom_labels!' => '',
                    'show_days'      => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_hours',
            [
                'label'       => __('Hours', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Hours', 'gifymo-core'),
                'placeholder' => __('Hours', 'gifymo-core'),
                'condition'   => [
                    'show_labels!'   => '',
                    'custom_labels!' => '',
                    'show_hours'     => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_minutes',
            [
                'label'       => __('Minutes', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Minutes', 'gifymo-core'),
                'placeholder' => __('Minutes', 'gifymo-core'),
                'condition'   => [
                    'show_labels!'   => '',
                    'custom_labels!' => '',
                    'show_minutes'   => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_seconds',
            [
                'label'       => __('Seconds', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Seconds', 'gifymo-core'),
                'placeholder' => __('Seconds', 'gifymo-core'),
                'condition'   => [
                    'show_labels!'   => '',
                    'custom_labels!' => '',
                    'show_seconds'   => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'     => __('Show title', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'gifymo-core'),
                'label_off' => __('Hide', 'gifymo-core'),
                'default'   => 'no',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_title',
            [
                'label'       => __('Title', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Title', 'gifymo-core'),
                'placeholder' => __('Title', 'gifymo-core'),
                'condition'   => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_box_style',
            [
                'label' => __('Boxes', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'container_width',
            [
                'label'      => __('Container Width', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-opal-countdown' => 'max-width: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_width',
            [
                'label'      => __('Items Width', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-countdown-item' => 'width: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'items_height',
            [
                'label'      => __('Items Height', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-countdown-item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_background_color',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-countdown-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'show_divider',
            [
                'label'     => __('Show Divider', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-countdown-item:after' => 'content: "";',
                ],
            ]
        );

        $this->add_responsive_control(
            'divider_size',
            [
                'label'     => __('Size Divider', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-countdown-item:after' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_divider!' => '',
                ],
            ]
        );

        $this->add_control(
            'divider_color',
            [
                'label'     => __('Divider Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-countdown-item:after' => 'background-color: {{VALUE}};',
                ],
                'default'   => '',
                'condition' => [
                    'show_divider!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'box_border',
                'selector' => '{{WRAPPER}} .elementor-countdown-item',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-countdown-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_spacing',
            [
                'label'     => __('Space Between', 'gifymo-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 10,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .elementor-countdown-item:not(:first-of-type)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body:not(.rtl) {{WRAPPER}} .elementor-countdown-item:not(:last-of-type)'  => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body.rtl {{WRAPPER}} .elementor-countdown-item:not(:first-of-type)'       => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body.rtl {{WRAPPER}} .elementor-countdown-item:not(:last-of-type)'        => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body.rtl {{WRAPPER}} .elementor-countdown-item'                           => 'margin-bottom: calc( {{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-countdown-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_control(
            'digits_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-countdown-digits' => 'color: {{VALUE}};',
                ],
                'default'   => ''
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'digits_typography',
                'selector' => '{{WRAPPER}} .elementor-countdown-digits',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_digits',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-countdown-digits',
            ]
        );

        $this->add_responsive_control(
            'digits_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-countdown-digits' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label'     => __('Title', 'gifymo-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'label_title!' => '',
                    'show_title'   => 'yes',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'selector'  => '{{WRAPPER}} .elementor-opal-countdown-title',
                'condition' => [
                    'label_title!' => '',
                    'show_title'   => 'yes',
                ],
            ]

        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-opal-countdown-title' => 'color: {{VALUE}};',
                ],
                'default'   => '',
                'condition' => [
                    'label_title!' => '',
                    'show_title'   => 'yes',
                ],
            ]
        );


        $this->add_control(
            'heading_label',
            [
                'label'     => __('Label', 'gifymo-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-countdown-label' => 'color: {{VALUE}};',
                ],
                'default'   => ''
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'label_typography',
                'selector' => '{{WRAPPER}} .elementor-countdown-label',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_label',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-countdown-label',
            ]
        );

        $this->add_responsive_control(
            'label_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-countdown-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    private function get_strftime($instance) {
        $string = '';
        if ($instance['show_days']) {
            $string .= $this->render_countdown_item($instance, 'label_days', 'elementor-countdown-days');
        }
        if ($instance['show_hours']) {
            $string .= $this->render_countdown_item($instance, 'label_hours', 'elementor-countdown-hours');
        }
        if ($instance['show_minutes']) {
            $string .= $this->render_countdown_item($instance, 'label_minutes', 'elementor-countdown-minutes');
        }
        if ($instance['show_seconds']) {
            $string .= $this->render_countdown_item($instance, 'label_seconds', 'elementor-countdown-seconds');
        }

        return $string;
    }

    private $_default_countdown_labels;

    private function _init_default_countdown_labels() {
        $this->_default_countdown_labels = [
            'label_title'   => __('Countdown', 'gifymo-core'),
            'label_months'  => __('Months', 'gifymo-core'),
            'label_weeks'   => __('Weeks', 'gifymo-core'),
            'label_days'    => __('Days', 'gifymo-core'),
            'label_hours'   => __('Hours', 'gifymo-core'),
            'label_minutes' => __('Minutes', 'gifymo-core'),
            'label_seconds' => __('Seconds', 'gifymo-core'),
        ];
    }

    public function get_default_countdown_labels() {
        if (!$this->_default_countdown_labels) {
            $this->_init_default_countdown_labels();
        }

        return $this->_default_countdown_labels;
    }

    private function render_countdown_item($instance, $label, $part_class) {
        $string = '<div class="elementor-countdown-item"><span class="elementor-countdown-digits ' . $part_class . '"></span>';

        if ($instance['show_labels']) {
            $default_labels = $this->get_default_countdown_labels();
            $label          = ($instance['custom_labels']) ? $instance[$label] : $default_labels[$label];
            $string         .= ' <span class="elementor-countdown-label">' . $label . '</span>';
        }

        $string .= '</div>';

        return $string;
    }

    protected function render() {
        $instance = $this->get_settings();

        $due_date = $instance['due_date'];
        $string   = $this->get_strftime($instance);

        // Handle timezone ( we need to set GMT time )
        $due_date = strtotime($due_date) - (get_option('gmt_offset') * HOUR_IN_SECONDS);
//        'label_title!' => '',
//                    'show_title'   => 'yes',
        ?>
        <div class="elementor-opal-countdown-wrapper">
            <?php if ($instance['show_title'] && $instance['label_title'] != ''): ?>
                <div class="elementor-opal-countdown-title"><?php echo esc_html($instance['label_title']) ?></div>
            <?php endif; ?>
            <div class="elementor-opal-countdown" data-date="<?php echo $due_date; ?>">
                <?php echo $string; ?>
            </div>
        </div>
        <?php
    }
}

$widgets_manager->register(new OSF_Elementor_Countdown());