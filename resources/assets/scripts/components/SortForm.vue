<template>
    <form class="form" method="get" >
        <input type="hidden" name="q"  >
        <input v-if="searchTerms.omni" type="hidden" name="omni" :value="searchTerms.omni" >
        <input v-if="searchTerms.area" type="hidden" name="area" :value="searchTerms.area" >
        <input v-if="searchTerms.property_type" type="hidden" name="propertyType" :value="searchTerms.propertyType" >
        <input v-if="searchTerms.min_price" type="hidden" name="minPrice" :value="searchTerms.minPrice" >
        <input v-if="searchTerms.max_price" type="hidden" name="maxPrice" :value="searchTerms.maxPrice" >
        <input v-if="searchTerms.sqft" type="hidden" name="sqft" :value="searchTerms.sqft" >
        <input v-if="searchTerms.acreage" type="hidden" name="acreage" :value="searchTerms.acreage" >
        <input v-if="searchTerms.details" type="hidden" name="details" :value="searchTerms.details" >
        <input v-if="searchTerms.beds" type="hidden" name="beds" :value="searchTerms.beds" >
        <input v-if="searchTerms.baths" type="hidden" name="baths" :value="searchTerms.baths" >
        <input v-if="searchTerms.waterfront" type="hidden" name="waterfront" :value="searchTerms.waterfront" >
        <input v-if="searchTerms.waterview" type="hidden" name="waterview" :value="searchTerms.waterview" >
        <input v-if="searchTerms.foreclosure" type="hidden" name="foreclosure" :value="searchTerms.foreclosure" >
        <input v-if="searchTerms.page" type="hidden" name="page" :value="searchTerms.page" >
        <div v-if="searchTerms.status.length > 0" >
            <input 
                v-for="(status, index) in searchTerms.status" 
                type="hidden" 
                :name="'status[' + index + ']'" 
                :key="status" 
                :value="status" >
        </div>
        <div class="input-group input-group-sm">
            <select name="sort" 
                v-model="selected" 
                class="custom-select custom-select-sm" 
                style="width:auto;" >
                <option value="list_price|desc">Price - high to low</option>
                <option value="list_price|asc">Price - low to high</option>
                <option value="list_date|desc">Date Listed </option>
                <option value="date_modified|desc">Date Modified </option>
            </select>
            <div class="input-group-append">
                <button type="submit" class="btn btn-info" >Sort</button>    
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            fieldValue: {
                type: String,
                default: 'list_date|desc'
            },
            searchTerms: {
                type: Object,
                default: () => {}
            }
        },

        data () {
            return {
                selected: this.fieldValue
            }
        },

        mounted () {
            if(this.searchTerms.sort !== null){
                this.selected = this.searchTerms.sort;
            }
        }
    }
</script>
