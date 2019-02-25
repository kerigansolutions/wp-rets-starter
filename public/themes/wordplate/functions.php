<?php

declare(strict_types=1);

use KeriganSolutions\KMARealtor;
use Includes\Modules\KMAMail;

require template_path('includes/ThemeControl.php');
require('post-types/contact_request.php');
$wordplate = new ThemeControl();

// Set theme defaults.
add_action('after_setup_theme', function () {
    // Disable the admin toolbar.
    show_admin_bar(false);

    add_theme_support('post-thumbnails');
    add_theme_support( 'custom-logo', [
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => ['site-title', 'site-description'],
    ] );
    add_theme_support('title-tag');
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'widgets',
    ]);
    add_theme_support( 'post-formats', [
        // 'aside',
        'gallery',
        'image',
        'status',
        'quote', 
        'video'
    ]);
});

// Enqueue and register scripts the right way.
add_action('wp_enqueue_scripts', function () {
    wp_deregister_script('jquery');
    wp_enqueue_style('wordplate', mix('styles/main.css'), [], null);
    wp_register_script('wordplate', mix('scripts/app.js'), '', '', true);
    wp_enqueue_script('wordplate', mix('scripts/app.js'), '', '', true);
});

// Custom Blade Cache Path
add_filter('bladerunner/cache/path', function () {
    return '../../uploads/.cache';
});


//[quicksearch]
function quicksearch_func( $atts ){
    ob_start();
    ?>
    <div class="quick-search p-4 p-sm-0 p-md-4 d-inline-block text-white">
        <form action="property-search">
        <input name="q" value="search" type="hidden" >
        <div class="row align-items-center no-gutters">
            <div class="col-12 col-sm-5 col-md-auto mb-2 pr-sm-2 pr-md-0">
                <property-type></property-type>
            </div>
            <div class="d-none d-md-block col-auto mb-2 px-4">IN</div>
            <div class="col-9 col-sm-5 col-md-auto mb-2 pr-4">
                <area-field></area-field>
            </div>
            <div class="col-3 col-sm col-md-auto mb-2">
                <button class="btn btn-block btn-primary">GO</button>
            </div>
        </div>
        </form>
    </div>
    <?php
	return ob_get_clean();
}
add_shortcode( 'quicksearch', 'quicksearch_func' );

function getVideoImageFromEmbed($postContent){
    if($postContent == ''){
        return false;
    }
    preg_match('/src="(.*?)"/', $postContent, $video);

    print_r($video);
    $videoParts = explode('/',$video[2]);
    return 'https://img.youtube.com/vi/'.$videoParts[3].'/maxresdefault.jpg';
}

// Add og:video meta tag for episodes and videos
function yoast_add_og_video() {
    if ( get_post_format() == 'video' ) {
        $post = get_post();
        preg_match('/\[embed(.*)](.*)\[\/embed]/', $post->post_content, $video);
        $videoParts = explode('/',$video[2]);
        echo '<meta property="og:video" content="' .  $video[2] . '" />', "\n";
        echo '<meta property="og:video:secure_url" content="' .  str_replace('http://','https://' , $video[2]) . '" />', "\n";
        echo '<meta property="og:video:height" content="1080" />', "\n";
        echo '<meta property="og:video:width" content="1920" />', "\n";
        //echo '<meta property="og:image" content="https://img.youtube.com/vi/'.$videoParts[3].'/maxresdefault.jpg" />', "\n";
    }
}
add_action( 'wpseo_opengraph', 'yoast_add_og_video', 10, 1 );

add_filter('wpseo_opengraph_image', function () {
    if ( get_post_format() == 'video' ) {
        $post = get_post();
        return getVideoImageFromEmbed($post->post_content);
    }
});

//[quicksearch]
function testimonial_func( $atts ){
    $testimonials = (new KeriganSolutions\KMATestimonials\Testimonial)->queryTestimonials(false, -1, 'date', 'ASC', 50);

    ob_start();
    ?>
    <div class="testimonials">
        <?php foreach($testimonials as $testimonial){ ?>
            <div class="testimonial border-bottom py-3" >
                <a class="pad-anchor" name="<?php echo $testimonial->ID; ?>"></a>
                <p><?php echo $testimonial->excerpt; ?> 
                <a href="<?php echo get_permalink($testimonial->ID); ?>">read more.</a></p>
                <p class="byline">&mdash; <?php echo $testimonial->byline; ?></p>
            </div>
        <?php } ?>
    </div>
    <?php
	return ob_get_clean();
}
add_shortcode( 'testimonials', 'testimonial_func' );