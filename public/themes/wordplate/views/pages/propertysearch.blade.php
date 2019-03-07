@extends('layouts.main')
@section('content')

@if (have_posts())
    @while (have_posts())
        {{ the_post() }}
        @include('partials.mast')
        <main role="main" class="pb-5">
            <div class="container-wide">
                <article class="support">
                    <header class="pt-0 pt-xl-5 text-center text-md-left">
                        <h1>{{ $headline }}</h1>
                    </header>
                    {{ the_content() }}

                </article>

                <search-bar v-bind:search-terms='{{ $currentRequest }}' class="search-bar mb-4 mb-md-0"></search-bar>

                @if($resultsMeta->total > 0)
                    <hr class="d-none d-md-block">
                    <div class="d-none d-md-flex row justify-content-between mb-4">
                        <div class="col-auto">
                            <small class="text-muted">
                                Showing {{ $resultsMeta->count }}
                                of {{ number_format($resultsMeta->total) }} |
                                page {{ $resultsMeta->current_page }}
                                of {{ $resultsMeta->total_pages }}
                            </small>
                        </div>
                        <div class="col-auto text-md-right">
                            <sort-form field-value="{{ $currentSort }}" :search-terms='{{ $currentRequest}}' class="sort-form" ></sort-form>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($results->data as $miniListing)
                            <div class="col-md-6 col-lg-4 col-xl-3 mb-4 mt-1" >
                            @include('partials.minilisting')
                            </div>
                        @endforeach
                    </div>

                    <div class="pager d-flex justify-content-center my-2">
                        {!! $pagination !!}
                    </div>

                @else

                    <p class="my-4">There were no properties found using your search criteria. Please broaden your search and try again.</p>

                @endif

            </div>

        </main>
    @endwhile
@else
    @include('pages.404')
@endif
@endsection