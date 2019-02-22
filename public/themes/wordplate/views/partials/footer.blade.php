<footer class="sticky-footer bg-dark py-4">
    <div class="container text-center">
        <h4>Contact Me</h4>
        <p class="m-0"><a href="tel:{{ get_field('phone', 'option') }}">{{ get_field('phone', 'option') }}</a></p>
        <p><a href="mailto:{{ get_field('email', 'option') }}">{{ get_field('email', 'option') }}</a></p>
        <social-icons :size="37" :margin=".25" class="d-flex social-icons justify-content-center mb-4" ></social-icons>

        <contact-form class="contact-form"></contact-form>

        @if(get_field('broker_logo', 'option'))
        <div class="broker-logo" >
            {!! (get_field('broker_link', 'option') ? '<a href="'.get_field('broker_link', 'option').'" target="_blank" >' : null) !!}
            <img src="{{ wp_get_attachment_url(get_field('broker_logo', 'option'),'medium') }}" alt="{{ get_field('broker_name', 'option') }}" >
            {!! (get_field('broker_link', 'option') ? '</a>' : null) !!}
        </div>
        @endif

    </div>
    <hr>
    <p class="copyright text-center">&copy;{{ date('Y') }} {{ get_bloginfo() }}. All Rights&nbsp;Reserved. 
        <a style="text-decoration:underline;" href="/privacy-policy" >Privacy&nbsp;Policy</a> 
        <span class="siteby">
            <svg version="1.1" id="kma" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="14" width="20"
                viewBox="0 0 12.5 8.7" style="enable-background:new 0 0 12.5 8.7;"
                xml:space="preserve">
                    <path fill="#b4be35"
                d="M6.4,0.1c0,0,0.1,0.3,0.2,0.9c1,3,3,5.6,5.7,7.2l-0.1,0.5c0,0-0.4-0.2-1-0.4C7.7,7,3.7,7,0.2,8.5L0.1,8.1 c2.8-1.5,4.8-4.2,5.7-7.2C6,0.4,6.1,0.1,6.1,0.1H6.4L6.4,0.1z"></path>
            </svg> &nbsp;<a href="https://keriganmarketing.com">Site&nbsp;by&nbsp;KMA</a>.
        </span></p>
</footer>