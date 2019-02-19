@extends('layouts.main')
@section('content')

@if (have_posts())
    @while (have_posts())
        {{ the_post() }}
        @include('partials.mast')
        <main role="main">
            <div class="container">
                <article class="support">
                    <header class="text-primary">
                        <h1>{{ $headline != '' ? $headline : the_title() }}</h1>
                    </header>
                    <div class="row">
                        <div class="col-md-4">
                            <img class="img-fluid" src="{{ $team['image']['url'] }}">
                            <p>&nbsp;</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                            @if ($team['email'] != '')
                                <div class="col-auto">
                                    <a href="mailto:{{ $team['email'] }}">
                                    <span class="icon">
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    </span>&nbsp;{{ $team['email'] }}</a>
                                </div>
                            @endif
                            @if ($team['phone'] != '')
                                <div class="col-auto">
                                    <a href="mailto:{{ $team['phone'] }}">
                                    <span class="icon">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                    </span>&nbsp;{{ $team['phone'] }}</a>
                                </div>
                            @endif
                            </div>
                        <hr>
                        {{ the_content() }}

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