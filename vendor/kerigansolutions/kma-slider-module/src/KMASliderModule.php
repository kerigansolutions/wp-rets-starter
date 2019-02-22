<?php

namespace KeriganSolutions\KMASlider;

class KMASliderModule
{
    public function __construct()
    {
        // Create the post type for Slide
        add_action( 'init', [$this, 'createPostType'] );
        add_filter( 'post_updated_messages', [$this, 'postTypeUpdated'] );

        // Create the taxonomy for Slider
        add_action( 'init', [$this, 'createTaxonomy'] );
        add_filter( 'term_updated_messages', [$this, 'taxonomyUpdated'] );

        // Don't die if ACF isn't installed
        if ( function_exists( 'acf_add_local_field_group' ) ) {
            add_action( 'acf/init', [$this, 'registerFields'] );
        }

        // Create REST API Routes
        add_action( 'init', [$this, 'addRoutes'] );
    }

    /* 
     * Query WP for slides
     */
    public function querySlides( $limit = -1, $category = '' )
    {
        $request = [
            'posts_per_page' => $limit,
            'offset'         => 0,
            'order'          => 'ASC',
            'orderby'        => 'menu_order',
            'post_type'      => 'slide',
            'post_status'    => 'publish',
        ];

        if ($category != '') {
            $categoryarray = [
                [
                    'taxonomy'         => 'slider',
                    'field'            => 'slug',
                    'terms'            => $category,
                    'include_children' => false,
                ],
            ];
            $request['tax_query'] = $categoryarray;
        }

        $slidelist = get_posts($request);

        $slideArray = [];
        foreach ($slidelist as $slide) {
            array_push($slideArray, [
                'id'          => (isset($slide->ID) ? $slide->ID : null),
                'name'        => (isset($slide->post_title) ? $slide->post_title : null),
                'slug'        => (isset($slide->post_name) ? $slide->post_name : null),
                'photo'       => get_field('image',$slide->ID),
                'href'        => get_field('link',$slide->ID),
                'target'      => get_field('link_target',$slide->ID),
                'slider'      => get_field('slider',$slide->ID)
            ]);
        }

        return $slideArray;
    }

    /* 
     * Get slides using REST API endpoint
     */
    public function getSlides( $request )
    {
        $limit    = $request->get_param( 'limit' );
        $category = $request->get_param( 'category' );
        return rest_ensure_response( $this->querySlides($limit, $category));
    }

    /**
	 * Add REST API routes
	 */
    public function addRoutes() 
    {
        register_rest_route( 'kerigansolutions/v1', '/slider',
            [
                'methods'         => 'GET',
                'callback'        => [ $this, 'getSlides' ]
            ]
        );
    }

    /**
	 * Check request permissions
     * Use for POST methods or for reading settings
	 *
	 * @return bool
	 */
	public function permissions(){
		return current_user_can( 'manage_options' ); // Administrators
    }

