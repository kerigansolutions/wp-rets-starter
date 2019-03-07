@extends('layouts.main')
@section('content')

@if (have_posts())
    @while (have_posts())
        {{ the_post() }}
        @include('partials.mast')
        <main role="main" class="pb-5">
            <div class="container">
                <article class="support">

                    <div class="row align-items-center">

                        <div class="col-12 col-lg-auto pl-xl-5 order-lg-2">
                            <div class="d-flex flex-lg-column flex-wrap align-items-center align-lg-items-start">
                                <div class="col-md-6 col-lg-auto">
                                @include('listing.header')
                                </div>
                                <div class="col-md-6 col-lg-auto text-center text-md-left">
                                @include('listing.actionbuttons')
                                </div>   
                            </div>
                        </div>

                        <div class="col-12 col-lg order-lg-1 flex-grow-1">
                            @include('listing.mainphoto')
                        </div>

                    </div>
                    <div class="row">
                        
                        <div class="col-12 col-lg pt-lg-2">
                            <p>{{ $listing->remarks }}</p>
                        </div>

                        <div class="col-12 col-lg-auto pb-4">
                            <div class="p-4 d-flex flex-column align-items-center">
                            <h3 class="text-muted">Share this property</h3>
                            {!! do_shortcode('[Sassy_Social_Share]') !!}
                            </div>
                        </div>

                    </div>
                    
                    <photo-gallery 
                        @closeviewer="closeGallery"
                        @openviewer="openGallery"
                        :viewer-state="galleryIsOpen"
                        class="d-none d-sm-block mt-4 mb-5"
                        virtual-tour='{{ $listing->virtual_tour }}' 
                        :data-photos='{{ json_encode($listing->media_objects->data) }}'
                        item-class="col-sm-6 col-md-4 col-lg-3 col-xl-2" ></photo-gallery>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            @include('listing.details')
                        </div>
                        <div class="col-md-6 mb-4">
                            @include('listing.construction')
                        </div>

                        <div class="col-md-5 mb-4">
                            @include('listing.location')
                        </div>
                        <div class="col mb-4">
						    @include('listing.map')
                        </div>
                    </div>
                </article>
            </div>
        </main>
    @endwhile
@else
    @include('pages.404')
@endif
@endsection