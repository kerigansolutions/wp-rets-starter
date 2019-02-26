<p class="pt-lg-4">
    @if($listing->virtual_tour != '')
    <a class="btn btn-secondary mb-1" target="_blank" href="//{{ $listing->virtual_tour }}" >Virtual Tour</a> 
    @endif
    @if(count($listing->media_objects->data ) > 1)
    <a @click="openGallery" class="btn btn-secondary mb-1 pointer text-white" >Photos ({{ count($listing->media_objects->data ) }})</a>
    @endif
</p>