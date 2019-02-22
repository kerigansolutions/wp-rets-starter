<?php
namespace KeriganSolutions\KMATeam;

class Team
{
    public $menuName;
    public $menuIcon;
    public $singularName;
    public $pluralName;
    public $showSocial;

    public function __construct()
    {
        $this->menuName = 'Team';
        $this->singularName = 'Member';
        $this->pluralName = 'Team';
        $this->menuIcon = 'id';
        $this->showSocial = false;

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

    public function showSocial()
    {
        $this->showSocial = true;

        return $this;
    }


    public function use()
    {
        add_action('init', [$this, 'team_init']);
        add_filter('team_updated_messages', [$this, 'team_updated_messages']);
        if (function_exists('acf_add_local_field_group')) {
            add_action('acf/init', [$this, 'registerFields']);
        }
    }

    /*
     * Query WP for slides
     */
    public function queryTeam($limit = -1)
    {
        $request = [
            'posts_per_page' => $limit,
            'offset' => 0,
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'post_type' => 'team',
            'post_status' => 'publish',
        ];


        $team = get_posts($request);

        $teamArray = [];
        foreach ($team as $member) {
            array_push($teamArray, [
                'id' => (isset($member->ID) ? $member->ID : null),
                'name' => (isset($member->post_title) ? $member->post_title : null),
                'slug' => (isset($member->post_name) ? $member->post_name : null),
                'title' => get_field('title', $member->ID),
                'link' => get_permalink($member->ID),
                'image' => get_field('image', $member->ID),
                'email' => get_field('email', $member->ID),
                'phone' => get_field('phone', $member->ID),
                'facebook' => get_field('facebook', $member->ID),
                'linkedin' => get_field('linkedin', $member->ID),
                'instagram' => get_field('instagram', $member->ID),
                'twitter' => get_field('twitter', $member->ID),
            ]);
        }

        return $teamArray;
    }

    /*
     * Get slides using REST API endpoint
     */
    public function getTeam($request)
    {
        $limit = $request->get_param('limit');
        return rest_ensure_response($this->queryTeam($limit));
    }

    /**
     * Add REST API routes
     */
    public function addRoutes()
    {
        register_rest_route(
            'kerigansolutions/v1',
            '/team',
            [
                'methods' => 'GET',
                'callback' => [$this, 'getTeam']
            ]
        );
    }
    public function team_init()
    {
        register_post_type('team', array(
            'labels' => array(
                'name' => __($this->menuName, 'wordplate'),
                'singular_name' => __($this->singularName, 'wordplate'),
                'all_items' => __($this->menuName, 'wordplate'),
                'archives' => __($this->menuName . ' Archives', 'wordplate'),
                'attributes' => __($this->singularName . 'Attributes', 'wordplate'),
                'insert_into_item' => __('Insert into ' . $this->singularName, 'wordplate'),
                'uploaded_to_this_item' => __('Uploaded to this ' . $this->singularName, 'wordplate'),
                'featured_image' => _x('Featured Image', 'team', 'wordplate'),
                'set_featured_image' => _x('Set featured image', 'team', 'wordplate'),
                'remove_featured_image' => _x('Remove featured image', 'team', 'wordplate'),
                'use_featured_image' => _x('Use as featured image', 'team', 'wordplate'),
                'filter_items_list' => __('Filter '. $this->pluralName .' list', 'wordplate'),
                'items_list_navigation' => __($this->menuName . ' list navigation', 'wordplate'),
                'items_list' => __($this->menuName . ' list', 'wordplate'),
                'new_item' => __('New ' . $this->singularName, 'wordplate'),
                'add_new' => __('Add New', 'wordplate'),
                'add_new_item' => __('Add New ' . $this->singularName, 'wordplate'),
                'edit_item' => __('Edit ' . $this->singularName, 'wordplate'),
                'view_item' => __('View ' . $this->singularName, 'wordplate'),
                'view_items' => __('View ' . $this->menuName, 'wordplate'),
                'search_items' => __('Search ' . $this->menuName, 'wordplate'),
                'not_found' => __('No '. $this->pluralName .' found', 'wordplate'),
                'not_found_in_trash' => __('No '. $this->pluralName .' found in trash', 'wordplate'),
                'parent_item_colon' => __('Parent '. $this->singularName .':', 'wordplate'),
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
    public function team_updated_messages($messages)
    {
        global $post;

        $permalink = get_permalink($post);

        $messages['member'] = array(
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

    public function registerFields()
    {
        // ACF Group: slide Details
        acf_add_local_field_group(array(
            'key' => 'group_team_details',
            'title' => $this->singularName . ' info',
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'team',
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

        // title
        acf_add_local_field(array(
            'key' => 'title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'text',
            'parent' => 'group_team_details',
            'instructions' => 'Example: VP, Customer Relations',
        ));
        // email
        acf_add_local_field(array(
            'key' => 'email',
            'label' => 'Email',
            'name' => 'email',
            'type' => 'text',
            'parent' => 'group_team_details',
        ));
        // phone
        acf_add_local_field(array(
            'key' => 'phone',
            'label' => 'Phone',
            'name' => 'phone',
            'type' => 'text',
            'parent' => 'group_team_details',
        ));
        // Image
        acf_add_local_field(array(
            'key' => 'image',
            'label' => 'Image',
            'name' => 'image',
            'type' => 'image',
            'parent' => 'group_team_details',
            'instructions' => '',
            'required' => 0,
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'min_width' => 0,
            'min_height' => 0,
            'max_width' => 0,
            'max_height' => 0,
        ));

        if ($this->showSocial) {
            // facebook
            acf_add_local_field(array(
                'key' => 'facebook',
                'label' => 'Facebook URL',
                'name' => 'facebook',
                'type' => 'text',
                'parent' => 'group_team_details',
            ));
            // linkedin
            acf_add_local_field(array(
                'key' => 'linkedin',
                'label' => 'LinkedIn URL',
                'name' => 'linkedin',
                'type' => 'text',
                'parent' => 'group_team_details',
            ));
            // instagram
            acf_add_local_field(array(
                'key' => 'instagram',
                'label' => 'Instagram URL',
                'name' => 'instagram',
                'type' => 'text',
                'parent' => 'group_team_details',
            ));
            // twitter
            acf_add_local_field(array(
                'key' => 'twitter',
                'label' => 'Twitter URL',
                'name' => 'twitter',
                'type' => 'text',
                'parent' => 'group_team_details',
            ));
        }

    }

    public function addField(array $field)
    {
        acf_add_local_field($field);

        return $this;
    }

}
