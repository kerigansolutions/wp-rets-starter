<?php
bladerunner('views.pages.home', [
    'headerImage' => (get_field('header_image',get_option( 'page_for_posts' )) ? (get_field('header_image',get_option( 'page_for_posts' )))['url'] : wp_get_attachment_url(get_theme_mod('home_header_image'))),
    'headerOverlay' => get_field('overlay_color',get_option( 'page_for_posts' )),
    'headline'    => get_field('headline',get_option( 'page_for_posts' ))
]);