<div class="card listing-detail">
    <div class="card-header">Map Location</div>
    <div class="card-body">
        <p class="m-0">Due to new roads in our area, some properties may not show up in exactly the right location.</p>
    </div>
    <div class="listing-map-frame">
        <div class="embed-responsive embed-responsive-4by3">
            <iframe 
                class="embed-responsive-item"
                frameborder="0" 
                scrolling="no" 
                marginheight="0" 
                marginwidth="0" 
                src="https://maps.google.com/maps?q={{ urlencode($listing->location->lat) }},{{ urlencode($listing->location->long) }}&hl=es;z=14&amp;output=embed"
            ></iframe>
        </div>
    </div>
</div>

