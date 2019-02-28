<div 
    class="main-header-image shadow"
    style="background-image: url({{ wp_get_attachment_url(get_theme_mod('home_header_image')) }});" 
    >
    <div class="container">
        <div 
            class="overlay-content"
            style="
                color: {{ get_theme_mod('overlay_text_color') }};
            "
        >
        {!! apply_filters('the_content', (get_post(get_theme_mod('overlay_content')))->post_content) !!}
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