@extends('layouts.main')
@section('content')

@if (have_posts())
    @while (have_posts())
        {{ the_post() }}
        @include('partials.mast')
        <main role="main" class="pb-5">
            
            @if( is_page() )
                @include('formats.page')
            @else
                @include('formats.' . (get_post_format() != '' ? get_post_format() : 'standard'))
            @endif

        </main>
    @endwhile
@else
    @include('pages.404')
@endif

@endsection