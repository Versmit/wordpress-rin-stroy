<?php
if (!defined( 'ABSPATH' )) {
    exit;
}
if (!class_exists( 'OSF_Customize' )){

class OSF_Customize {
    /**
     * @var array
     */
    private $google_fonts;
    
    /**
     * @var string
     */
    private $link_image;
    
    private $theme_domain;

    public function __construct() {
        add_action( 'customize_register', array( $this, 'customize_register' ) );
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     */
    public function customize_register($wp_customize) {
        /**
         * Theme options.
         */
        $this->google_fonts = osf_get_google_fonts();
        $this->link_image   = trailingslashit(get_site_url())  . 'wp-content/plugins/gifymo-core/assets/images/customize/';
        $this->theme_domain = get_template();

        $this->init_osf_typography( $wp_customize );

        $this->init_osf_colors( $wp_customize );

        $this->init_osf_layout( $wp_customize );

        $this->init_osf_header( $wp_customize );

        $this->init_osf_footer( $wp_customize );

        $this->init_osf_blog( $wp_customize );

        $this->init_osf_social( $wp_customize );

        if( otf_is_woocommerce_activated() ){
            $this->init_woocommerce( $wp_customize ); 
        }

        $this->init_osf_maintenance( $wp_customize );
   
        do_action( 'osf_customize_register', $wp_customize );
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_typography($wp_customize){
    
        $wp_customize->add_panel( 'osf_typography', array(
            'title'          => __( 'Typography', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'osf_typography_general', array(
            'title'          => __( 'General', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_typography', 
            'priority'       => 1, 
        ) );

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_typography_general_body_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_typography_general_body_button_move', array(
                'section' => 'osf_typography_general',
                'buttons'  => array(
                'osf_colors_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
                'osf_layout_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Primary Font
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_general_primary_font_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_general_primary_font_title', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Primary Font', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_general_body_font', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_general_body_font', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Font Family', 'gifymo-core' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_general_body_font', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Heading Font
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_general_secondary_font_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_general_secondary_font_title', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Heading Font', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_general_heading_font', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_general_heading_font', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Font Family', 'gifymo-core' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_general_heading_font', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Tertiary Font
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_general_tertiary_font_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_general_tertiary_font_title', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Tertiary Font', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_general_tertiary_font', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_general_tertiary_font', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Font Family', 'gifymo-core' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_general_tertiary_font', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Quaternary Font
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_general_quaternary_font_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_general_quaternary_font_title', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Quaternary Font', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_general_quaternary_font', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_general_quaternary_font', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Font Family', 'gifymo-core' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_general_quaternary_font', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Body
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_general_body_heading_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_general_body_heading_title', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Body', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Font Size
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_general_body_font_size', array(
                'default'           => '15',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_general_body_font_size', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Font Size', 'gifymo-core' ),
                'choices' => array(
                'min' => '10',
                'max' => '25',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_general_body_letter_spacing', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_general_body_letter_spacing', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Letter Spacing', 'gifymo-core' ),
                'choices' => array(
                'min' => '0',
                'max' => '10',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Heading
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_general_heading_heading_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_general_heading_heading_title', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Heading', 'gifymo-core' ),
            ) ) );
        }

        if(class_exists('OSF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'osf_typography_general_heading_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Font_Style( $wp_customize, 'osf_typography_general_heading_font_style', array(
                'section' => 'osf_typography_general',
            ) ) );
        }

        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_general_heading_letter_spacing', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_general_heading_letter_spacing', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Letter Spacing', 'gifymo-core' ),
                'choices' => array(
                'min' => __( '0', 'gifymo-core' ),
                'max' => __( '10', 'gifymo-core' ),
                'unit' => __( 'px', 'gifymo-core' ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_typography_button', array(
            'title'          => __( 'Button', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_button_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_button_font_family', array(
                'section' => 'osf_typography_button',
                'label' => __( 'Font Family', 'gifymo-core' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_button_font_family', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        if(class_exists('OSF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'osf_typography_button_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Font_Style( $wp_customize, 'osf_typography_button_font_style', array(
                'section' => 'osf_typography_button',
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_button_font_style', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_buttom_letter_spacing', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_buttom_letter_spacing', array(
                'section' => 'osf_typography_button',
                'label' => __( 'Letter Spacing', 'gifymo-core' ),
                'choices' => array(
                'min' => __( '0', 'gifymo-core' ),
                'max' => __( '10', 'gifymo-core' ),
                'unit' => __( 'px', 'gifymo-core' ),
            ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_colors($wp_customize){
    
        $wp_customize->add_panel( 'osf_colors', array(
            'title'          => __( 'Colors', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'osf_colors_general', array(
            'title'          => __( 'General', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_general_color_heading_label', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_general_color_heading_label', array(
                'section' => 'osf_colors_general',
                'label' => __( 'Color', 'gifymo-core' ),
                'priority' => 1,
            ) ) );
        }

        // =========================================
        // Primary Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_general_primary', array(
                'default'           => '#0160b4',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_general_primary', array(
                'section' => 'osf_colors_general',
                'label' => __( 'Primary Color', 'gifymo-core' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_general_primary', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Secondary Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_general_secondary', array(
                'default'           => '#00c484',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_general_secondary', array(
                'section' => 'osf_colors_general',
                'label' => __( 'Secondary Color', 'gifymo-core' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_general_secondary', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Heading Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_general_heading', array(
                'default'           => '#111',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_general_heading', array(
                'section' => 'osf_colors_general',
                'label' => __( 'Heading Color', 'gifymo-core' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_general_heading', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Body Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_general_body', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_general_body', array(
                'section' => 'osf_colors_general',
                'label' => __( 'Body Color', 'gifymo-core' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_general_body', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Body Background
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_general_body_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_general_body_title', array(
                'section' => 'osf_colors_general',
                'label' => __( 'Body Background', 'gifymo-core' ),
                'priority' => 2,
            ) ) );
        }

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_colors_general_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_colors_general_button_move', array(
                'section' => 'osf_colors_general',
                'buttons'  => array(
                'osf_typography_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Typography',
                ),
                'osf_layout_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_colors_page_title', array(
            'title'          => __( 'Page Title', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Background
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_page_title_bg_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_page_title_bg_title', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Background', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // BG Image
        // =========================================
        if(class_exists('WP_Customize_Image_Control')){
            $wp_customize->add_setting( 'osf_colors_page_title_bg_image', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'osf_colors_page_title_bg_image', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'BG Image', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // BG Position
        // =========================================
        if(class_exists('OSF_Customize_Control_Background_Position')){
            $wp_customize->add_setting( 'osf_colors_page_title_bg_position', array(
                'default'           => 'top left',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Background_Position( $wp_customize, 'osf_colors_page_title_bg_position', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'BG Position', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Disable Repeat
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_colors_page_title_bg_repeat', array(
                'default'           => '1',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_colors_page_title_bg_repeat', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Disable Repeat', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // BG Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_page_title_bg', array(
                'default'           => '#fafafa',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_page_title_bg', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'BG Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_page_title_bg', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_page_title_color_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_page_title_color_title', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Color', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Heading Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_page_title_heading_color', array(
                'default'           => '#000',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_page_title_heading_color', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Heading Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_page_title_heading_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Breadcrumb Text Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_page_title_breadcrumb_color', array(
                'default'           => '#666',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_page_title_breadcrumb_color', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Breadcrumb Text Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_page_title_breadcrumb_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Breadcrumb Text Color Hover
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_page_title_breadcrumb_color_hover', array(
                'default'           => '#000',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_page_title_breadcrumb_color_hover', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Breadcrumb Text Color Hover', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_page_title_breadcrumb_color_hover', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'osf_colors_buttons', array(
            'title'          => __( 'Buttons', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Enable Custom
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_colors_buttons_enable_custom', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_colors_buttons_enable_custom', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Enable Custom', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_enable_custom', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Primary Button
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_title_buttons_primary', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_title_buttons_primary', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Primary Button', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_bg', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_bg', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Background Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_bg', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_border', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_border', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Border Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_border', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_color', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color (outline)
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_color_outline', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_color_outline', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Color (outline)', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_color_outline', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Primary Button Hover
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_title_buttons_primary_hover', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_title_buttons_primary_hover', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Primary Button Hover', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_hover_bg', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_hover_bg', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Background Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_hover_bg', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_hover_border', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_hover_border', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Border Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_hover_border', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_hover_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_hover_color', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_hover_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Secondary Button
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_title_buttons_secondary', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_title_buttons_secondary', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Secondary Button', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_bg', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_bg', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Background Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_bg', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_border', array(
                'default'           => '#767676',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_border', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Border Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_border', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_color', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color (outline)
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_color_outline', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_color_outline', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Color (outline)', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_color_outline', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Secondary Button Hover
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_title_buttons_secondary_hover', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_title_buttons_secondary_hover', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Secondary Button Hover', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_hover_bg', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_hover_bg', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Background Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_hover_bg', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_hover_border', array(
                'default'           => '#767676',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_hover_border', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Border Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_hover_border', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_hover_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_hover_color', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Color', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_hover_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_layout($wp_customize){
    
        $wp_customize->add_panel( 'osf_layout', array(
            'title'          => __( 'Layout', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'osf_layout_general', array(
            'title'          => __( 'General', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_layout', 
            'priority'       => 1, 
        ) );

        if(class_exists('OSF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'osf_layout_general_layout_mode', array(
                'default'           => 'wide',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Group( $wp_customize, 'osf_layout_general_layout_mode', array(
                'section' => 'osf_layout_general',
                'choices' => array(
                'boxed' => __( 'Boxed', 'gifymo-core' ),
                'wide' => __( 'Wide', 'gifymo-core' ),
            ),
            ) ) );
        }

        // =========================================
        // Boxed Container Width
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_general_layout_boxed_width', array(
                'default'           => '1640',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_general_layout_boxed_width', array(
                'section' => 'osf_layout_general',
                'label' => __( 'Boxed Container Width', 'gifymo-core' ),
                'choices' => array(
                'min' => '767',
                'max' => '1920',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_general_layout_boxed_width', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Boxed Offset
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_general_layout_boxed_offset', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_general_layout_boxed_offset', array(
                'section' => 'osf_layout_general',
                'label' => __( 'Boxed Offset', 'gifymo-core' ),
                'choices' => array(
                'min' => '0',
                'max' => '200',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_general_layout_boxed_offset', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Content Width
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'osf_layout_general_content_width_type', array(
                'default'           => 'px',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Group( $wp_customize, 'osf_layout_general_content_width_type', array(
                'section' => 'osf_layout_general',
                'label' => __( 'Content Width', 'gifymo-core' ),
                'choices' => array(
                'px' => __( 'px', 'gifymo-core' ),
                '%' => __( '%', 'gifymo-core' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_general_content_width_type', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_general_content_width_px', array(
                'default'           => '1170',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_general_content_width_px', array(
                'section' => 'osf_layout_general',
                'choices' => array(
                'min' => '767',
                'max' => '1920',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_general_content_width_px', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_general_content_width_percent', array(
                'default'           => '100',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_general_content_width_percent', array(
                'section' => 'osf_layout_general',
                'choices' => array(
                'min' => '20',
                'max' => '100',
                'unit' => '%',
            ),
            ) ) );
        }

        // =========================================
        // Gutter Width
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_general_gutter_width', array(
                'default'           => '30',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_general_gutter_width', array(
                'section' => 'osf_layout_general',
                'label' => __( 'Gutter Width', 'gifymo-core' ),
                'choices' => array(
                'min' => '10',
                'max' => '60',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_general_gutter_width', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Content Padding
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_general_content_width_padding', array(
                'default'           => '15',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_general_content_width_padding', array(
                'section' => 'osf_layout_general',
                'label' => __( 'Content Padding', 'gifymo-core' ),
                'choices' => array(
                'min' => '0',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_layout_general_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_layout_general_button_move', array(
                'section' => 'osf_layout_general',
                'buttons'  => array(
                'osf_colors_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
                'osf_typography_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Typography',
                ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_404_page_setting', array(
            'title'          => __( '404 Page Setting', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_layout', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Page Setting
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'osf_page_404_page_enable', array(
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Group( $wp_customize, 'osf_page_404_page_enable', array(
                'section' => 'osf_404_page_setting',
                'label' => __( 'Page Setting', 'gifymo-core' ),
                'choices' => array(
                'default' => __( 'Default', 'gifymo-core' ),
                'custom' => __( 'Customize', 'gifymo-core' ),
            ),
            ) ) );
        }

        // =========================================
        // 404 Page
        // =========================================
            $wp_customize->add_setting( 'osf_page_404_page_custom', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_page_404_page_custom', array(
            'section' => 'osf_404_page_setting',
            'label' => __( '404 Page', 'gifymo-core' ),
            'type' => 'dropdown-pages',
        ) );

        // =========================================
        // BG Image
        // =========================================
        if(class_exists('WP_Customize_Image_Control')){
            $wp_customize->add_setting( 'osf_page_404_bg_image', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'osf_page_404_bg_image', array(
                'section' => 'osf_404_page_setting',
                'label' => __( 'BG Image', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // BG Position
        // =========================================
        if(class_exists('OSF_Customize_Control_Background_Position')){
            $wp_customize->add_setting( 'osf_page_404_bg_position', array(
                'default'           => 'top left',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Background_Position( $wp_customize, 'osf_page_404_bg_position', array(
                'section' => 'osf_404_page_setting',
                'label' => __( 'BG Position', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Disable Repeat
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_page_404_bg_repeat', array(
                'default'           => '1',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_page_404_bg_repeat', array(
                'section' => 'osf_404_page_setting',
                'label' => __( 'Disable Repeat', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // BG Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_page_404_bg', array(
                'default'           => '#fafafa',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_page_404_bg', array(
                'section' => 'osf_404_page_setting',
                'label' => __( 'BG Color', 'gifymo-core' ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_header($wp_customize){
    
        $wp_customize->add_section( 'osf_header', array(
            'title'          => __( 'Header', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_header_layout_side_header_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_header_layout_side_header_heading', array(
                'section' => 'osf_header',
                'label' => __( 'Layout', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Enable Header Builder
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_header_enable_builder', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_header_enable_builder', array(
                'section' => 'osf_header',
                'label' => __( 'Enable Header Builder', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_header_enable_builder', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Header Builder
        // =========================================
        if(class_exists('OSF_Customize_Control_Headers')){
            $wp_customize->add_setting( 'osf_header_builder', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Headers( $wp_customize, 'osf_header_builder', array(
                'section' => 'osf_header',
                'label' => __( 'Header Builder', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_header_builder', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Fullwidth?
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_header_width', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_header_width', array(
                'section' => 'osf_header',
                'label' => __( 'Fullwidth?', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_header_width', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_footer($wp_customize){
    
        $wp_customize->add_section( 'osf_footer', array(
            'title'          => __( 'Footer', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_footer_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_footer_button_move', array(
                'section' => 'osf_footer',
                'buttons'  => array(
                'osf_typography_footer' => array(
                    'type'  => 'section',
                    'label' => 'Edit Typography',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_footer_title_layout', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_footer_title_layout', array(
                'section' => 'osf_footer',
                'label' => __( 'Layout', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Fixed Footer
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_fixed_footer', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_fixed_footer', array(
                'section' => 'osf_footer',
                'label' => __( 'Fixed Footer', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Footers')){
            $wp_customize->add_setting( 'osf_footer_layout', array(
                'default'           => '0',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Footers( $wp_customize, 'osf_footer_layout', array(
                'section' => 'osf_footer',
                'label' => __( 'Layout', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Copyright
        // =========================================
        if(class_exists('OSF_Customize_Control_Editor')){
            $wp_customize->add_setting( 'osf_footer_copyright', array(
                'default'           => 'Proudly powered by themelexus.com',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_editor',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Editor( $wp_customize, 'osf_footer_copyright', array(
                'section' => 'osf_footer',
                'label' => __( 'Copyright', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_footer_copyright', array(
            'selector'        => '.site-info > .container',
            'render_callback' => 'osf_customize_partial_copyright',
        ) );
        
        // =========================================
        // Enable Back To Top
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_back_to_top_footer', array(
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_back_to_top_footer', array(
                'section' => 'osf_footer',
                'label' => __( 'Enable Back To Top', 'gifymo-core' ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_blog($wp_customize){
    
        $wp_customize->add_panel( 'osf_blog', array(
            'title'          => __( 'Blog', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'osf_blog_archive', array(
            'title'          => __( 'Archive', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_blog', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Sidebar Position
        // =========================================
        if(class_exists('OSF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'osf_blog_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Image_Select( $wp_customize, 'osf_blog_layout', array(
                'section' => 'osf_blog_archive',
                'label' => __( 'Sidebar Position', 'gifymo-core' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Select Style
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'osf_blog_archive_style', array(
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Group( $wp_customize, 'osf_blog_archive_style', array(
                'section' => 'osf_blog_archive',
                'label' => __( 'Select Style', 'gifymo-core' ),
                'choices' => array(
                'default' => __( 'Default', 'gifymo-core' ),
                '1' => __( '1', 'gifymo-core' ),
                '2' => __( '2', 'gifymo-core' ),
            ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_social($wp_customize){
    
        $wp_customize->add_section( 'osf_social', array(
            'title'          => __( 'Socials', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Socials Share
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_social_layout_side_header_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_social_layout_side_header_heading', array(
                'section' => 'osf_social',
                'label' => __( 'Socials Share', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Socials
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_socials', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_socials', array(
                'section' => 'osf_social',
                'label' => __( 'Socials', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_socials', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Facebook
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_facebook', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_facebook', array(
                'section' => 'osf_social',
                'label' => __( 'Facebook', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_facebook', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Twitter
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_twitter', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_twitter', array(
                'section' => 'osf_social',
                'label' => __( 'Twitter', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_twitter', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Linkedin
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_linkedin', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_linkedin', array(
                'section' => 'osf_social',
                'label' => __( 'Linkedin', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_linkedin', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Tumblr
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_tumblr', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_tumblr', array(
                'section' => 'osf_social',
                'label' => __( 'Tumblr', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_tumblr', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Google Plus
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_google_plus', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_google_plus', array(
                'section' => 'osf_social',
                'label' => __( 'Google Plus', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_google_plus', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Pinterest
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_pinterest', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_pinterest', array(
                'section' => 'osf_social',
                'label' => __( 'Pinterest', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_pinterest', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Email
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_email', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_email', array(
                'section' => 'osf_social',
                'label' => __( 'Email', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_email', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_woocommerce($wp_customize){
    
        $wp_customize->add_panel( 'woocommerce', array(
            'title'          => __( 'Woocommerce', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'osf_woocommerce_archive', array(
            'title'          => __( 'Archive', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'woocommerce', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_archive_layout_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_archive_layout_heading', array(
                'section' => 'osf_woocommerce_archive',
                'label' => __( 'Layout', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Layout Style
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_archive_style', array(
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_archive_style', array(
            'section' => 'osf_woocommerce_archive',
            'label' => __( 'Layout Style', 'gifymo-core' ),
            'type' => 'select',
            'choices' => array(
                'default' => __( 'Default', 'gifymo-core' ),
                'canvas' => __( 'Canvas', 'gifymo-core' ),
            ),
        ) );

        // =========================================
        // Sidebar Position
        // =========================================
        if(class_exists('OSF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'osf_woocommerce_archive_layout', array(
                'default'           => '2cl',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Image_Select( $wp_customize, 'osf_woocommerce_archive_layout', array(
                'section' => 'osf_woocommerce_archive',
                'label' => __( 'Sidebar Position', 'gifymo-core' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Container Fullwidth?
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_woocommerce_archive_product_width', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_woocommerce_archive_product_width', array(
                'section' => 'osf_woocommerce_archive',
                'label' => __( 'Container Fullwidth?', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_archive_columns', array(
                'default'           => '4',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_archive_columns', array(
            'section' => 'osf_woocommerce_archive',
            'label' => __( 'Columns', 'gifymo-core' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1', 'gifymo-core' ),
                '2' => __( '2', 'gifymo-core' ),
                '3' => __( '3', 'gifymo-core' ),
                '4' => __( '4', 'gifymo-core' ),
                '5' => __( '5', 'gifymo-core' ),
                '6' => __( '6', 'gifymo-core' ),
            ),
        ) );

        // =========================================
        // Number product to show
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_archive_number', array(
                'default'           => '12',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_archive_number', array(
            'section' => 'osf_woocommerce_archive',
            'label' => __( 'Number product to show', 'gifymo-core' ),
            'type' => 'number',
        ) );

        // =========================================
        // Product Catalog
        // =========================================
        if(osf_woocommerce_version_check() && class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_archive_catalog_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_archive_catalog_heading', array(
                'section' => 'osf_woocommerce_archive',
                'label' => __( 'Product Catalog', 'gifymo-core' ),
                'priority' => 20,
            ) ) );
        }

        $wp_customize->add_section( 'osf_woocommerce_single', array(
            'title'          => __( 'Single', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'woocommerce', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Image
        // =========================================
        if(osf_woocommerce_version_check() && class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_single__image_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_single__image_heading', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Image', 'gifymo-core' ),
                'priority' => 8,
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_single_layout_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_single_layout_heading', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Layout', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Sidebar Position
        // =========================================
        if(class_exists('OSF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'osf_woocommerce_single_layout', array(
                'default'           => '2cl',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Image_Select( $wp_customize, 'osf_woocommerce_single_layout', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Sidebar Position', 'gifymo-core' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Style
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_single_product_style', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_single_product_style', array(
            'section' => 'osf_woocommerce_single',
            'label' => __( 'Style', 'gifymo-core' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( 'Style 1', 'gifymo-core' ),
                '2' => __( 'Style 2', 'gifymo-core' ),
                '3' => __( 'Style 3', 'gifymo-core' ),
                '4' => __( 'Style 4', 'gifymo-core' ),
            ),
        ) );

        // =========================================
        // Tab Style
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'osf_woocommerce_single_product_tab_style', array(
                'default'           => 'tab',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Group( $wp_customize, 'osf_woocommerce_single_product_tab_style', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Tab Style', 'gifymo-core' ),
                'choices' => array(
                'tab' => __( 'Tab', 'gifymo-core' ),
                'accordion' => __( 'Accordion', 'gifymo-core' ),
            ),
            ) ) );
        }

        // =========================================
        // Product Related
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_single_related_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_single_related_heading', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Product Related', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Number product to show
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_single_related_number', array(
                'default'           => '3',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_single_related_number', array(
            'section' => 'osf_woocommerce_single',
            'label' => __( 'Number product to show', 'gifymo-core' ),
            'type' => 'number',
        ) );

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_single_related_columns', array(
                'default'           => '3',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_single_related_columns', array(
            'section' => 'osf_woocommerce_single',
            'label' => __( 'Columns', 'gifymo-core' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1', 'gifymo-core' ),
                '2' => __( '2', 'gifymo-core' ),
                '3' => __( '3', 'gifymo-core' ),
                '4' => __( '4', 'gifymo-core' ),
                '5' => __( '5', 'gifymo-core' ),
                '6' => __( '6', 'gifymo-core' ),
            ),
        ) );

        // =========================================
        // Product Up-sell
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_single_upsell_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_single_upsell_heading', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Product Up-sell', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_single_upsell_columns', array(
                'default'           => '3',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_single_upsell_columns', array(
            'section' => 'osf_woocommerce_single',
            'label' => __( 'Columns', 'gifymo-core' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1', 'gifymo-core' ),
                '2' => __( '2', 'gifymo-core' ),
                '3' => __( '3', 'gifymo-core' ),
                '4' => __( '4', 'gifymo-core' ),
                '5' => __( '5', 'gifymo-core' ),
                '6' => __( '6', 'gifymo-core' ),
            ),
        ) );

        $wp_customize->add_section( 'osf_woocommerce_product', array(
            'title'          => __( 'Product', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'woocommerce', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Image
        // =========================================
        if(osf_woocommerce_version_check() && class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_archive__image_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_archive__image_heading', array(
                'section' => 'osf_woocommerce_product',
                'label' => __( 'Image', 'gifymo-core' ),
                'priority' => 8,
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_product_layout_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_product_layout_heading', array(
                'section' => 'osf_woocommerce_product',
                'label' => __( 'Layout', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Style
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_product_style', array(
                'default'           => 'grid',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_product_style', array(
            'section' => 'osf_woocommerce_product',
            'label' => __( 'Style', 'gifymo-core' ),
            'type' => 'select',
            'choices' => array(
                'grid' => __( 'Grid', 'gifymo-core' ),
                'list' => __( 'List', 'gifymo-core' ),
            ),
        ) );

        // =========================================
        // Animation Image Hover
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_product_hover', array(
                'default'           => 'none',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_product_hover', array(
            'section' => 'osf_woocommerce_product',
            'label' => __( 'Animation Image Hover', 'gifymo-core' ),
            'type' => 'select',
            'choices' => array(
                'none' => __( 'None', 'gifymo-core' ),
                'bottom-to-top' => __( 'Bottom to Top', 'gifymo-core' ),
                'top-to-bottom' => __( 'Top to Bottom', 'gifymo-core' ),
                'right-to-left' => __( 'Right to Left', 'gifymo-core' ),
                'left-to-right' => __( 'Left to Right', 'gifymo-core' ),
                'swap' => __( 'Swap', 'gifymo-core' ),
                'fade' => __( 'Fade', 'gifymo-core' ),
                'zoom-in' => __( 'Zoom In', 'gifymo-core' ),
                'zoom-out' => __( 'Zoom Out', 'gifymo-core' ),
            ),
        ) );

        $wp_customize->add_section( 'otf_woocommerce_extra', array(
            'title'          => __( 'Extra', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'woocommerce', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Enable Product Recently Viewed
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_woocommerce_extra_enable_product_recently_viewed', array(
                'default'           => '1',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'otf_woocommerce_extra_enable_product_recently_viewed', array(
                'section' => 'otf_woocommerce_extra',
                'label' => __( 'Enable Product Recently Viewed', 'gifymo-core' ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_maintenance($wp_customize){
    
        $wp_customize->add_section( 'osf_maintenance', array(
            'title'          => __( 'Maintenance', 'gifymo-core' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Maintenance Mode
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_maintenance_layout_side_header_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_maintenance_layout_side_header_heading', array(
                'section' => 'osf_maintenance',
                'label' => __( 'Maintenance Mode', 'gifymo-core' ),
            ) ) );
        }

        // =========================================
        // Activated
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_maintenance', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_maintenance', array(
                'section' => 'osf_maintenance',
                'label' => __( 'Activated', 'gifymo-core' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_maintenance', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Maintenance Page
        // =========================================
            $wp_customize->add_setting( 'osf_maintenance_page', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_maintenance_page', array(
            'section' => 'osf_maintenance',
            'label' => __( 'Maintenance Page', 'gifymo-core' ),
            'type' => 'dropdown-pages',
        ) );

    }

}
}
new OSF_Customize();