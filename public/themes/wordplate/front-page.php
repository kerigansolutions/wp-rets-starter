<?php

$featureBoxes = [];
for($i = 1; $i <= $wordplate->themeSettings['number_feature_boxes']; $i++){
    $featureBoxes[] = [
        'headline' => get_field('headline_' . $i),
        'text' => get_field('text_' . $i),
        'link' => get_field('link_' . $i),
        'link_text' => get_field('link_text_' . $i),
        'box_color' => get_field('box_color_' . $i),
        'border_color' => get_field('border_color_' . $i),
        'text_color' => get_field('text_color_' . $i),
        'class' => get_field('class_' . $i),
        'background_image' => get_field('image_' . $i),
        'overlay' => get_field('overlay_color_' . $i)
    ];
}

$featuredListings = (new KeriganSolutions\KMARealtor\FeaturedListings)->getListings();

bladerunner('views.pages.front', [
    'themeSettings'     => $wordplate->themeSettings,
    'headshot'          => wp_get_attachment_url(get_field('agent_photo', 'option'),'medium'),
    'featuredListings'  => true,
    'featureBoxes'      => $featureBoxes,
    'featuredListings'  => $featuredListings
]);