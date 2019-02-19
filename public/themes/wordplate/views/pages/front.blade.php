@extends('layouts.main')

@section('content')
@if (have_posts())
    @while (have_posts())
        {{ the_post() }}
                
        @if(get_theme_mod('header_feature') == 'slider')
            <kma-slider 
                class="slider-container" 
                style="
                    height: {{ get_theme_mod('top_section_height') }};
                    "
            ></kma-slider>
        @endif

        @if(get_theme_mod('header_feature') == 'main-image')
            @include('partials.headerimage')
        @endif
        
        @if($headshot != '')
        <div class="headshot d-flex justify-content-center" >
            <img src="{{ $headshot['url'] }}" class="rounded-circle" style="width:250px; margin-top:-125px;">
        </div>
        @endif

        <main role="main">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-9">
                        <article class="front pb-4 text-center">
                            <header>
                                <h1>{{ the_title() }}</h1>
                            </header>
                            
                            {{ the_content() }}

                        </article>
                    </div>
                </div>
            </div>
        </main>

        @if($featuredListings)
        <div class="featured-listings-section bg-dark text-center text-white">
            <div class="section-title">
                <h2>Featured Listings</h2>
            </div>
            <div class="container-wide pb-3">
                <carousel 
                    :per-page-custom="[[320,1],[576,2],[1024,3],[1200,4]]" 
                    :autoplay="true"
                    :loop="true"
                    :pagination-enabled="false"
                    {{-- pagination-position="top"
                    pagination-active-color="red" --}}
                    :scroll-per-page="false"
                    :navigation-enabled="true"
                    navigation-next-label='<i class="fa fa-chevron-right text-white" aria-hidden="true"></i>'
                    navigation-prev-label='<i class="fa fa-chevron-left text-white" aria-hidden="true"></i>'
                    class="row" 
                    >
                    @foreach($featuredListings as $listing)
                    <slide class="col-md-6 col-lg-4 col-xl-3">
                    @include('partials.minilisting')
                    </slide>
                    @endforeach
                </carousel>
            </div>
            <div class="section-button">
                <a class="btn btn-primary" href="/my-listings" >All My Listings</a>
            </div>
        </div>
        @endif

        @include('partials.featureboxes')

    @endwhile
@else
    @include('pages.404')
@endif
@endsection