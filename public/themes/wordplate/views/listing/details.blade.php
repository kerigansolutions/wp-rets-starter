<div class="card listing-detail">
    <div class="card-header">Property Details</div>
    <table class="table">
    <tr><td>MLS Number</td><td>{{ $listing->mls_account }}</td></tr>
    <tr><td>Status</td><td>{{ $listing->status }}</td></tr>
    @if($listing->list_date != '')
        <tr><td>List Date</td><td>{{ date('M d, Y', strtotime($listing->list_date)) }}</td></tr>
    @endif
    @if($listing->date_modified != '' && date('Ymd', strtotime($listing->date_modified)) != date('Ymd', strtotime($listing->list_date)))
        <tr><td>Listing Updated</td><td>{{  date('M d, Y', strtotime($listing->date_modified)) }}</td></tr>
    @endif
    @if($listing->bedrooms != '' && $listing->bedrooms != '0')
        <tr><td>Bedrooms</td><td>{{ number_format($listing->bedrooms) }}</td></tr>
    @endif
    @if($listing->full_baths != '' && $listing->full_baths != '0')    
        <tr><td>Full Bathrooms</td><td>{{ number_format($listing->full_baths) }}</td></tr>
    @endif
    @if($listing->half_baths != '' && $listing->half_baths != '0')    
        <tr><td>Half Bathrooms</td><td>{{ number_format($listing->half_baths) }}</td></tr>
    @endif
    @if($listing->stories != '' && $listing->stories != '0')
        <tr><td>Stories</td><td>{{ $listing->stories }}</td></tr>
    @endif
    @if($listing->acreage != '' && $listing->acreage != '0')
        <tr><td>Acreage</td><td>{{ $listing->acreage }} Acres</td></tr>
    @endif
    @if($listing->total_hc_sqft != '' && $listing->total_hc_sqft != '0')
        <tr><td>H/C SqFt</td><td>{{ number_format($listing->total_hc_sqft) }} SqFt</td></tr>
    @endif
    @if($listing->sqft != '' && $listing->sqft != '0')
        <tr><td>Total SqFt</td><td>{{ number_format($listing->sqft) }} SqFt</td></tr>
    @endif
    @if($listing->lot_dimensions != '' && ($listing->lot_dimensions != '0' || $listing->lot_dimensions != ''))
        <tr><td>Lot Size</td><td>{{ $listing->lot_dimensions }}</td></tr>
    @endif
    </table>
</div>