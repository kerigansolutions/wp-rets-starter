<div class="testimonial-section text-center">

    @foreach($featuredTestimonial as $testimonial)
        <div class="container">
            <div class="testimonials text-center">
                <div class="testimonial single">
                    <p class="shorttext">{!! $testimonial->truncate !!}</p>
                    <p class="author">{{ $testimonial->byline }}</p>
                </div>
            </div>
        </div>
    @endforeach

    <div class="section-button text-center">
        <a class="btn btn-lg btn-outline-white" href="/testimonials/">More Testimonials &nbsp; <i class="fa fa-angle-right" aria-hidden="true"></i></a>
    </div>
</div>