<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class OSF_Elementor_Vertical_Scroll extends Widget_Base {

    public function get_name() {
        return 'opal-vertical-scroll';
    }

    public function get_title() {
        return __('Opal Vertical Scroll', 'gifymo-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_script_depends() {
        return array('osf-vscroll');
    }

    protected function register_controls() {

        $templates = Plugin::instance()->templates_manager->get_source('local')->get_items();

        $options = [
            '0' => '— ' . __('Select', 'gifymo-core') . ' —',
        ];

        $types = [];

        foreach ($templates as $template) {
            $options[$template['template_id']] = $template['title'] . ' (' . $template['type'] . ')';
            $types[$template['template_id']]   = $template['type'];
        }

        $this->start_controls_section('content_templates',
            [
                'label' => __('Content', 'gifymo-core'),
            ]
        );

        $this->add_control('template_height_hint',
            [
                'label' => '<span style="line-height: 1.4em;"><b>Important<br></b></span><ul style="line-height: 1.2"><li>1- Section Height needs to be set to default.</li><li>2- It\'s recommended that templates be the same height.</li><li>3- For navigation menu, you will need to add navigation menu items first</li></ul>',
                'type'  => Controls_Manager::RAW_HTML,

            ]
        );

        $this->add_control('content_type',
            [
                'label'       => __('Content Type', 'gifymo-core'),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    'ids'       => __('Section ID', 'gifymo-core'),
                    'templates' => __('Elementor Templates', 'gifymo-core')
                ],
                'default'     => 'templates',
                'description' => __('Choose which method you prefer to insert sections.', 'gifymo-core')
            ]
        );

        $temp_repeater = new REPEATER();

        $temp_repeater->add_control('section_template',
            [
                'label'    => __('Elementor Template', 'gifymo-core'),
                'type'     => Controls_Manager::SELECT,
                'options'  => $options,
                'types'    => $types,
                'multiple' => false,
            ]
        );

        $this->add_control('section_repeater',
            [
                'label'       => __('Sections', 'gifymo-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $temp_repeater->get_controls(),
                'condition'   => [
                    'content_type' => 'templates'
                ],
                'title_field' => '{{{ section_template }}}'
            ]
        );

        $id_repeater = new REPEATER();

        $id_repeater->add_control('section_id',
            [
                'label'   => __('Section ID', 'gifymo-core'),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control('id_repeater',
            [
                'label'       => __('Sections', 'gifymo-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $id_repeater->get_controls(),
                'condition'   => [
                    'content_type' => 'ids'
                ],
                'title_field' => '{{{ section_id }}}'
            ]
        );

        $this->add_control('dots_tooltips_switcher',
            [
                'label'   => __('Dots Tooltips', 'gifymo-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control('dots_shape',
            [
                'label'     => __('Shape', 'gifymo-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'circ'  => __('Circles', 'gifymo-core'),
                    'lines' => __('Lines', 'gifymo-core')
                ],
                'default'   => 'circ',
                'condition' => [
                    'dots_tooltips_switcher' => 'yes'
                ]
            ]
        );

        $this->add_control('dots_tooltips',
            [
                'label'       => __('Dots Tooltips Text', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'description' => __('Add text for each navigation dot separated by \',\'', 'gifymo-core'),
                'condition'   => [
                    'dots_tooltips_switcher' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('nav_menu',
            [
                'label' => __('Navigation', 'gifymo-core'),
            ]
        );

        $this->add_control('nav_menu_switch',
            [
                'label'       => __('Navigation Menu', 'gifymo-core'),
                'type'        => Controls_Manager::SWITCHER,
                'description' => __('This option works only on the frontend', 'gifymo-core'),
            ]
        );

        $this->add_control('navigation_menu_pos',
            [
                'label'     => __('Position', 'gifymo-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'left'  => __('Left', 'gifymo-core'),
                    'right' => __('Right', 'gifymo-core'),
                ],
                'default'   => 'left',
                'condition' => [
                    'nav_menu_switch' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control('navigation_menu_pos_offset_top',
            [
                'label'      => __('Offset Top', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .osf-vscroll-nav-menu' => 'top: {{SIZE}}{{UNIT}};'
                ],
                'condition'  => [
                    'nav_menu_switch' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control('navigation_menu_pos_offset_left',
            [
                'label'      => __('Offset Left', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .osf-vscroll-nav-menu.left' => 'left: {{SIZE}}{{UNIT}};'
                ],
                'condition'  => [
                    'nav_menu_switch'     => 'yes',
                    'navigation_menu_pos' => 'left'
                ]
            ]
        );

        $this->add_responsive_control('navigation_menu_pos_offset_right',
            [
                'label'      => __('Offset Right', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .osf-vscroll-nav-menu.right' => 'right: {{SIZE}}{{UNIT}};'
                ],
                'condition'  => [
                    'nav_menu_switch'     => 'yes',
                    'navigation_menu_pos' => 'right'
                ]
            ]
        );

        $nav_repeater = new REPEATER();

        $nav_repeater->add_control('nav_menu_item',
            [
                'label'   => __('List Item', 'gifymo-core'),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control('nav_menu_repeater',
            [
                'label'       => __('Menu Items', 'gifymo-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $nav_repeater->get_controls(),
                'title_field' => '{{{ nav_menu_item }}}',
                'condition'   => [
                    'nav_menu_switch' => 'yes'
                ]
            ]
        );

        $this->add_control('navigation_dots_pos',
            [
                'label'   => __('Dots Horizontal Position', 'gifymo-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'left'  => __('Left', 'gifymo-core'),
                    'right' => __('Right', 'gifymo-core'),
                ],
                'default' => 'right'
            ]
        );

        $this->add_control('navigation_dots_v_pos',
            [
                'label'   => __('Dots Vertical Position', 'gifymo-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'top'    => __('Top', 'gifymo-core'),
                    'middle' => __('Middle', 'gifymo-core'),
                    'bottom' => __('Bottom', 'gifymo-core'),
                ],
                'default' => 'middle'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('advanced_settings',
            [
                'label' => __('Scroll Settings', 'gifymo-core'),
            ]
        );

        $this->add_control('scroll_speed',
            [
                'label'       => __('Scroll Speed', 'gifymo-core'),
                'type'        => Controls_Manager::NUMBER,
                'description' => __('Set scolling speed in seconds, default: 0.7', 'gifymo-core'),
            ]
        );

        $this->add_control('full_section',
            [
                'label'   => __('Full Section Scroll', 'gifymo-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control('full_section_touch',
            [
                'label'     => __('Full Section Scroll on Touch', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'full_section' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('navigation_style',
            [
                'label' => __('Navigation Dots', 'gifymo-core'),
                'tab'   => CONTROLS_MANAGER::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('navigation_style_tabs');

        $this->start_controls_tab('tooltips_style_tab',
            [
                'label'     => __('Tooltips', 'gifymo-core'),
                'condition' => [
                    'dots_tooltips_switcher' => 'yes'
                ]
            ]
        );

        $this->add_control('tooltips_color',
            [
                'label'     => __('Tooltips Text Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .osf-vscroll-tooltip' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'dots_tooltips_switcher' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'tooltips_typography',
                'selector'  => '{{WRAPPER}} .osf-vscroll-tooltip span',
                'condition' => [
                    'dots_tooltips_switcher' => 'yes'
                ]
            ]
        );

        $this->add_control('tooltips_background',
            [
                'label'     => __('Tooltips Background', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .osf-vscroll-tooltip'                                                   => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .osf-vscroll-inner .osf-vscroll-dots.right .osf-vscroll-tooltip::after' => 'border-left-color: {{VALUE}}',
                    '{{WRAPPER}} .osf-vscroll-inner .osf-vscroll-dots.left .osf-vscroll-tooltip::after'  => 'border-right-color: {{VALUE}}',
                ],
                'condition' => [
                    'dots_tooltips_switcher' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'tooltips_border',
                'selector'  => '{{WRAPPER}} .osf-vscroll-tooltip',
                'condition' => [
                    'dots_tooltips_switcher' => 'yes'
                ]
            ]
        );

        $this->add_control('tooltips_border_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .osf-vscroll-tooltip' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'dots_tooltips_switcher' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'tooltips_shadow',
                'selector'  => '{{WRAPPER}} .osf-vscroll-tooltip',
                'condition' => [
                    'dots_tooltips_switcher' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control('tooltips_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .osf-vscroll-tooltip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'dots_tooltips_switcher' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control('tooltips_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .osf-vscroll-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'dots_tooltips_switcher' => 'yes'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('dots_style_tab',
            [
                'label' => __('Dots', 'gifymo-core'),
            ]
        );

        $this->add_control('dots_color',
            [
                'label'     => __('Dots Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .osf-vscroll-dots .osf-vscroll-nav-link span' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control('active_dot_color',
            [
                'label'     => __('Active Dot Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .osf-vscroll-dots li.active .osf-vscroll-nav-link span' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control('dots_border_color',
            [
                'label'     => __('Dots Border Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .osf-vscroll-dots .osf-vscroll-nav-link span' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('container_style_tab',
            [
                'label' => __('Container', 'gifymo-core'),
            ]
        );

        $this->add_control('navigation_background',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .osf-vscroll-dots' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control('navigation_border_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .osf-vscroll-dots' => 'border-radius: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'    => __('Shadow', 'gifymo-core'),
                'name'     => 'navigation_box_shadow',
                'selector' => '{{WRAPPER}} .osf-vscroll-dots',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('navigation_menu_style',
            [
                'label'     => __('Navigation Menu', 'gifymo-core'),
                'tab'       => CONTROLS_MANAGER::TAB_STYLE,
                'condition' => [
                    'nav_menu_switch' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'navigation_items_typography',
                'selector' => '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item .osf-vscroll-nav-link'
            ]
        );

        $this->start_controls_tabs('navigation_menu_style_tabs');

        $this->start_controls_tab('normal_style_tab',
            [
                'label' => __('Normal', 'gifymo-core'),
            ]
        );

        $this->add_control('normal_color',
            [
                'label'     => __('Text Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item .osf-vscroll-nav-link' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control('normal_hover_color',
            [
                'label'     => __('Text Hover Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item .osf-vscroll-nav-link:hover' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control('normal_background',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'    => __('Shadow', 'gifymo-core'),
                'name'     => 'normal_shadow',
                'selector' => '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('active_style_tab',
            [
                'label' => __('Active', 'gifymo-core'),
            ]
        );

        $this->add_control('active_color',
            [
                'label'     => __('Text Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item.active .osf-vscroll-nav-link' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control('active_hover_color',
            [
                'label'     => __('Text Hover Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item.active .osf-vscroll-nav-link:hover' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control('active_background',
            [
                'label'     => __('Background Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item.active' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'    => __('Shadow', 'gifymo-core'),
                'name'     => 'active_shadow',
                'selector' => '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item.active'
            ]
        );

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'navigation_items_border',
                'selector'  => '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item',
                'separator' => 'before'
            ]
        );

        $this->add_control('navigation_items_border_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control('navigation_items_margin',
            [
                'label'      => __('Margin', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control('navigation_items_padding',
            [
                'label'      => __('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .osf-vscroll-nav-menu .osf-vscroll-nav-item .osf-vscroll-nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $id = $this->get_id();

        $dots_text = explode(',', $settings['dots_tooltips']);

        $this->add_render_attribute('vertical_scroll_wrapper', 'class', 'osf-vscroll-wrap');

        $this->add_render_attribute('vertical_scroll_wrapper', 'id', 'osf-vscroll-wrap-' . $id);

        $this->add_render_attribute('vertical_scroll_inner', 'class', array('osf-vscroll-inner'));

        $this->add_render_attribute('vertical_scroll_inner', 'id', 'osf-vscroll-' . $id);

        $this->add_render_attribute('vertical_scroll_dots', 'class', array(
                'osf-vscroll-dots',
                $settings['navigation_dots_pos'],
                $settings['navigation_dots_v_pos'],
                $settings['dots_shape']
            )
        );

        $this->add_render_attribute('vertical_scroll_dots_list', 'class', array('osf-vscroll-dots-list'));

        $this->add_render_attribute('vertical_scroll_menu', 'id', 'osf-vscroll-nav-menu-' . $id);

        $this->add_render_attribute('vertical_scroll_menu', 'class', array('osf-vscroll-nav-menu', $settings['navigation_menu_pos']));

        $this->add_render_attribute('vertical_scroll_sections_wrap', 'id', 'osf-vscroll-sections-wrap-' . $id);

        $this->add_render_attribute('vertical_scroll_sections_wrap', 'class', 'osf-vscroll-sections-wrap');

        $vscroll_settings = [
            'id'          => $id,
            'speed'       => !empty($settings['scroll_speed']) ? $settings['scroll_speed'] * 1000 : 700,
            'tooltips'    => 'yes' == $settings['dots_tooltips_switcher'] ? true : false,
            'dotsText'    => $dots_text,
            'dotsPos'     => $settings['navigation_dots_pos'],
            'dotsVPos'    => $settings['navigation_dots_v_pos'],
            'fullSection' => 'yes' == $settings['full_section'] ? true : false,
            'fullTouch'   => 'yes' == $settings['full_section_touch'] ? true : false
        ];

        $templates = 'templates' === $settings['content_type'] ? $settings['section_repeater'] : $settings['id_repeater'];

        $checkType = 'templates' === $settings['content_type'] ? true : false;

        $nav_items = $settings['nav_menu_repeater'];

        ?>

        <div <?php echo $this->get_render_attribute_string('vertical_scroll_wrapper'); ?> data-settings='<?php echo wp_json_encode($vscroll_settings); ?>'>
            <?php if ('yes' == $settings['nav_menu_switch']) : ?>
                <ul <?php echo $this->get_render_attribute_string('vertical_scroll_menu'); ?>>
                    <?php foreach ($nav_items as $index => $item) : ?>
                        <li data-menuanchor="<?php echo $checkType ? 'section_' . $id . $index : $templates[$index]['section_id']; ?>" class="osf-vscroll-nav-item">
                            <div class="osf-vscroll-nav-link"><?php echo $item['nav_menu_item'] ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <div <?php echo $this->get_render_attribute_string('vertical_scroll_inner'); ?>>
                <div <?php echo $this->get_render_attribute_string('vertical_scroll_dots'); ?>>
                    <ul <?php echo $this->get_render_attribute_string('vertical_scroll_dots_list'); ?>>
                        <?php foreach ($templates as $index => $section) : ?>
                            <li data-index="<?php echo $index; ?>" data-menuanchor="<?php echo $checkType ? 'section_' . $id . $index : $templates[$index]['section_id']; ?>" class="osf-vscroll-dot-item">
                                <div class="osf-vscroll-nav-link"><span></span></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php if ('templates' === $settings['content_type']) : ?>
                    <div <?php echo $this->get_render_attribute_string('vertical_scroll_sections_wrap'); ?>>

                        <?php foreach ($templates as $index => $section) :
                            $this->add_render_attribute('section_' . $index, 'class', ['osf-vscroll-temp', 'osf-vscroll-temp-' . $id]);
                            $this->add_render_attribute('section_' . $index, 'id', 'section_' . $id . $index);
                            ?>
                            <div <?php echo $this->get_render_attribute_string('section_' . $index); ?>>
                                <?php
                                echo Plugin::instance()->frontend->get_builder_content_for_display($section['section_template']);
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    <?php }
}

$widgets_manager->register(new OSF_Elementor_Vertical_Scroll());