    public function registerFields()
    {
		// ACF Group: slide Details
		acf_add_local_field_group( array (
			'key'      => 'group_slide_details',
			'title'    => 'Slide Details',
			'location' => array (
				array (
					array (
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'slide',
					),
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
			'key'           => 'image',
			'label'         => 'Image',
			'name'          => 'image',
			'type'          => 'image',
			'parent'        => 'group_slide_details',
			'instructions'  => '',
			'required'      => 0,
			'return_format' => 'array',
			'preview_size'  => 'large',
			'library'       => 'all',
			'min_width'     => 0,
			'min_height'    => 0,
			'max_width'     => 0,
			'max_height'    => 0,
        ) );

        // Link
        acf_add_local_field( array(
			'key'          => 'link',
			'label'        => 'Link',
			'name'         => 'link',
			'type'         => 'url',
			'parent'       => 'group_slide_details',
			'instructions' => '',
			'required'     => 0,
        ) );

        // Link Target
        acf_add_local_field( array(
			'key'          => 'link_target',
			'label'        => 'Link Target',
			'name'         => 'link_target',
			'type'         => 'select',
			'parent'       => 'group_slide_details',
			'instructions' => '',
            'required'     => 0,
            'choices'      => [
                '_blank'  => 'New Window',
                '_self'   => 'Same Frame',
                '_parent' => 'Parent Frameset',
                '_top'    => 'Full Body'
            ],
            'allow_null'   => 0,
            'multiple'     => 0,
            'ui'           => 0,
            'ajax'         => 0,
            'placeholder'  => '',
        ) );
        
        // Affiliation
		acf_add_local_field( array(
			'key'             => 'sliders',
			'label'           => 'Sliders',
			'name'            => 'sliders',
			'type'            => 'taxonomy',
			'parent'          => 'group_slide_details',
			'instructions'    => '',
			'required'        => 0,
			'taxonomy'        => 'slider',
			'field_type'      => 'checkbox',    // UI (checkbox, multi-select, select, radio)
			'allow_null'      => 0,             // Can select a blank value
			'load_save_terms' => 1,             // Persist using term relationships table
			'return_format'   => 'object',      // or 'object'
			'add_term'        => 0,             // Can the user add new terms?
		) );

    }

    /**
     * Registers the `slider` taxonomy,
     * for use with 'slide'.
     */
    public function createTaxonomy()
    {
        register_taxonomy( 'slider', array( 'slide' ), array(
            'hierarchical'      => false,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_ui'           => true,
            'show_admin_column' => false,
            'query_var'         => true,
            'rewrite'           => true,
            'capabilities'      => array(
                'manage_terms'  => 'edit_posts',
                'edit_terms'    => 'edit_posts',
                'delete_terms'  => 'edit_posts',
                'assign_terms'  => 'edit_posts',
            ),
            'labels'            => array(
                'name'                       => __( 'Sliders', 'kerigansolutions' ),
                'singular_name'              => _x( 'Slider', 'taxonomy general name', 'kerigansolutions' ),
                'search_items'               => __( 'Search Sliders', 'kerigansolutions' ),
                'popular_items'              => __( 'Popular Sliders', 'kerigansolutions' ),
                'all_items'                  => __( 'All Sliders', 'kerigansolutions' ),
                'parent_item'                => __( 'Parent Slider', 'kerigansolutions' ),
                'parent_item_colon'          => __( 'Parent Slider:', 'kerigansolutions' ),
                'edit_item'                  => __( 'Edit Slider', 'kerigansolutions' ),
                'update_item'                => __( 'Update Slider', 'kerigansolutions' ),
                'view_item'                  => __( 'View Slider', 'kerigansolutions' ),
                'add_new_item'               => __( 'New Slider', 'kerigansolutions' ),
                'new_item_name'              => __( 'New Slider', 'kerigansolutions' ),
                'separate_items_with_commas' => __( 'Separate sliders with commas', 'kerigansolutions' ),
                'add_or_remove_items'        => __( 'Add or remove sliders', 'kerigansolutions' ),
                'choose_from_most_used'      => __( 'Choose from the most used sliders', 'kerigansolutions' ),
                'not_found'                  => __( 'No sliders found.', 'kerigansolutions' ),
                'no_terms'                   => __( 'No sliders', 'kerigansolutions' ),
                'menu_name'                  => __( 'Sliders', 'kerigansolutions' ),
                'items_list_navigation'      => __( 'Sliders list navigation', 'kerigansolutions' ),
                'items_list'                 => __( 'Sliders list', 'kerigansolutions' ),
                'most_used'                  => _x( 'Most Used', 'slider', 'kerigansolutions' ),
                'back_to_items'              => __( '&larr; Back to Sliders', 'kerigansolutions' ),
            ),
            'show_in_rest'      => true,
            'rest_base'         => 'slider',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
        ) );
    }

    /**
     * Sets the post updated messages for the `slider` taxonomy.
     *
     * @param  array $messages Post updated messages.
     * @return array Messages for the `slider` taxonomy.
     */
    public function taxonomyUpdated( $messages )
    {
        $messages['slider'] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => __( 'Slider added.', 'kerigansolutions' ),
            2 => __( 'Slider deleted.', 'kerigansolutions' ),
            3 => __( 'Slider updated.', 'kerigansolutions' ),
            4 => __( 'Slider not added.', 'kerigansolutions' ),
            5 => __( 'Slider not updated.', 'kerigansolutions' ),
            6 => __( 'Sliders deleted.', 'kerigansolutions' ),
        );

        return $messages;
    }

    /**
     * Registers the `slide` post type.
     */
    public function createPostType()
    {
        
        register_post_type( 'slide', array(
            'labels'                => array(
                'name'                  => __( 'Slides', 'kerigansolutions' ),
                'singular_name'         => __( 'Slide', 'kerigansolutions' ),
                'all_items'             => __( 'All Slides', 'kerigansolutions' ),
                'archives'              => __( 'Slide Archives', 'kerigansolutions' ),
                'attributes'            => __( 'Slide Attributes', 'kerigansolutions' ),
                'insert_into_item'      => __( 'Insert into slide', 'kerigansolutions' ),
                'uploaded_to_this_item' => __( 'Uploaded to this slide', 'kerigansolutions' ),
                'featured_image'        => _x( 'Featured Image', 'slide', 'kerigansolutions' ),
                'set_featured_image'    => _x( 'Set featured image', 'slide', 'kerigansolutions' ),
                'remove_featured_image' => _x( 'Remove featured image', 'slide', 'kerigansolutions' ),
                'use_featured_image'    => _x( 'Use as featured image', 'slide', 'kerigansolutions' ),
                'filter_items_list'     => __( 'Filter slides list', 'kerigansolutions' ),
                'items_list_navigation' => __( 'Slides list navigation', 'kerigansolutions' ),
                'items_list'            => __( 'Slides list', 'kerigansolutions' ),
                'new_item'              => __( 'New Slide', 'kerigansolutions' ),
                'add_new'               => __( 'Add New', 'kerigansolutions' ),
                'add_new_item'          => __( 'Add New Slide', 'kerigansolutions' ),
                'edit_item'             => __( 'Edit Slide', 'kerigansolutions' ),
                'view_item'             => __( 'View Slide', 'kerigansolutions' ),
                'view_items'            => __( 'View Slides', 'kerigansolutions' ),
                'search_items'          => __( 'Search slides', 'kerigansolutions' ),
                'not_found'             => __( 'No slides found', 'kerigansolutions' ),
                'not_found_in_trash'    => __( 'No slides found in trash', 'kerigansolutions' ),
                'parent_item_colon'     => __( 'Parent Slide:', 'kerigansolutions' ),
                'menu_name'             => __( 'Home Page Slider', 'kerigansolutions' ),
            ),
            'public'                => true,
            'hierarchical'          => false,
            'show_ui'               => true,
            'show_in_nav_menus'     => true,
            'supports'              => array( 'title' ),
            'has_archive'           => true,
            'rewrite'               => true,
            'query_var'             => true,
            'menu_icon'             => 'dashicons-admin-post',
            'show_in_rest'          => true,
            'rest_base'             => 'slide',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
        ) );
    }

    /**
     * Sets the post updated messages for the `slide` post type.
     *
     * @param  array $messages Post updated messages.
     * @return array Messages for the `slide` post type.
     */
    public function postTypeUpdated( $messages )
    {
        global $post;

        $permalink = get_permalink( $post );

        $messages['slide'] = array(
            0  => '', // Unused. Messages start at index 1.
            /* translators: %s: post permalink */
            1  => sprintf( __( 'Slide updated. <a target="_blank" href="%s">View slide</a>', 'kerigansolutions' ), esc_url( $permalink ) ),
            2  => __( 'Custom field updated.', 'kerigansolutions' ),
            3  => __( 'Custom field deleted.', 'kerigansolutions' ),
            4  => __( 'Slide updated.', 'kerigansolutions' ),
            /* translators: %s: date and time of the revision */
            5  => isset( $_GET['revision'] ) ? sprintf( __( 'Slide restored to revision from %s', 'kerigansolutions' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            /* translators: %s: post permalink */
            6  => sprintf( __( 'Slide published. <a href="%s">View slide</a>', 'kerigansolutions' ), esc_url( $permalink ) ),
            7  => __( 'Slide saved.', 'kerigansolutions' ),
            /* translators: %s: post permalink */
            8  => sprintf( __( 'Slide submitted. <a target="_blank" href="%s">Preview slide</a>', 'kerigansolutions' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
            /* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
            9  => sprintf( __( 'Slide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview slide</a>', 'kerigansolutions' ),
            date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
            /* translators: %s: post permalink */
            10 => sprintf( __( 'Slide draft updated. <a target="_blank" href="%s">Preview slide</a>', 'kerigansolutions' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
        );

        return $messages;
    }
}