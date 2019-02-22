<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <article class="support">
                <header>
                    <h1></h1>
                </header>

                <p class="display-4">{{ $headline != '' ? $headline : the_title() }}</p>

                {{ the_content() }}
                
            </article>
        </div>

    </div>
</div>

