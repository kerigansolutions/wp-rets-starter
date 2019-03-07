<div class="card listing bg-white" >
    @if(date('Ymd', strtotime($miniListing->list_date)) >= date('Ymd', strtotime('-10 days')))
        <span class="status-flag just-listed">Just Listed</span>
    @endif
    @if($miniListing->status == 'Sold/Closed')
        <span class="status-flag sold">Sold on <?php echo date( 'M j, Y', strtotime( $miniListing->sold_on ) ); ?><br>
                    for $<?php echo number_format( $miniListing->sold_for ); ?></span>
    @endif
    @if($miniListing->status == 'Contingent')
        <span class="status-flag contingent">SALE CONTINGENT</span>
    @endif
    @if($miniListing->original_list_price > $miniListing->price && $miniListing->status == 'Active' && $miniListing->original_list_price != 0)
        <span class="status-flag reduced bg-danger">REDUCED <span style="text-decoration:line-through">$<?php echo number_format( $miniListing->original_list_price ); ?></span> <strong>$<?php echo number_format( $miniListing->price); ?></strong></span>
    @endif
    <div 
        class="embed-responsive embed-responsive-16by9 main-image"
        style="background: url({{ $miniListing->media_objects->data[0]->url }}) center no-repeat"
        ></div>
    <div class="p-4 text-center text-dark flex-grow-1">
        <p>{{ $miniListing->full_address }}<br>
           {{ $miniListing->city . ', ' . $miniListing->state }}</p>
        <p class="property-type text-muted">{{ $miniListing->prop_type }}</p>

        @if($miniListing->price !== null)
        <p class="display-4 text-primary font-weight-bold">${{ number_format($miniListing->price) }}</p>
        @elseif(isset($miniListing->monthly_rent))
        <p class="display-4 text-primary font-weight-bold">${{ number_format($miniListing->monthly_rent) }} <small>/ mo.</small></p>
        @endif
        <div class="row justify-content-center">
        @if($miniListing->bedrooms > 0)
            <div class="col">
                <span class="display-4 text-secondary">{{ number_format($miniListing->bedrooms) }}</span><br>
                <small class="text-muted">BEDS</small>
            </div>
        @endif
        @if($miniListing->total_bathrooms > 0)
            <div class="col">
                <span class="display-4 text-secondary">{{ number_format($miniListing->total_bathrooms) }}</span><br>
                <small class="text-muted">BATHS</small>
            </div>
        @endif
        @if($miniListing->sqft > 0)
            <div class="col">
                <span class="display-4 text-secondary">{{ number_format($miniListing->sqft) }}</span><br>
                <small class="text-muted">SQFT</small>
            </div>
        @endif
        {{-- @if($miniListing->lot_dimensions > 0 && $miniListing->bedrooms == 0)
            <div class="col">
                <span class="display-4 text-secondary">{{ $miniListing->lot_dimensions }}</span><br>
                <small class="text-muted">LOT SIZE</small>
            </div>
        @endif --}}
        @if($miniListing->acreage > 0 && $miniListing->bedrooms == 0)
            <div class="col">
                <span class="display-4 text-secondary">{{ $miniListing->acreage }}</span><br>
                <small class="text-muted">ACRES</small>
            </div>
        @endif
        </div>
    </div>
    <div class="p-2 text-center"><span class="mls-number">MLS# {{ $miniListing->mls_account }}</span></div>
    <a class="position-absolute listing-link" href="/listing/{{ $miniListing->mls_account }}/" ></a>
</div>
