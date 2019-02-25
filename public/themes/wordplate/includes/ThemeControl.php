<?php
use KeriganSolutions\KMARealtor;

class ThemeControl
{
    public $team;
    public $portfolio;
    public $testimonials;
    public $slider;
    public $social;
    public $themeSettings;

    public function __construct()
    {
        add_action( 'customize_register' , array( $this, 'registerSettings' ) );

        $this->themeSettings = array(
            'enable_team' => get_theme_mod('enable_team'),
            'enable_testimonials' => get_theme_mod('enable_testimonials'),
            'enable_portfolio' => get_theme_mod('enable_portfolio'),
            'enable_contact' => get_theme_mod('enable_contact'),
            'enable_social' => get_theme_mod('enable_social'),
            'header_feature' => get_theme_mod('header_feature'),
            'number_feature_boxes' => get_theme_mod('number_feature_boxes'),
        );

        //include required files
        require template_path('includes/plugins/plate.php');
        require template_path('includes/plugins/theme-setup.php');
        require template_path('includes/plugins/branded-login.php');
        require template_path('includes/plugins/editor-filters.php');

        if ( function_exists( 'acf_add_local_field_group' ) ) {
            //enable theme modules
            $this->enableModules();
            // create ACF fields
            $this->createCustomFields();
        }

    }

    public function debug()
    {
        echo '<pre>',print_r($this->themeSettings),'</pre>';
    }

    protected function enableModules()
    {
        new Includes\Modules\ContactForm();

        new KeriganSolutions\KMARealtor\RealtorDashboard();
        new KeriganSolutions\KMARealtor\RealtorListings();
        (new KeriganSolutions\KMARealtor\FeaturedListings())->use();
        (new KeriganSolutions\KMARealtor\Listing())->use();
        $this->enableContactInfo();
        
        if (get_theme_mod('enable_team')){
            $this->enableTeam();
        }

        if (get_theme_mod('enable_testimonials')){
            $this->enableTestimonials();
        }

        if (get_theme_mod('header_feature') == 'slider'){
            $this->enableSlider();
        }

        if (get_theme_mod('enable_social')){
            $this->enableSocialSettings();
        }
    }

    protected function enableTeam()
    {
        (new KeriganSolutions\KMATeam\Team())->use();

        function team_shortcode() {
            $output =
            '<div class="team-grid">
                <div class="row justify-content-center">';
        
            $team = new Team();
            $members = $team->queryTeam();
        
            foreach($members as $member){
                $output .=
                '<div class="col-md-6 col-lg-4">
                    <div class="card team-member text-center">
                        <a href="' . $member['link'] . '" >
                            <img src="' . $member['image']['sizes']['thumbnail'] . '" class="card-img-top" alt="' . $member['name'] . '" >
                        </a>
                        <div class="card-body">
                            <h3 class="text-uppercase text-dark">' . $member['name'] . '</h3>
                            <p class="text-uppercase text-light">' . $member['title'] . '</p>
                            <p class="text-uppercase text-light">
                            <a href="mailto:' . $member['email'] . '" >' . $member['email'] . '</a><br>
                            <a href="tel:' . $member['phone'] . '" >' . $member['phone'] . '</p>
                        </div>
                    </div>
                    <div class="member-button text-center">
                        <a href="' . $member['link'] . '" class="btn btn-outline-light" >View Bio</a>
                    </div>
                </div>';
            }
        
            $output .= '</div></div>';
        
            return $output;
        }
        add_shortcode( 'team', 'team_shortcode' );
    }

