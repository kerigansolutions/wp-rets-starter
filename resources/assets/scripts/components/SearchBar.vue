<template>
    <div>
        <div v-if="!showSearch && !showSort" class="d-flex mb-4 justify-content-between align-items-center" >
            <div class="d-none d-md-block">
                <span v-if="searchTerms.area != 'Any'" class="mr-3 small text-muted">Area: <b>{{ searchTerms.area }}</b></span>
                <span v-if="searchTerms.propertyType != 'Any'" class="mr-3 small text-muted">Type: <b>{{ searchTerms.propertyType }}</b></span>
                <span v-if="(searchTerms.minPrice && searchTerms.minPrice != 'Any') || (searchTerms.maxPrice && searchTerms.maxPrice != 'Any')" class="mr-3 small text-muted">Price: 
                    <span v-if="searchTerms.minPrice && searchTerms.minPrice != 'Any' && searchTerms.maxPrice == 'Any'" >></span>
                    <b v-if="searchTerms.minPrice != 'Any'">${{ searchTerms.minPrice.toLocaleString() }}</b>
                    <span v-if="searchTerms.minPrice && searchTerms.minPrice != 'Any' && searchTerms.maxPrice != 'Any'" > to </span>
                    <span v-if="(searchTerms.minPrice && searchTerms.minPrice == 'Any') && (searchTerms.maxPrice && searchTerms.maxPrice != 'Any')" ><</span>
                    <b v-if="searchTerms.maxPrice != 'Any'">${{ searchTerms.maxPrice.toLocaleString() }}</b>
                </span>
                <span v-if="searchTerms.beds && searchTerms.beds != 'Any'" class="mr-3 small text-muted">Beds: <b>{{ searchTerms.beds }}</b></span>
                <span v-if="searchTerms.baths && searchTerms.baths != 'Any'" class="mr-3 small text-muted">Baths: <b>{{ searchTerms.baths }}</b></span>
                <span v-if="searchTerms.sqft && searchTerms.sqft != 'Any'" class="mr-3 small text-muted">Sqft: <b>{{ searchTerms.sqft }}</b></span>
                <span v-if="searchTerms.acreage && searchTerms.acreage != 'Any'" class="mr-3 small text-muted">Acres: <b>{{ searchTerms.acreage }}</b></span>
            </div>
            <div class="controls d-flex flex-grow-1 justify-content-end">
                <button @click="toggleSearch()" class="btn btn-sm btn-secondary col col-sm-auto">Refine Search</button>
                <button @click="toggleSort()" class="btn d-md-none btn-sm btn-info col col-sm-auto">Sort</button>
            </div>
        </div>
        <div v-if="showSort" class="mb-4">
            <sort-form :search-terms="searchTerms" class="sort-form" ></sort-form>
        </div>
        <form v-if="showSearch" class="form" method="get" :ref="searchForm" >
            <input v-if="searchTerms.sort" type="hidden" name="sort" :value="searchTerms.sort" >
            <input v-if="searchTerms.minPrice && searchTerms.minPrice != 'Any'" type="hidden" name="minPrice" :value="searchTerms.minPrice" >
            <input v-if="searchTerms.maxPrice && searchTerms.maxPrice != 'Any'" type="hidden" name="maxPrice" :value="searchTerms.maxPrice" >
            <input v-if="searchTerms.beds && searchTerms.beds != 'Any'" type="hidden" name="beds" :value="searchTerms.beds" >
            <input v-if="searchTerms.baths && searchTerms.baths != 'Any'" type="hidden" name="baths" :value="searchTerms.baths" >
            <input v-if="searchTerms.sqft && searchTerms.sqft != 'Any'" type="hidden" name="sqft" :value="searchTerms.sqft" >
            <input v-if="searchTerms.acreage && searchTerms.acreage != 'Any'" type="hidden" name="acreage" :value="searchTerms.acreage" >
            <input type="hidden" name="q" value="search" >
            <div class="row">
                <div class="col-sm-6 col-lg-3 my-2">
                    <label>City / Area</label>
                    <area-field
                        :field-value="searchTerms.area"
                    >
                    </area-field>
                </div>
                <div class="col-sm-6 col-lg-3 my-2">
                    <label>Property Type</label>
                    <property-type
                        :field-value="searchTerms.propertyType"
                    >
                    </property-type>
                </div>

                <div v-if="advancedOpen" class="col-6 col-md-4 col-lg-3">
                    <min-price-field
                        class="my-2"
                        :field-value="searchTerms.minPrice"
                    >
                    </min-price-field>
                </div>
                <div v-if="advancedOpen" class="col-6 col-md-4 col-lg-3">
                    <max-price-field
                        class="my-2"
                        :field-value="searchTerms.maxPrice"
                    ></max-price-field>
                </div>

                <div v-if="advancedOpen" class="col-6 col-md-4 col-lg-3">
                    <bedrooms-field
                        class="my-2"
                        :field-value="searchTerms.beds"
                    ></bedrooms-field>
                </div>
                <div v-if="advancedOpen" class="col-6 col-md-4 col-lg-3">
                    <bathrooms-field
                        class="my-2"
                        :field-value="searchTerms.baths"
                    ></bathrooms-field>
                </div>

                <div v-if="advancedOpen" class="col-6 col-md-4 col-lg-3">
                    <sqft-field
                        class="my-2"
                        :field-value="searchTerms.sqft"
                    ></sqft-field>
                </div>
                <div v-if="advancedOpen" class="col-6 col-md-4 col-lg-3">
                    <acreage-field
                        class="my-2"
                        :field-value="searchTerms.acreage"
                    ></acreage-field>
                </div>

                <div class="col-sm-6 col-lg-3 mb-md-2 pt-md-3">
                    <button
                        @click="toggleAdvanced"
                        type="button"
                        class="btn btn-secondary dropdown-toggle btn-block mt-4"
                        aria-haspopup="true"
                        aria-expanded="false"
                        >Advanced Options</button>
                </div>
                
                <div class="col-sm-6 col-lg-3 mb-2 pt-md-3">
                    <button type="submit" class="btn btn-primary btn-block mt-4">Search</button>
                </div>
            </div>
            
            <input name="page" value="1" type="hidden" >
        </form>
    </div>
</template>

<script>
    export default {
        props: ['searchTerms'],
        data(){
            return {
                omni: null,
                omniTerms: [],
                advancedOpen: false,
                mapViewSelected: false,
                baseUrl: 'https://navica.kerigan.com/api/v1/omnibar',
                showSearch: false,
                showSort:false
            }
        },
        created(){
            this.advancedOpen = false;
            if(this.searchTerms.area == null){
                this.showSearch = true;
            }
        },
        watch: {
            omni: function (newOmni, oldOmni) {
                if (newOmni.length > 2) {
                    this.search();
                }
            }
        },
        methods: {
            toggleAdvanced(event){
                if (event) event.preventDefault();
                this.advancedOpen = !this.advancedOpen;
            },
            toggleSearch(event){
                if (event) event.preventDefault();
                this.showSearch = !this.showSearch;
            },
            toggleSort(event){
                if (event) event.preventDefault();
                this.showSort = !this.showSort;
            },
            applySearchFilter(search, omniTerms) {
                return omniTerms.filter(term => term.value.toLowerCase().includes(search.toLowerCase()))
            },
            search: _.debounce(
                function () {
                    console.log(this.omni);
                    let vm = this;
                    let config = {
                        method: 'get',
                        url: vm.baseUrl + '?search=' + vm.omni,
                    };
                    axios(config)
                        .then(response => {
                            vm.omniTerms = response.data;
                        })
                },
                100
            )
        }
    }
</script>