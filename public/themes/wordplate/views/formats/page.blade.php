<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <article class="support">
                <header>
                    <h1>{{ $headline != '' ? $headline : the_title() }}</h1>
                </header>

                {{ the_content() }}
            </article>
        </div>

    </div>
</div>

