<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <article class="support">

                @if(has_post_thumbnail())
                    {{ the_post_thumbnail('post-thumbnail', ['class' => 'img-fluid mb-3']) }}
                @endif

                {{ the_content() }}
            </article>
        </div>
    </div>
</div>

