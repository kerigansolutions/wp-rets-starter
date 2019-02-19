@extends('layouts.main')
@section('content')

@if (have_posts())
    @while (have_posts())
        {{ the_post() }}
        @include('partials.mast')
        <main role="main" class="pb-5">
            <div class="container">
                <article class="support">

                    <div class="row">
                        <div class="col-lg-6 col-xl-8">
                            <div class="pr-xl-4">
                                <img src="{{ $listing->media_objects->data[0]->url }}" class="img-fluid mb-4" >
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <header class="pt-0 pt-xl-5 text-center text-md-left">
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

                            <div class="top-info text-center text-md-left">
                                <table class="table-sm mb-4">
                                @if($listing->bedrooms > 0)
                                    <tr>
                                        <td class="font-weight-bold text-right px-2">{{ number_format($listing->bedrooms) }}</td>
                                        <th scope="row" class="font-weight-normal">Bedrooms</th>
                                    </tr>
                                @endif
                                @if($listing->full_baths > 0)
                                    <tr>
                                        <td class="font-weight-bold text-right px-2">{{ number_format($listing->full_baths) }}</td>
                                        <th scope="row" class="font-weight-normal">Full Bathrooms</th>
                                    </tr>
                                @endif
                                @if($listing->half_baths > 0)
                                    <tr>
                                        <td class="font-weight-bold text-right px-2">{{ number_format($listing->half_baths) }}</td>
                                        <th scope="row" class="font-weight-normal">Half Bathrooms</th>
                                    </tr>
                                @endif
                                @if($listing->sqft > 0)
                                    <tr>
                                        <td class="font-weight-bold text-right px-2">{{ number_format($listing->sqft) }}</td>
                                        <th scope="row" class="font-weight-normal">Sqft</th>
                                    </tr>
                                @endif
                                @if($listing->acreage > 0)
                                    <tr>
                                        <td class="font-weight-bold text-right px-2">{{ number_format($listing->acreage,2) }}</td>
                                        <th scope="row" class="font-weight-normal">Acres</th>
                                    </tr>
                                @endif   
                                </table>                         
                                <p>

                                @if($listing->virtual_tour != '')
                                <a class="btn btn-secondary mb-1" target="_blank" href="//{{ $listing->virtual_tour }}" >Virtual Tour</a> 
                                @endif

                                @if(count($listing->media_objects->data ) > 1)
                                <a class="btn btn-secondary mb-1" href="#">Photos ({{ count($listing->media_objects->data ) }})</a>
                                @endif

                                </p>

                            </div>
                        </div>
                    </div>
                    
                    <p>{{ $listing->remarks }}</p>

                    <photo-gallery 
                        class="d-none d-sm-block mt-4 mb-5"
                        virtual-tour='{{ $listing->virtual_tour }}' 
                        :data-photos='{{ json_encode($listing->media_objects->data) }}'
                        item-class="col-sm-6 col-md-4 col-lg-3 col-xl-2" ></photo-gallery>

                    <div class="row">
                        <div class="col-md-6 mb-4">
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
                                    <tr><td>Bedrooms</td><td>{{ $listing->bedrooms }}</td></tr>
                                @endif
								@if($listing->total_bathrooms != '' && $listing->total_bathrooms != '0')    
                                    <tr><td>Bathrooms</td><td>{{ $listing->total_bathrooms }}</td></tr>
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
                        </div>
                        <div class="col-md-6 mb-4">
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
                        </div>

                        <div class="col-md-4 mb-4">
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
                        </div>
                        <div class="col mb-4">
						    <div class="card listing-detail">
								<div class="card-header">Map Location</div>
                                <div class="card-body">
								    <p class="m-0">Due to new roads in our area, some properties may now show up in exactly the right location.</p>
                                </div>
								<div class="listing-map-frame">
									<div class="embed-responsive embed-responsive-4by3">
										<div class="embed-responsive-item" id="map" style="border:1px solid #ddd;" ></div>
										<iframe 
											class="embed-responsive-item"
											frameborder="0" 
											scrolling="no" 
											marginheight="0" 
											marginwidth="0" 
											src="https://maps.google.com/maps?q={{ urlencode($listing->full_address . ' ' . $listing->city . ', ' . $listing->state) }}&hl=es;z=14&amp;output=embed"
										></iframe>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                    <pre>{{ print_r($listing) }}</pre>
                </article>
            </div>
        </main>
    @endwhile
@else
    @include('pages.404')
@endif
@endsection