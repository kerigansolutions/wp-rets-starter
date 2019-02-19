<?php
/*
 * This file adds ACF controlled fields on pages.
 * 
 */

 // support page attributes
// Don't die if ACF isn't installed
if ( function_exists( 'acf_add_local_field_group' ) ) {
    add_action( 'acf/init', 'registerFields' );
}

function registerFields(){
    // ACF Group: Page Details
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
        'preview_size'  => 'large',
        'library'       => 'all',
        'min_width'     => 0,
        'min_height'    => 0,
        'max_width'     => 0,
        'max_height'    => 0,
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
