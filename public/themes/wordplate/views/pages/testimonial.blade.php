@extends('layouts.main')
@section('content')

@if (have_posts())
    @while (have_posts())
        {{ the_post() }}
        @include('partials.mast')
        <main role="main" class="pb-5">
            
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <article class="support">
                            <header>
                            </header>

                            {{ the_content() }}
                            <p>&mdash; {{ get_field('byline') }}</p>
                            <p class="mt-5"><a class="btn btn-primary" href="/testimonials/#{{ get_the_ID() }}">Back to testimonials</a></p>
                        </article>
                    </div>

                </div>
            </div>

        </main>
    @endwhile
@else
    @include('pages.404')
@endif

@endsection