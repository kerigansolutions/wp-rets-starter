<?php
$headerImageData = get_field('header_image',get_option( 'page_for_posts' ));

bladerunner('views.pages.home', [
    'headerImage' => $headerImageData['url'],
    'headerOverlay' => get_field('overlay_color',get_option( 'page_for_posts' )),
    'headline'    => get_field('headline',get_option( 'page_for_posts' ))
]);