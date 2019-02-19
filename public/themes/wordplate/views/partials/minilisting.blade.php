<div class="card listing bg-white" >
    @if(date('Ymd', strtotime($listing->list_date)) >= date('Ymd', strtotime('-10 days')))
        <span class="status-flag just-listed">Just Listed</span>
    @endif
    @if($listing->status == 'Sold/Closed')
        <span class="status-flag sold">Sold on <?php echo date( 'M j, Y', strtotime( $listing->sold_on ) ); ?><br>
                    for $<?php echo number_format( $listing->sold_for ); ?></span>
    @endif
    @if($listing->status == 'Contingent')
        <span class="status-flag contingent">SALE CONTINGENT</span>
    @endif
    @if($listing->original_list_price > $listing->price && $listing->status == 'Active' && $listing->original_list_price != 0)
        <span class="status-flag reduced bg-danger">REDUCED <span style="text-decoration:line-through">$<?php echo number_format( $listing->original_list_price ); ?></span> <strong>$<?php echo number_format( $listing->price); ?></strong></span>
    @endif
    <div 
        class="embed-responsive embed-responsive-16by9 main-image"
        style="background: url({{ $listing->media_objects->data[0]->url }}) center no-repeat"
        ></div>
    <div class="p-4 text-center text-dark flex-grow-1">
        <p>{{ $listing->full_address }}<br>
           {{ $listing->city . ', ' . $listing->state }}</p>
        <p class="display-4 text-primary font-weight-bold">${{ number_format($listing->price) }}</p>

        <div class="row justify-content-center">
        @if($listing->bedrooms > 0)
            <div class="col">
                <span class="display-4 text-secondary">{{ number_format($listing->bedrooms) }}</span><br>
                <small class="text-muted">BEDS</small>
            </div>
        @endif
        @if($listing->total_bathrooms > 0)
            <div class="col">
                <span class="display-4 text-secondary">{{ number_format($listing->total_bathrooms) }}</span><br>
                <small class="text-muted">BATHS</small>
            </div>
        @endif
        @if($listing->sqft > 0)
            <div class="col">
                <span class="display-4 text-secondary">{{ number_format($listing->sqft) }}</span><br>
                <small class="text-muted">SQFT</small>
            </div>
        @endif
        {{-- @if($listing->lot_dimensions > 0 && $listing->bedrooms == 0)
            <div class="col">
                <span class="display-4 text-secondary">{{ $listing->lot_dimensions }}</span><br>
                <small class="text-muted">LOT SIZE</small>
            </div>
        @endif --}}
        @if($listing->acreage > 0 && $listing->bedrooms == 0)
            <div class="col">
                <span class="display-4 text-secondary">{{ $listing->acreage }}</span><br>
                <small class="text-muted">ACRES</small>
            </div>
        @endif
        </div>
    </div>
    <div class="p-2 text-center"><span class="mls-number">MLS# {{ $listing->mls_account }}</span></div>
    <a class="position-absolute listing-link" href="/listing/{{ $listing->mls_account }}/" ></a>
</div>
