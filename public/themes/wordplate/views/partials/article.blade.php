{{ the_post() }}

@if(get_post_format() == '' || get_post_format() == 'standard')
<div class="card">
    @if(has_post_thumbnail())
        <a href="{{ the_permalink() }}" title="{{ the_title_attribute() }}">
        {{ the_post_thumbnail('post-thumbnail', ['class' => 'card-img-top']) }}
        </a>
    @endif
    <div class="card-body">
        <h2 class="card-title">{{ the_title() }}</h2>
            <small class="text-muted">{{ get_the_date() }}</small>

            {{ the_excerpt() }}

            <a href="{{ the_permalink() }}" >Read more</a>
    </div>
</div>
@endif

@if(get_post_format() == 'status')
<div class="card bg-primary">
    <div class="card-body text-white">
        <small class="text-white">{{ get_the_date() }}</small>
        <p class="display-4">{{ the_title() }}</p>
        {{ the_content() }}
    </div>
</div>
@endif

@if(get_post_format() == 'quote')
<div class="card bg-secondary">
    <div class="card-body text-white">
        {{ the_excerpt() }}
        <small class="text-white">&mdash; {{ the_title() . ', ' . get_the_date() }}</small>
    </div>
</div>
@endif

@if(get_post_format() == 'image')
<div class="card">
    <div class="position-absolute p-3 px-4">
        <p class="text-white m-0">{{ the_title() }}<br>
        <small class="text-white">{{ get_the_date() }}</small></p>
    </div>
    @if(has_post_thumbnail())
        <a href="{{ the_permalink() }}" title="{{ the_title_attribute() }}">
        {{ the_post_thumbnail('post-thumbnail', ['class' => 'card-img-top']) }}
        </a>
    @endif
</div>
@endif

@if(get_post_format() == 'video')
<div class="card bg-dark video">
    {!! the_content() !!}

    <div class="pb-3 px-4" >
        <p class="text-white m-0">{{ the_title() }}<br>
        <small class="text-white">{{ get_the_date() }}</small></p>
    </div>
</div>
@endif