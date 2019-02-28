<div class="main-header-image shadow" >
    <video-bg 
        v-bind:sources="['{{ wp_get_attachment_url(get_theme_mod('video_upload')) }}']" 
        img="{{ wp_get_attachment_url(get_theme_mod('home_header_image')) }}">
    </video-bg>
    <div class="slider-content">
        <div class="container">
            <div 
                class="overlay-content"
            >
            {!! apply_filters('the_content', (get_post(get_theme_mod('overlay_content')))->post_content) !!}
            </div>
        </div>
    </div>
    @if(get_theme_mod('use_overlay_text'))
        <div 
            class="overlay"
            style="
                background-color: {{ get_theme_mod('overlay_color') }};
                opacity: {{ get_theme_mod('overlay_opacity') }};
            "
        ></div>
    @endif
</div>