    protected function enableContactInfo()
    {
        (new KeriganSolutions\KMAContactInfo\ContactInfo())->addField([
            'key'    => 'agent_id',
            'label'  => 'Agent ID',
            'name'   => 'agent_id',
            'type'   => 'text',
            'parent' => 'group_contact_info',
        ])->addField([
            'key'    => 'agent_name',
            'label'  => 'Agent Name',
            'name'   => 'agent_name',
            'type'   => 'text',
            'parent' => 'group_contact_info',
        ])->addField([
            'key'    => 'agent_photo',
            'label'  => 'Agent Photo',
            'name'   => 'agent_photo',
            'type'   => 'image',
            'return_format' => 'id',
            'parent' => 'group_contact_info',
        ])->addField([
            'key'    => 'broker_name',
            'label'  => 'Broker Name',
            'name'   => 'broker_name',
            'type'   => 'text',
            'parent' => 'group_contact_info',
        ])->addField([
            'key'    => 'broker_link',
            'label'  => 'Broker Link',
            'name'   => 'broker_link',
            'type'   => 'text',
            'parent' => 'group_contact_info',
        ])->addField([
            'key'    => 'broker_logo',
            'label'  => 'Broker Logo',
            'name'   => 'broker_logo',
            'type'   => 'image',
            'return_format' => 'id',
            'parent' => 'group_contact_info',
        ])->use();
    }

    protected function enableSlider()
    {
        new KeriganSolutions\KMASlider\KMASliderModule();
    }

    protected function enableTestimonials()
    {
        (new KeriganSolutions\KMATestimonials\Testimonial())->use();
    }

    protected function enableSocialSettings()
    {
        $socialLinks = new KeriganSolutions\SocialMedia\SocialSettingsPage();
        if (is_admin()) {
            $socialLinks->createPage();
        }
    }
    
    public function requirePostType($postType){
        require template_path('includes/post-type/' . $postType . '.php');
    }

    public function registerSettings($wp_customize) {
        $this->createCustomizerSections($wp_customize);
        $this->createThemeSettings($wp_customize);
        $this->createThemeControls($wp_customize);
        $this->frontPageSettings($wp_customize);
        $this->frontPageControls($wp_customize);
    }

    protected function createCustomizerSections($wp_customize)
    {
        $wp_customize->add_section( 'theme_colors' , array(
            'title'      => __( 'Theme Colors', 'wordplate' ),
            'priority'   => 1,
        ) );

        $wp_customize->add_section( 'wordplate_theme_settings' , array(
            'title'      => __( 'Theme Options', 'wordplate' ),
            'priority'   => 0,
        ) );
    }

    protected function createThemeSettings($wp_customize)
    {
        $wp_customize->add_setting( 'header_feature', array(
            'capability' => 'edit_theme_options',
            'default' => 'slider',
        ) );

        $wp_customize->add_setting( 'enable_testimonials', array(
            'capability' => 'edit_theme_options',
            'default' => false,
        ) );

        $wp_customize->add_setting( 'enable_team', array(
            'capability' => 'edit_theme_options',
            'default' => false,
        ) );

        $wp_customize->add_setting( 'enable_team', array(
            'capability' => 'edit_theme_options',
            'default' => false,
        ) );

        $wp_customize->add_setting( 'enable_contact', array(
            'capability' => 'edit_theme_options',
            'default' => false,
        ) );

        $wp_customize->add_setting( 'enable_social', array(
            'capability' => 'edit_theme_options',
            'default' => false,
        ) );
    }

    protected function createThemeControls($wp_customize)
    {
        $wp_customize->add_control( 'header_feature', array(
            'label' => __( 'Top Section' ),
            'type' => 'radio',
            'section' => 'wordplate_theme_settings',
            'choices' => array(
                'slider' => __('Slider'),
                'main-image' => __('Main Image'),
        ) ) );

        $wp_customize->add_control( 'enable_testimonials', array(
            'label' => __( 'Enable Testimonials' ),
            'type' => 'checkbox',
            'section' => 'wordplate_theme_settings'
        ) );

        $wp_customize->add_control( 'enable_team', array(
            'label' => __( 'Enable Team' ),
            'type' => 'checkbox',
            'section' => 'wordplate_theme_settings'
        ) );

        $wp_customize->add_control( 'enable_portfolio', array(
            'label' => __( 'Enable Portfolio' ),
            'type' => 'checkbox',
            'section' => 'wordplate_theme_settings'
        ) );

        $wp_customize->add_control( 'enable_social', array(
            'label' => __( 'Enable Social Icons' ),
            'type' => 'checkbox',
            'section' => 'wordplate_theme_settings'
        ) );

    }

