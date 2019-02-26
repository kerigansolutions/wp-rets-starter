<header class="p-0 text-center text-md-left">
    <h1 class="mb-2">{{ the_title() }} <br>
        {{ $listing->city . ', ' . $listing->state }}</h1>

    @if($listing->status == 'Sold')
        <p>Sold on {{ date( 'M j, Y', strtotime( $listing->sold_on )) }} for <strong>${{ number_format($listing->sold_for) }}</strong></p>
    @else
    @if ( $listing->original_list_price > $listing->price && $listing->status == 'Active' && $listing->original_list_price != 0)
            <h5><span class="badge badge-secondary">Reduced!</span>
            <span style="text-decoration:line-through">${{ number_format( $listing->original_list_price ) }}</span></h5>
            <p class="price text-primary display-3">${{ number_format($listing->price) }}</p>
        @else
            <p class="price text-primary display-3">${{ number_format($listing->price) }}</p>
        @endif
                    
    @endif
</header>