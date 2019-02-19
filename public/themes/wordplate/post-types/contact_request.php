<?php

/**
 * Registers the `contact_request` post type.
 */
function contact_request_init() {
	register_post_type( 'contact_request', array(
		'labels'                => array(
			'name'                  => __( 'Leads', 'wordplate' ),
			'singular_name'         => __( 'Lead', 'wordplate' ),
			'all_items'             => __( 'All Leads', 'wordplate' ),
			'archives'              => __( 'Lead Archives', 'wordplate' ),
			'attributes'            => __( 'Lead Attributes', 'wordplate' ),
			'insert_into_item'      => __( 'Insert into Lead', 'wordplate' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Lead', 'wordplate' ),
			'featured_image'        => _x( 'Featured Image', 'contact_request', 'wordplate' ),
			'set_featured_image'    => _x( 'Set featured image', 'contact_request', 'wordplate' ),
			'remove_featured_image' => _x( 'Remove featured image', 'contact_request', 'wordplate' ),
			'use_featured_image'    => _x( 'Use as featured image', 'contact_request', 'wordplate' ),
			'filter_items_list'     => __( 'Filter Leads list', 'wordplate' ),
			'items_list_navigation' => __( 'Leads list navigation', 'wordplate' ),
			'items_list'            => __( 'Leads list', 'wordplate' ),
			'new_item'              => __( 'New Lead', 'wordplate' ),
			'add_new'               => __( 'Add New', 'wordplate' ),
			'add_new_item'          => __( 'Add New Lead', 'wordplate' ),
			'edit_item'             => __( 'Edit Lead', 'wordplate' ),
			'view_item'             => __( 'View Lead', 'wordplate' ),
			'view_items'            => __( 'View Leads', 'wordplate' ),
			'search_items'          => __( 'Search Leads', 'wordplate' ),
			'not_found'             => __( 'No Leads found', 'wordplate' ),
			'not_found_in_trash'    => __( 'No Leads found in trash', 'wordplate' ),
			'parent_item_colon'     => __( 'Parent Lead:', 'wordplate' ),
			'menu_name'             => __( 'Leads', 'wordplate' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title'),
		'has_archive'           => false,
		'rewrite'               => false,
		'query_var'             => true,
		'menu_icon'             => 'dashicons-admin-post',
		'show_in_rest'          => true,
		'rest_base'             => 'contact_request',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'contact_request_init' );

/**
 * Sets the post updated messages for the `contact_request` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `contact_request` post type.
 */
function contact_request_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['contact_request'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Lead updated. <a target="_blank" href="%s">View Lead</a>', 'wordplate' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'wordplate' ),
		3  => __( 'Custom field deleted.', 'wordplate' ),
		4  => __( 'Lead updated.', 'wordplate' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Lead restored to revision from %s', 'wordplate' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Lead published. <a href="%s">View Lead</a>', 'wordplate' ), esc_url( $permalink ) ),
		7  => __( 'Lead saved.', 'wordplate' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Lead submitted. <a target="_blank" href="%s">Preview Lead</a>', 'wordplate' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Lead scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Lead</a>', 'wordplate' ),
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Lead draft updated. <a target="_blank" href="%s">Preview Lead</a>', 'wordplate' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
function kma_add_contact_metaboxes()
{
	add_meta_box(
		'email',
		'Email Address',
		'contact_email_metabox',
		'contact_request',
		'normal',
		'default'
	);

	add_meta_box(
		'phone',
		'Phone Number',
		'contact_phone_metabox',
		'contact_request',
		'normal',
		'default'
	);

	add_meta_box(
		'comments',
		'Comments',
		'contact_comments_metabox',
		'contact_request',
		'normal',
		'default'
	);
}

function contact_email_metabox()
{
	global $post;
	// Get the location data if it's already been entered
    $email = get_post_meta($post->ID, 'email', true);
	// Output the field
	echo '<a href="mailto:' . $email . '">' . $email .'</a>';
}

function contact_phone_metabox()
{
	global $post;
	// Get the location data if it's already been entered
    $phone = get_post_meta($post->ID, 'phone', true);
	// Output the field
	echo '<a href="tel:' . $phone . '">' . $phone .'</a>';
}

function contact_comments_metabox()
{
	global $post;
	// Get the location data if it's already been entered
    $comments = get_post_meta($post->ID, 'comments', true);
	// Output the field
	echo '<p>'. $comments . '</p>';
}

add_filter( 'post_updated_messages', 'contact_request_updated_messages' );
add_action('add_meta_boxes', 'kma_add_contact_metaboxes');