    protected function frontPageSettings($wp_customize)
    {
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

        $wp_customize->add_setting( 'number_feature_boxes', array(
            'capability' => 'edit_theme_options',
            'default' => 2,
        ) );
    }

    protected function frontPageControls($wp_customize)
    {
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

        $wp_customize->add_control( 'number_feature_boxes', array(
            'label' => __( 'Number of Feature Boxes' ),
            'type' => 'number',
            'section' => 'static_front_page'
        ) );

    }

    protected function createCustomFields()
    {
        if ( function_exists( 'acf_add_local_field_group' ) ) {
            $this->registerPageFields();
            $this->registerFrontPageFields();     
        }   
    }

    protected function registerPageFields()
    {
        acf_add_local_field_group( array (
            'key'      => 'group_page_details',
            'title'    => 'Page Details',
            'location' => array (
                array (
                    array (
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'page',
                    ),
                    array (
                        'param'    => 'page_type',
                        'operator' => '!=',
                        'value'    => 'front_page',
                    )
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
        ) );
    
        // Image
        acf_add_local_field( array(
            'key'           => 'header_image',
            'label'         => 'Header Image',
            'name'          => 'header_image',
            'type'          => 'image',
            'parent'        => 'group_page_details',
            'instructions'  => '',
            'required'      => 0,
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'library'       => 'all',
            'min_width'     => 0,
            'min_height'    => 0,
            'max_width'     => 0,
            'max_height'    => 0,
            'wrapper' => array(
                'width' => '75',
                'class' => '',
                'id' => '',
            ),
        ) );

        acf_add_local_field( array(
            'key' => 'overlay_color',
            'label' => 'Overlay Color',
            'name' => 'overlay_color',
            'type' => 'color_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '25',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'parent' => 'group_page_details',

        ) );
    
        // Headline
        acf_add_local_field( array(
            'key'          => 'headline',
            'label'        => 'Headline',
            'name'         => 'headline',
            'type'         => 'text',
            'parent'       => 'group_page_details',
            'instructions' => '',
            'required'     => 0,
        ) );   

        
    }

    protected function registerFrontPageFields()
    {
        for($i=1; $i <= $this->themeSettings['number_feature_boxes']; $i++){
            acf_add_local_field_group(array(
                'key' => 'group_featbox_' .$i,
                'title' => 'Feature Box ' .$i,
                'fields' => array(
                    array(
                        'key' => 'headline_' .$i,
                        'label' => 'Headline',
                        'name' => 'headline_' .$i,
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '33',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'class_' .$i,
                        'label' => 'Class',
                        'name' => 'class_' .$i,
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '33',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => 'col col-md-6',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'image_' .$i,
                        'label' => 'Background Image ' .$i,
                        'name' => 'image_' .$i,
                        'type' => 'image',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '33',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'box_color_' .$i,
                        'label' => 'Box Color',
                        'name' => 'box_color_' .$i,
                        'type' => 'text',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '25',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'border_color_' .$i,
                        'label' => 'Border Color',
                        'name' => 'border_color_' .$i,
                        'type' => 'text',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '25',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '#000',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'text_color_' .$i,
                        'label' => 'Text Color',
                        'name' => 'text_color_' .$i,
                        'type' => 'text',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '25',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '#000',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'overlay_color_' .$i,
                        'label' => 'Overlay Color',
                        'name' => 'overlay_color_' .$i,
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '25',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => 'col col-md-6',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'text_' .$i,
                        'label' => 'Text',
                        'name' => 'text_' .$i,
                        'type' => 'textarea',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '33',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                        'rows' => '2',
                    ),
                    array(
                        'key' => 'link_' .$i,
                        'label' => 'Link',
                        'name' => 'link_' .$i,
                        'type' => 'url',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '33',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'link_text_' .$i,
                        'label' => 'Link Text',
                        'name' => 'link_text_' .$i,
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '33','class' => '',
                            'id' => '',
                        ),
                        'default_value' => 'Learn More',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'page_type',
                            'operator' => '==',
                            'value' => 'front_page',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
            ));
    
        }


        
    }
}