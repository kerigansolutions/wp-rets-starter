<?php 
/*
 * This file defines the fields used to customize 
 * the home pgae using the WP customizer API
 */

function home_customizations( $wp_customize ) {
    // Slider or brand image  

    $wp_customize->add_section( 'theme_colors' , array(
        'title'      => __( 'Theme Colors', 'wordplate' ),
        'priority'   => 30,
    ) );

    $wp_customize->add_setting( 'primary_color' , array(
        'default'   => '#17a2b8',
        'transport' => 'refresh',
    ) );

    $wp_customize->add_control( 
        new WP_Customize_Color_Control( //Instantiate the color control class
        $wp_customize, 'primary_color', //Set a unique ID for the control
        array(
           'label'      => __( 'Primary Color', 'wordplate' ), //Admin-visible name of the control
           'settings'   => 'primary_color', //Which setting to load and manipulate (serialized is okay)
           'priority'   => 10, //Determines the order this control appears in for the specified section
           'section'    => 'theme_colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
    ) ) );



    // Main image or slider
    $wp_customize->add_setting( 'header_feature', array(
        'capability' => 'edit_theme_options',
        'default' => 'slider',
    ) );

    $wp_customize->add_control( 'header_feature', array(
        'label' => __( 'Top Section' ),
        'type' => 'radio',
        'section' => 'static_front_page',
        'choices' => array(
            'slider' => __('Slider'),
            'main-image' => __('Main Image'),
    ) ) );

    $wp_customize->add_setting( 'home_header_image', array(
        'capability' => 'edit_theme_options',
        'default' => '',
        'sanitize_callback' => 'absint'
    ) );

    $wp_customize->add_setting( 'use_overlay_text', array(
        'capability' => 'edit_theme_options',
        'default' => false,
    ) );

    $wp_customize->add_setting( 'overlay_content', array(
        'capability' => 'edit_theme_options',
        'default' => '',
    ) );

    $wp_customize->add_setting( 'overlay_color', array(
        'capability' => 'edit_theme_options',
        'default' => '#000000',
    ) );

    $wp_customize->add_setting( 'overlay_opacity', array(
        'capability' => 'edit_theme_options',
        'default' => '80%',
    ) );

    $wp_customize->add_setting( 'overlay_text_color', array(
        'capability' => 'edit_theme_options',
        'default' => '#FFFFFF',
    ) );

    $wp_customize->add_setting( 'top_section_height', array(
        'capability' => 'edit_theme_options',
        'default' => '100vh',
    ) );

    $wp_customize->add_control( 'top_section_height', array(
        'label' => __( 'Top Section Height' ),
        'type' => 'text',
        'section' => 'static_front_page'
    ) );

    if (get_theme_mod('header_feature') == 'main-image'){
        
        $wp_customize->add_control(
            new WP_Customize_Media_Control( 
            $wp_customize, 'home_header_image', 
            array(
                'label' => __( 'Main Header Image', 'wordplate' ),
                'section' => 'static_front_page',
                'mime_type' => 'image',
        ) ) );

        $wp_customize->add_control( 'use_overlay_text', array(
            'label' => __( 'Use overlay to increase legibility' ),
            'type' => 'checkbox',
            'section' => 'static_front_page'
        ) );

        $wp_customize->add_control( 'overlay_content', array(
            'label' => __( 'Select Overlay Content' ),
            'type' => 'dropdown-pages',
            'section' => 'static_front_page'
        ) );

        $wp_customize->add_control( 
            new WP_Customize_Color_Control( //Instantiate the color control class
            $wp_customize, 'overlay_color', //Set a unique ID for the control
            array(
               'label'      => __( 'Overlay Color', 'wordplate' ), //Admin-visible name of the control
               'settings'   => 'overlay_color', //Which setting to load and manipulate (serialized is okay)
               'priority'   => 10, //Determines the order this control appears in for the specified section
               'section'    => 'static_front_page', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
        ) ) );

        $wp_customize->add_control( 'overlay_opacity', array(
            'label' => __( 'Select Overlay Opacity' ),
            'type' => 'number',
            'section' => 'static_front_page'
        ) );

        $wp_customize->add_control( 
            new WP_Customize_Color_Control( //Instantiate the color control class
            $wp_customize, 'overlay_text_color', //Set a unique ID for the control
            array(
               'label'      => __( 'Overlay Text Color', 'wordplate' ), //Admin-visible name of the control
               'settings'   => 'overlay_text_color', //Which setting to load and manipulate (serialized is okay)
               'priority'   => 10, //Determines the order this control appears in for the specified section
               'section'    => 'static_front_page', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
        ) ) );
    }

    $wp_customize->add_setting( 'number_feature_boxes', array(
        'capability' => 'edit_theme_options',
        'default' => 2,
    ) );

    $wp_customize->add_control( 'number_feature_boxes', array(
        'label' => __( 'Number of Feature Boxes' ),
        'type' => 'number',
        'section' => 'static_front_page'
    ) );

}
add_action( 'customize_register', 'home_customizations' );