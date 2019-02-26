<div class="card listing-detail">
    <div class="card-header">Area Information</div>
    <table class="table">
    @if($listing->area != '')
        <tr><td>Area</td><td>{{ $listing->area }}</td></tr>
    @endif
    @if($listing->sub_area != '')
        <tr><td>Sub Area</td><td>{{ $listing->sub_area }}</td></tr>
    @endif
    @if($listing->subdivision != '')
        <tr><td>Subdivision</td><td>{{ $listing->subdivision }}</td></tr>
    @endif
    @if($listing->hoa_included != '')
        <tr><td>HOA Includes</td><td>{{ $listing->hoa_included }}</td></tr>
    @endif
    @if($listing->hoa_fee != '' && $listing->hoa_fee != '0')
        <tr><td>HOA Fee</td><td>${{ number_format($listing->hoa_fee) }}</td></tr>
    @endif
    @if($listing->hoa_terms != '' && $listing->hoa_terms != '0')
        <tr><td>HOA Term</td><td>{{ $listing->hoa_terms }}</td></tr>
    @endif
    @if($listing->proj_name != '')
        <tr><td>Community</td><td>{{ $listing->proj_name }}</td></tr>
    @endif
    @if($listing->projfacilities != '')
        <tr><td>Community Facilities</td><td>{{ $listing->projfacilities }}</td></tr>
    @endif
    @if($listing->num_units != '')
        <tr><td>Number of Units</td><td>{{ $listing->num_units }}</td></tr>
    @endif
    @if($listing->zoning != '')
        <tr><td>Zoning</td><td>{{ $listing->zoning }}</td></tr>
    @endif
    @if($listing->lot_access != '')
        <tr><td>Lot Access</td><td>{{ $listing->lot_access }}</td></tr>
    @endif
    @if($listing->lot_descriptions != '')
        <tr><td>Lot Description</td><td>{{ $listing->lot_descriptions }}</td></tr>
    @endif
    @if($listing->legals != '')
        <tr><td>Legal Info</td><td>{{ $listing->legals }}</td></tr>
    @endif
    @if($listing->site_description != '')
        <tr><td>Site Description</td><td>{{ $listing->site_description }}</td></tr>
    @endif
    </table>
</div>