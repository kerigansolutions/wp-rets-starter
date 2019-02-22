<?php

$search = new KeriganSolutions\KMARealtor\Search();

bladerunner('views.pages.propertysearch', [
    'results'        => ($search->getListings())->data,
    'currentRequest' => $search->getCurrentRequest(),
    'resultsMeta'    => $search->getResultMeta(),
    'currentSort'    => $search->getSort(),
    'pagination'     => $search->buildPagination(),
    'headerImage' => (get_field('header_image') ? (get_field('header_image'))['url'] : wp_get_attachment_url(get_theme_mod('home_header_image'))),
    'headerOverlay' => get_field('overlay_color'),
    'headline'    => get_field('headline')
]);