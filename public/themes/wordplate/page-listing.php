<?php
bladerunner('views.pages.listing', [
    'listing' => (new KeriganSolutions\KMARealtor\Listing())->get(),
    'headerImage' => (get_field('header_image') ? (get_field('header_image'))['url'] : wp_get_attachment_url(get_theme_mod('home_header_image'))),
    'headerOverlay' => get_field('overlay_color'),
]);