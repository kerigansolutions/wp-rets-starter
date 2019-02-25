<?php
namespace KeriganSolutions\KMATestimonials;

class Testimonial
{
    public $menuName;
    public $menuIcon;
    public $singularName;
    public $pluralName;

    public function __construct()
    {
        $this->menuName = 'Testimonials';
        $this->singularName = 'Testimonial';
        $this->pluralName = 'Testimonials';
        $this->menuIcon = 'megaphone';

        // Create REST API Routes
        add_action('rest_api_init', [$this, 'addRoutes']);
    }

    public function menuName($menuName)
    {
        $this->menuName = $menuName;

        return $this;
    }

    public function menuIcon($menuIcon)
    {
        $this->menuIcon = $menuIcon;

        return $this;
    }

    public function singularName($singularName)
    {
        $this->singularName = $singularName;

        return $this;
    }

    public function pluralName($pluralName)
    {
        $this->pluralName = $pluralName;

        return $this;
    }

    public function registerFields()
    {
        // ACF Group: slide Details
        acf_add_local_field_group(array(
            'key' => 'group_testimonial_details',
            'title' => $this->singularName . ' Byline',
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'testimonial',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        ));

        // Byline
        acf_add_local_field(array(
            'key' => 'byline',
            'label' => 'Byline',
            'name' => 'byline',
            'type' => 'text',
            'parent' => 'group_testimonial_details',
            'instructions' => 'Example: John Doe, Mexico Beach',
            'required' => 1,
        ));

        // Featured
        acf_add_local_field(array(
            'key' => 'featured',
            'label' => 'Featured',
            'name' => 'featured',
            'type' => 'true_false',
            'parent' => 'group_testimonial_details',
            'message' => 'Display on homepage?'
        ));

    }

    public function use()
    {
        add_action('init', [$this, 'testimonial_init']);
        add_filter('testimonial_updated_messages', [$this, 'testimonial_updated_messages']);
        if (function_exists('acf_add_local_field_group')) {
            add_action('init', [$this, 'registerFields']);
        }
    }

    /*
     * Query WP for testimonial
     */
    public function queryTestimonials($featured = false, $limit = -1, $orderby = 'menu_order', $order = 'ASC', $truncate = 0)
    {
        $request = [
            'posts_per_page' => $limit,
            'offset' => 0,
            'order' => $order,
            'orderby' => $orderby,
            'post_type' => 'testimonial',
            'post_status' => 'publish'
        ];

        if($featured){
            $request['meta_query'] = [
                'relation' => 'AND',
                    [
                        'key'     => 'featured',
                        'value'   => 1,
                        'compare' => '='
                    ]
            ];
        }

        $testimonialList = get_posts($request);

        $testimonialArray = [];
        foreach ($testimonialList as $testimonial) {
            $testimonial->byline = get_field('byline', $testimonial->ID);
            $testimonial->featured = get_field('featured', $testimonial->ID);
            $readmore = '... <a href="/testimonials/#' . $testimonial->ID . '">read more.</a>';
            $testimonial->excerpt = ($truncate > 0 ? wp_trim_words($testimonial->post_content, $truncate, '...') : '');
            $testimonial->truncate = ($truncate > 0 ? wp_trim_words($testimonial->post_content, $truncate, $readmore) : '');
            $testimonialArray[] = $testimonial;
        }

        return $testimonialArray;
    }

    /*
     * Get slides using REST API endpoint
     */
    public function getTestimonials($request)
    {
        $limit    = $request->get_param('limit');
        $featured = $request->get_param('featured');
        return rest_ensure_response($this->queryTestimonials($featured, $limit));
    }

