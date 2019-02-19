<template>
    <form class="form" method="get" >
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
                baseUrl: 'https://navica.kerigan.com/api/v1/omnibar'
            }
        },
        created(){
            this.advancedOpen = false;
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