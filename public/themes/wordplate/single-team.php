<?php

$headerImageData = get_field('header_image');

bladerunner('views.pages.bio', [
    'team' => [
        'image' => get_field('image'),
        'email' => get_field('email'),
        'phone' => get_field('phone'),
        'facebook' => get_field('facebook'),
        'linkedin' => get_field('linkedin'),
        'instagram' => get_field('instagram'),
        'twitter' => get_field('twitter')
    ],
    'headerImage' => isset($headerImageData['url']) ? $headerImageData['url'] : 'https://demo.bigfishconstruction.com/uploads/2018/08/img_5520-e1533138862672.jpg',
    'headline'    => get_field('headline')
]);