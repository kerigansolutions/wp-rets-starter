@extends('layouts.main')

@section('content')
@include('partials.mast')
<main role="main" class="pb-5">
    <div class="container">
        <article class="support">
            <header>
                <h1>{{ $headline != '' ? $headline : 'My Blog' }}</h1>
            </header>
        </article>
        @if (have_posts())
            <div class="card-columns">
            @while (have_posts())
                @include('partials.article')
            @endwhile
            </div>
        @else
            @include('pages.404')
        @endif
    </div>
</main>
@endsection