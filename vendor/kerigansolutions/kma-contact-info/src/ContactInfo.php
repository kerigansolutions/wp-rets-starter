<?php
namespace KeriganSolutions\KMAContactInfo;

class ContactInfo
{
    public function addField(array $field)
    {
        acf_add_local_field($field);

        return $this;
    }
    public function use()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page(array(
                'page_title' => 'Contact Info',
                'menu_title' => 'Contact Info',
                'menu_slug' => 'contact-info',
                'capability' => 'edit_posts',
                'icon_url' => 'dashicons-info',
                'redirect' => false
            ));
        }
        acf_add_local_field_group(array(
            'key' => 'group_contact_info',
            'title' => 'Contact info',
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'contact-info',
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
            'key' => 'address',
            'label' => 'Address',
            'name' => 'address',
            'type' => 'textarea',
            'parent' => 'group_contact_info',
        ));
// email
        acf_add_local_field(array(
            'key' => 'email',
            'label' => 'Email',
            'name' => 'email',
            'type' => 'text',
            'parent' => 'group_contact_info',
        ));
// local phone
        acf_add_local_field(array(
            'key' => 'phone',
            'label' => 'Phone',
            'name' => 'phone',
            'type' => 'text',
            'parent' => 'group_contact_info',
        ));

// toll-free phone
        acf_add_local_field(array(
            'key' => 'toll_free_phone',
            'label' => 'Toll Free Phone',
            'name' => 'toll_free_phone',
            'type' => 'text',
            'parent' => 'group_contact_info',
        ));
// toll-free phone
        acf_add_local_field(array(
            'key' => 'fax',
            'label' => 'Fax',
            'name' => 'fax',
            'type' => 'text',
            'parent' => 'group_contact_info',
        ));
// Image
        acf_add_local_field(array(
            'key' => 'image',
            'label' => 'Image',
            'name' => 'image',
            'type' => 'image',
            'parent' => 'group_contact_info',
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
    }
}
