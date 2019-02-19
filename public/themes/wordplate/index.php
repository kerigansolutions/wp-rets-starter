<?php
$headerImageData = get_field('header_image');

bladerunner('views.pages.index',[
    'headerImage' => $headerImageData['url'],
    'headerOverlay' => get_field('overlay_color'),
    'headline'    => get_field('headline')
]);