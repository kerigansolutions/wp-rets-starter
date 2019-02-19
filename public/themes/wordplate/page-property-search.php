<?php

$search = new KeriganSolutions\KMARealtor\Search();

bladerunner('views.pages.propertysearch', [
    'results'        => ($search->getListings())->data,
    'currentRequest' => $search->getCurrentRequest(),
    'resultsMeta'    => $search->getResultMeta(),
    'currentSort'    => $search->getSort(),
    'pagination'     => $search->buildPagination()
]);