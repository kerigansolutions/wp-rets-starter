<template>
    <div class="quick-search w-100 p-4 p-sm-0 p-md-4 d-inline-block text-white">
        <form action="property-search">
        <input name="q" value="search" type="hidden" >
        <div class="row d-flex align-items-center">
            <div class="col-12 col-md mb-2 flex-grow-1">
                <omni-bar
                    v-model="omni"
                    :options="omniTerms"
                    :filter-function="applySearchFilter"
                    field-value=""
                ></omni-bar>
            </div>
            <div class="col-12 col-md-auto mb-2">
                <button class="btn btn-block btn-primary">SEARCH</button>
            </div>
        </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            'searchTerms': {
                type: Object,
                default: {}
            }
        },
        data(){
            return {
                omni: null,
                omniTerms: [],
                baseUrl: 'https://navica.kerigan.com/api/v1/omnibar',
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
<style lang="scss" scoped>
.btn {
    font-size: .9rem;
}
</style>
