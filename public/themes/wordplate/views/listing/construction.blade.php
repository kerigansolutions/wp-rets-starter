<div class="card listing-detail">
    <div class="card-header">Construction Details</div>
    <table class="table">
    @if($listing->waterfront_feet != '' && $listing->waterfront_feet != '0')
        <tr><td>WF Feet</td><td>{{ $listing->waterfront_feet }}</td></tr>
    @endif
    @if($listing->year_built != '')
        <tr><td>Year Built</td><td>{{ $listing->year_built }}</td></tr>
    @endif
    @if($listing->construction != '')
        <tr><td>Construction Material</td><td>{{ $listing->construction }}</td></tr>
    @endif
    @if($listing->energy != '')
        <tr><td>Energy, Heat/Cool</td><td>{{ $listing->energy }}</td></tr>
    @endif
    @if($listing->exterior != '')
        <tr><td>Exterior Features</td><td>{{ $listing->exterior }}</td></tr>
    @endif
    @if($listing->interior != '')
        <tr><td>Interior Features</td><td>{{ $listing->interior }}</td></tr>
    @endif
    @if($listing->utilities != '')
        <tr><td>Utilities</td><td>{{ $listing->utilities }}</td></tr>
    @endif
    @if($listing->parking != '')
        <tr><td>Parking</td><td>{{ $listing->parking }}</td></tr>
    @endif
    @if($listing->parking_type != '')
        <tr><td>Parking Type</td><td>{{ $listing->parking_type }}</td></tr>
    @endif
    @if($listing->ownership != '')
        <tr><td>Availability</td><td>{{ $listing->ownership }}</td></tr>
    @endif
    @if($listing->parking_spaces != '')
        <tr><td>Parking Spaces</td><td>{{ $listing->parking_spaces }}</td></tr>
    @endif
    @if($listing->ceiling_height != '')
        <tr><td>Ceiling Height</td><td>{{ $listing->ceiling_height }}</td></tr>
    @endif
    @if($listing->front_footage != '')
        <tr><td>Front Footage</td><td>{{ $listing->front_footage }}</td></tr>
    @endif
    </table>
</div>