    /**
     * Add REST API routes
     */
    public function addRoutes()
    {
        register_rest_route(
            'kerigansolutions/v1',
            '/testimonials',
            [
                'methods' => 'GET',
                'callback' => [$this, 'getTestimonials']
            ]
        );
    }
    public function testimonial_init()
    {
        register_post_type('testimonial', array(
            'labels' => array(
                'name' => __($this->menuName, 'wordplate'),
                'singular_name' => __($this->singularName, 'wordplate'),
                'all_items' => __($this->menuName, 'wordplate'),
                'archives' => __($this->menuName . ' Archives', 'wordplate'),
                'attributes' => __($this->singularName . 'Attributes', 'wordplate'),
                'insert_into_item' => __('Insert into ' . $this->singularName, 'wordplate'),
                'uploaded_to_this_item' => __('Uploaded to this ' . $this->singularName, 'wordplate'),
                'featured_image' => _x('Featured Image', 'testimonial', 'wordplate'),
                'set_featured_image' => _x('Set featured image', 'testimonial', 'wordplate'),
                'remove_featured_image' => _x('Remove featured image', 'testimonial', 'wordplate'),
                'use_featured_image' => _x('Use as featured image', 'testimonial', 'wordplate'),
                'filter_items_list' => __('Filter Testimonials list', 'wordplate'),
                'items_list_navigation' => __($this->menuName . ' list navigation', 'wordplate'),
                'items_list' => __($this->menuName . ' list', 'wordplate'),
                'new_item' => __('New ' . $this->singularName, 'wordplate'),
                'add_new' => __('Add New', 'wordplate'),
                'add_new_item' => __('Add New ' . $this->singularName, 'wordplate'),
                'edit_item' => __('Edit ' . $this->singularName, 'wordplate'),
                'view_item' => __('View ' . $this->singularName, 'wordplate'),
                'view_items' => __('View ' . $this->menuName, 'wordplate'),
                'search_items' => __('Search ' . $this->menuName, 'wordplate'),
                'not_found' => __('No Testimonials found', 'wordplate'),
                'not_found_in_trash' => __('No Testimonials found in trash', 'wordplate'),
                'parent_item_colon' => __('Parent Testimonial:', 'wordplate'),
                'menu_name' => __($this->menuName, 'wordplate'),
            ),
            'public' => true,
            'hierarchical' => false,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'supports' => array('title', 'editor'),
            'has_archive' => true,
            'rewrite' => true,
            'query_var' => true,
            'menu_icon' => 'dashicons-' . $this->menuIcon,
            'show_in_rest' => true,
            'rest_base' => 'testimonial',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
        ));

    }

    /**
     * Sets the post updated messages for the `project` post type.
     *
     * @param  array $messages Post updated messages.
     * @return array Messages for the `project` post type.
     */
    public function testimonial_updated_messages($messages)
    {
        global $post;

        $permalink = get_permalink($post);

        $messages['testimonial'] = array(
            0 => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
            1 => sprintf(__($this->singularName . ' updated. <a target="_blank" href="%s">View ' . $this->singularName . '</a>', 'wordplate'), esc_url($permalink)),
            2 => __('Custom field updated.', 'wordplate'),
            3 => __('Custom field deleted.', 'wordplate'),
            4 => __($this->singularName . ' updated.', 'wordplate'),
		/* translators: %s: date and time of the revision */
            5 => isset($_GET['revision']) ? sprintf(__($this->singularName . ' restored to revision from %s', 'wordplate'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
		/* translators: %s: post permalink */
            6 => sprintf(__($this->singularName . ' published. <a href="%s">View ' . $this->singularName . '</a>', 'wordplate'), esc_url($permalink)),
            7 => __($this->singularName . ' saved.', 'wordplate'),
		/* translators: %s: post permalink */
            8 => sprintf(__($this->singularName . ' submitted. <a target="_blank" href="%s">Preview ' . $this->singularName . '</a>', 'wordplate'), esc_url(add_query_arg('preview', 'true', $permalink))),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
            9 => sprintf(
                __($this->singularName . ' scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview ' . $this->singularName . '</a>', 'wordplate'),
                date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)),
                esc_url($permalink)
            ),
		/* translators: %s: post permalink */
            10 => sprintf(__($this->singularName . ' draft updated. <a target="_blank" href="%s">Preview ' . $this->singularName . '</a>', 'wordplate'), esc_url(add_query_arg('preview', 'true', $permalink))),
        );

        return $messages;
    }

}
