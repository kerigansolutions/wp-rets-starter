<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <article class="support">
                <header>
                    <h1>{{ $headline != '' ? $headline : the_title() }}</h1>
                </header>

                {{-- @if(has_post_thumbnail())
                    {{ the_post_thumbnail('post-thumbnail', ['class' => 'img-fluid mb-3']) }}
                @endif --}}

                {{ the_content() }}
            </article>
        </div>

        <div class="col pt-4" >
            @include('partials.sidebar')
        </div>

    </div>
</div>
