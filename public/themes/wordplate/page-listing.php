<?php
bladerunner('views.pages.listing', [
    'listing' => (new KeriganSolutions\KMARealtor\Listing())->get()
]);