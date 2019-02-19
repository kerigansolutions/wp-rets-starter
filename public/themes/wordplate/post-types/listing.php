<?php

/**
 * Registers the `listing` post type.
 */
function listing_init() {
	register_post_type( 'listing', array(
		'labels'                => array(
			'name'                  => __( 'Listings', 'wordplate' ),
			'singular_name'         => __( 'Listings', 'wordplate' ),
			'all_items'             => __( 'All Listings', 'wordplate' ),
			'archives'              => __( 'Listings Archives', 'wordplate' ),
			'attributes'            => __( 'Listings Attributes', 'wordplate' ),
			'insert_into_item'      => __( 'Insert into Listings', 'wordplate' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Listings', 'wordplate' ),
			'featured_image'        => _x( 'Featured Image', 'listing', 'wordplate' ),
			'set_featured_image'    => _x( 'Set featured image', 'listing', 'wordplate' ),
			'remove_featured_image' => _x( 'Remove featured image', 'listing', 'wordplate' ),
			'use_featured_image'    => _x( 'Use as featured image', 'listing', 'wordplate' ),
			'filter_items_list'     => __( 'Filter Listings list', 'wordplate' ),
			'items_list_navigation' => __( 'Listings list navigation', 'wordplate' ),
			'items_list'            => __( 'Listings list', 'wordplate' ),
			'new_item'              => __( 'New Listings', 'wordplate' ),
			'add_new'               => __( 'Add New', 'wordplate' ),
			'add_new_item'          => __( 'Add New Listings', 'wordplate' ),
			'edit_item'             => __( 'Edit Listings', 'wordplate' ),
			'view_item'             => __( 'View Listings', 'wordplate' ),
			'view_items'            => __( 'View Listings', 'wordplate' ),
			'search_items'          => __( 'Search Listings', 'wordplate' ),
			'not_found'             => __( 'No Listings found', 'wordplate' ),
			'not_found_in_trash'    => __( 'No Listings found in trash', 'wordplate' ),
			'parent_item_colon'     => __( 'Parent Listings:', 'wordplate' ),
			'menu_name'             => __( 'Listings', 'wordplate' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-admin-post',
		'show_in_rest'          => true,
		'rest_base'             => 'listing',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'listing_init' );

/**
 * Sets the post updated messages for the `listing` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `listing` post type.
 */
function listing_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['listing'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Listings updated. <a target="_blank" href="%s">View Listings</a>', 'wordplate' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'wordplate' ),
		3  => __( 'Custom field deleted.', 'wordplate' ),
		4  => __( 'Listings updated.', 'wordplate' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Listings restored to revision from %s', 'wordplate' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Listings published. <a href="%s">View Listings</a>', 'wordplate' ), esc_url( $permalink ) ),
		7  => __( 'Listings saved.', 'wordplate' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Listings submitted. <a target="_blank" href="%s">Preview Listings</a>', 'wordplate' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Listings scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Listings</a>', 'wordplate' ),
		date_i18n( __( 'M j, Y @ G:i', 'wordplate' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Listings draft updated. <a target="_blank" href="%s">Preview Listings</a>', 'wordplate' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'listing_updated_messages' );
