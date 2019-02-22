<?php

$realtorListings = new KeriganSolutions\KMARealtor\RealtorListings();
$listings = $realtorListings->getListings();

bladerunner('views.pages.mylistings', [
    'results'        => $listings,
    'numResults'     => count($listings),
    'currentRequest' => $realtorListings->getCurrentRequest(),
    'currentSort'    => $realtorListings->getSort(),
    'headerImage'    => (get_field('header_image') ? (get_field('header_image'))['url'] : wp_get_attachment_url(get_theme_mod('home_header_image'))),
    'headerOverlay'  => get_field('overlay_color'),
    'headline'       => get_field('headline')
]);