<?php

//namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Control_Media;

class OSF_Elementor_Timeline extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-timeline';
    }

    public function get_title() {
        return __('Opal Timeline', 'gifymo-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_script_depends() {
        return [
            'timeline',
            'parallaxmouse',
            'tweenmax',
            'tilt',
            'waypoints',
        ];
    }

    public static function get_button_sizes() {
        return [
            'xs' => __('Extra Small', 'gifymo-core'),
            'sm' => __('Small', 'gifymo-core'),
            'md' => __('Medium', 'gifymo-core'),
            'lg' => __('Large', 'gifymo-core'),
            'xl' => __('Extra Large', 'gifymo-core'),
        ];
    }

    public static function get_slide() {
        if (!osf_is_revslider_activated()) {
            return;
        }
        $slider     = new RevSlider();
        $arrSliders = $slider->getArrSliders();

        $revsliders = array();
        if ($arrSliders) {
            foreach ($arrSliders as $slider) {
                /** @var $slider RevSlider */
                $revsliders[$slider->getAlias()] = $slider->getTitle();
            }
        } else {
            $revsliders[0] = __('No sliders found', 'gifymo-core');
        }
        return $revsliders;
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_general',
            [
                'label' => __('General', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'type',
            [
                'label'        => __('Type', 'gifymo-core'),
                //                'type'         => Controls_Manager::SELECT,
                'type'         => Controls_Manager::HIDDEN,
                'default'      => 'vertical',
                'options'      => [
                    'horizontal' => __('Horizontal', 'gifymo-core'),
                    'vertical'   => __('Vertical', 'gifymo-core'),
                ],
                'prefix_class' => 'elementor-timeline-view-',
                'separator'    => 'before',
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'     => __('Columns', 'gifymo-core'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 3,
                'options'   => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6],
                'condition' => [
                    'type' => 'horizontal',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'year',
            [
                'label'       => __('Year', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('2021', 'gifymo-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label'       => __('Title & Content', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Timeline Title', 'gifymo-core'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'content',

            [
                'label'      => __('Content', 'gifymo-core'),
                'type'       => Controls_Manager::WYSIWYG,
                'default'    => __('Timeline Content', 'gifymo-core'),
                'show_label' => false,
            ]
        );
        $repeater->add_control(
            'content_animation',
            [
                'label'              => __('Content Animation', 'gifymo-core'),
                'type'               => Controls_Manager::ANIMATION,
                'frontend_available' => true,
            ]
        );
        $repeater->add_control(
            'content_animation_duration',
            [
                'label'     => __('Animation Duration', 'gifymo-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    'slow' => __('Slow', 'gifymo-core'),
                    ''     => __('Normal', 'gifymo-core'),
                    'fast' => __('Fast', 'gifymo-core'),
                ],
                'condition' => [
                    'content_animation!' => '',
                ],
            ]
        );
        $repeater->add_control(
            'content_animation_delay',
            [
                'label'              => __('Animation Delay', 'gifymo-core') . ' (ms)',
                'type'               => Controls_Manager::NUMBER,
                'default'            => '',
                'min'                => 0,
                'step'               => 100,
                'condition'          => [
                    'content_animation!' => '',
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
            ]
        );
        $repeater->add_control(
            'heading_image',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __('Image', 'gifymo-core'),
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'image_type',
            [
                'label'   => __('Type', 'gifymo-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'image',
                'options' => array(
                    'image' => esc_html__('Image', 'gifymo-core'),
                    'slide' => esc_html__('Slide', 'gifymo-core'),
                ),
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label'     => __('Choose Image', 'gifymo-core'),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'image_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'rev_alias',
            [
                'label'     => __('Revolution Slider', 'gifymo-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => $this->get_slide(),
                'default'   => '',
                'condition' => [
                    'image_type' => 'slide',
                ],
            ]
        );

        $repeater->add_control(
            'image_animation',
            [
                'label'              => __('Image Animation', 'gifymo-core'),
                'type'               => Controls_Manager::ANIMATION,
                'frontend_available' => true,
            ]
        );
        $repeater->add_control(
            'image_animation_duration',
            [
                'label'     => __('Animation Duration', 'gifymo-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    'slow' => __('Slow', 'gifymo-core'),
                    ''     => __('Normal', 'gifymo-core'),
                    'fast' => __('Fast', 'gifymo-core'),
                ],
                'condition' => [
                    'image_animation!' => '',
                ],
            ]
        );
        $repeater->add_control(
            'image_animation_delay',
            [
                'label'              => __('Animation Delay', 'gifymo-core') . ' (ms)',
                'type'               => Controls_Manager::NUMBER,
                'default'            => '',
                'min'                => 0,
                'step'               => 100,
                'condition'          => [
                    'image_animation!' => '',
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
            ]
        );

        $repeater->add_control(
            'buttom',
            [
                'label'       => __('Buttom', 'gifymo-core'),
                'type'        => Controls_Manager::TEXT,
                'separator'   => 'before',
                'placeholder' => __('Buttom name', 'gifymo-core'),

                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'link',
            [
                'label'       => __('Link', 'gifymo-core'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com', 'gifymo-core'),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $repeater->add_control(
            'activate',
            [
                'label'     => __('Activate', 'gifymo-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_off' => __('Off', 'gifymo-core'),
                'label_on'  => __('On', 'gifymo-core'),
            ]
        );


        $this->add_control(
            'timeline_list',
            [
                'label'       => __('Timeline Items', 'gifymo-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'title'   => __('Timeline #1', 'gifymo-core'),
                        'content' => __('If you remember the very first time you have met with the person you love or your friend, it would be nice to let the person know that you still remember that very moment.', 'gifymo-core'),
                        'image'   => Utils::get_placeholder_image_src(),
                        'bottom'  => '',
                        'link'    => '#'
                    ],
                    [
                        'title'   => __('Timeline #2', 'gifymo-core'),
                        'content' => __('If you remember the very first time you have met with the person you love or your friend, it would be nice to let the person know that you still remember that very moment.', 'gifymo-core'),
                        'image'   => Utils::get_placeholder_image_src(),
                        'bottom'  => '',
                        'link'    => '#'
                    ],
                    [
                        'title'   => __('Timeline #3', 'gifymo-core'),
                        'content' => __('If you remember the very first time you have met with the person you love or your friend, it would be nice to let the person know that you still remember that very moment.', 'gifymo-core'),
                        'image'   => Utils::get_placeholder_image_src(),
                        'bottom'  => '',
                        'link'    => '#'
                    ],
                ],
                'title_field' => '{{{ title }}}',

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_item_style',
            [
                'label' => __('Item', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]

        );

        $this->add_control(
            'content_align_mobile',
            [
                'label'     => __('Alignment Mobile', 'gifymo-core'),
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
                'selectors' => [
                    '(mobile){{WRAPPER}} .timeline-content ' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control('padding',
            [
                'label'      => esc_html__('Padding', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .timeline-content ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'item_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .timeline-content ',
            ]
        );
        $this->add_responsive_control(
            'item_spacing_item',
            [
                'label'      => __('Spacing', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .timeline-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_image_style',
            [
                'label' => __('Image', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]

        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'thumbnail',
                'label'   => esc_html__('Alt', 'gifymo-core'),
                'default' => 'full',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => __('Border Radius', 'gifymo-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-team-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_spacing_item',
            [
                'label'      => __('Spacing', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .timeline-thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'year_style',
            [
                'label' => __('Year', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'year_color',
            [
                'label'     => __('Year Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .timeline-year' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'background_year',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .timeline-year, {{WRAPPER}} .timeline-item .timeline-thumbnail:after',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'year_typography',
                'selector' => '{{WRAPPER}} .timeline-year',
            ]
        );

        $this->add_responsive_control(
            'year_spacing_item',
            [
                'label'      => __('Spacing', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .timeline-year' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'title_style',
            [
                'label' => __('Title', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title',
            [
                'label'     => __('Title', 'gifymo-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => __('Title Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .timeline-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .timeline-title',
            ]
        );
        $this->add_responsive_control(
            'title_spacing_item',
            [
                'label'      => __('Spacing', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .timeline-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'content_style',
            [
                'label' => __('Content', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'content_color',
            [
                'label'     => __('Color', 'gifymo-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .content',
            ]
        );
        $this->add_responsive_control(
            'content_spacing_item',
            [
                'label'      => __('Spacing', 'gifymo-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'buttom_style',
            [
                'label' => __('Butttom', 'gifymo-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'button_type',
            [
                'label'        => __('Type', 'gifymo-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'primary',
                'options'      => [
                    ''                  => __('Default', 'gifymo-core'),
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
            'buttom_size',
            [
                'label'          => __('Size', 'gifymo-core'),
                'type'           => Controls_Manager::SELECT,
                'default'        => 'md',
                'options'        => self::get_button_sizes(),
                'style_transfer' => true,
            ]
        );


        $this->end_controls_section();
    }

    public function set_render_attribute($element, $key = null, $value = null) {
        return $this->add_render_attribute($element, $key, $value, true);
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('timeline-wrapper', 'class', 'opal-timeline-wrapper');
        $this->add_render_attribute('timeline-wrapper', 'data-timeline-count', count($settings['timeline_list']));
        if ($settings['type'] == 'horizontal') {
            $this->add_render_attribute('opal-timeline', 'data-opal-columns', $settings['column']);
        }

        ?>

        <div <?php echo $this->get_render_attribute_string('timeline-wrapper'); ?>>
            <div class="opal-timeline" <?php echo $this->get_render_attribute_string('opal-timeline'); ?>>
                <?php
                foreach ($settings['timeline_list'] as $index => $item) :

                    //$thumbnail
                    $thumb_animation_dur = '';
                    $thumbnail = 'thumbnail_' . $index;

                    if ('' != $item['image_animation_duration']) {
                        $thumb_animation_dur = 'animated-' . $item['image_animation_duration'];
                    }
                    $thumb_animation_class = $item['image_animation'] ? $item['image_animation'] : '';

                    if (!empty($item['image_animation_delay'])) {
                        $this->add_render_attribute($thumbnail, 'data-timeline-animation-delay', $item['image_animation_delay']);
                    }
                    $this->add_render_attribute($thumbnail, 'class', 'timeline-thumbnail');
                    $this->add_render_attribute($thumbnail, 'class', 'timeline-animation');

                    $this->add_render_attribute($thumbnail, 'data-timeline-animation',
                        [
                            $thumb_animation_class,
                            $thumb_animation_dur,
                        ]
                    );

                    //content
                    $content_animation_dur = '';
                    $content               = 'content_' . $index;

                    if ('' != $item['content_animation_duration']) {
                        $content_animation_dur = 'animated-' . $item['content_animation_duration'];

                    }
                    $content_animation_class = $item['content_animation'] ? $item['content_animation'] : '';

                    if (!empty($item['content_animation_delay'])) {
                        $this->add_render_attribute($content, 'data-timeline-animation-delay', $item['content_animation_delay']);
                    }
                    $this->add_render_attribute($content, 'class', 'timeline-content');
                    $this->add_render_attribute($content, 'class', 'timeline-animation');
                    $this->add_render_attribute($content, 'data-timeline-animation',
                        [
                            $content_animation_class,
                            $content_animation_dur,
                        ]
                    );

                    //button
                    $link_key = 'link_' . $index;
                    $this->add_render_attribute($link_key, 'class', 'elementor-button');
                    $this->add_render_attribute($link_key, 'class', 'elementor-size-' . $settings['buttom_size']);
                    $class_item = $index;
                    if ($item['activate']) {
                        $class_item .= ' timeline-item-activate';
                    }

                    if (!empty($item['link']['url'])) {
                        $this->add_render_attribute($link_key, 'href', $item['link']['url']);
                        if ($item['link']['is_external']) {
                            $this->add_render_attribute($link_key, 'target', '_blank');
                        }

                        if ($item['link']['nofollow']) {
                            $this->add_render_attribute($link_key, 'rel', 'nofollow');
                        }

                        $image_src      = $item['image'];
                        $image_src_size = Group_Control_Image_Size::get_attachment_image_src($image_src['id'], 'thumbnail', $settings);

                        if (empty($image_src_size)) $image_src_size = $image_src['url'];
                    }

                    ?>

                    <div class="timeline-item column-item timeline-item-<?php echo esc_attr($class_item) ?>">

                        <?php if ($settings['type'] == 'vertical') : ?>
                            <?php if ($item['image_type'] == 'image' && !empty($item['image'])): ?>
                                <div <?php echo $this->get_render_attribute_string($thumbnail); ?>>
                                    <div class="timeline-image-wap">
                                        <img src="<?php echo $image_src_size; ?>" class="timeline-image d-block"
                                             alt="<?php echo esc_attr(Control_Media::get_image_alt($item['image'])); ?>">
                                    </div>
                                </div>
                            <?php else: ?>
                                <div <?php echo $this->get_render_attribute_string($thumbnail); ?>>
                                    <?php

                                    if (!$item['rev_alias']) {
                                        return;
                                    }
                                    echo apply_filters('opal_revslider_shortcode', do_shortcode('[rev_slider ' . $item['rev_alias'] . ']'));
                                    ?>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>

                        <div <?php echo $this->get_render_attribute_string($content); ?>>
                            <div class="timeline-content-wap">
                                <?php if (!empty($item['year'])) : ?>
                                    <div class="timeline-year"><?php echo $item['year']; ?></div>
                                <?php endif; ?>

                                <?php if (!empty($item['title'])) : ?>
                                    <h2 class="timeline-title"><?php echo $item['title']; ?></h2>
                                <?php endif; ?>

                                <?php if (!empty($item['content'])) : ?>
                                    <div class="content">
                                        <?php echo $this->parse_text_editor($item['content']); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($item['buttom'])) : ?>
                                    <div class="timeline-buttom">
                                        <a <?php echo $this->get_render_attribute_string($link_key); ?>>
                                            <?php echo $item['buttom']; ?>
                                        </a>
                                    </div>

                                <?php endif; ?>

                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php
    }
}

$widgets_manager->register(new OSF_Elementor_Timeline());