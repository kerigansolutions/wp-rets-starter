<template>
    <div class="portfolio-gallery">
        <div class="row justify-content-center items-center mobile-portfolio-filter d-flex d-md-none">
            <a @click="togglePortfolioMenu" class="btn btn-outline-light text-center col-12 mb-4">Sort by Category</a>
            <div v-if="menuOpen" class="col-12 border border-light py-4 mb-4" >
                <div 
                    class="d-block text-center py-2" >
                    <a href="/project-portfolio/" >All</a>
                </div>
                <div 
                    class="d-block text-center py-2"
                    v-for="location in locations"
                    :key="location.index" >
                    <a
                        :href="'/project-portfolio/?location=' + location.slug"
                    >
                        {{ location.name }}
                    </a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center items-center portfolio-filters d-none d-md-flex">
            <div class="col-auto" >
                <button 
                    @click="getLocation('')"
                    :class="{
                        'btn btn-primary': selectedLocation === '',
                        'btn btn-outline-light': selectedLocation !== ''  
                    }"
                >
                    All
                </button>
            </div>
            <div 
                class="col-auto"
                v-for="location in locations"
                :key="location.index" >
                <button
                    @click="getLocation(location.slug)"
                    :class="{
                        'btn btn-primary': selectedLocation === location.slug,
                        'btn btn-outline-light': selectedLocation !== location.slug  
                    }"
                >
                    {{ location.name }}
                </button>
            </div>
        </div>
        <transition-group 
            name="project-list" 
            tag="div" 
            class="row justify-content-center items-center d-flex"
            style="margin: 0 -30px;" >
            <div v-for="(project, index) in portfolioItems" :key="index" class="col-md-6 col-lg-4">
                <div class="card project-tile text-center border-light project-list-item">
                    <a :href="project.link" >
                        <img :src="project.photo.sizes.thumbnail" class="card-img-top img-fluid" :alt="project.name" >
                    </a>
                    <div class="card-body">
                        <h3 class="text-uppercase text-dark">{{ project.name }}</h3>
                        <p class="text-uppercase text-light">{{ project.build_location[0].name }}</p>
                    </div>
                </div>
                <div class="project-button text-center">
                    <a :href="project.link" class="btn btn-outline-light" >View</a>
                </div>
            </div>
        </transition-group>
    </div>
</template>

<script>
export default {
    props: {
        locations: {
            type: Object,
            default: () => []
        }, 
        limit: {
            type: Number,
            default: -1
        }, 
        location: {
            type: String,
            default: ''
        }, 
        type: {
            type: String,
            default: ''
        }
    },

    data () {
        return {
            portfolioItems: [],
            selectedLocation: this.location,
            selectedType: this.type,
            menuOpen: false
        }
    },

    created () {
        this.fetch();
    },

    methods: {
        fetch() {
            let request = '?1=1';
            request += (this.selectedLocation != '' ? '&build-location=' + this.selectedLocation : '' );
            request += (this.selectedType != '' ? '&construction-type=' + this.selectedType : '' );
            request += '&limit=' + this.limit;

            http.get("/wp-json/kerigansolutions/v1/projects" + request)
                .then(response => {
                    this.portfolioItems = response.data;
                }
            );
        },
        getLocation(slug) {
            this.selectedLocation = slug;
            this.fetch();
        },
        getType(slug) {
            this.selectedType = slug;
            this.fetch();
        },
        togglePortfolioMenu() {
            this.menuOpen = !this.menuOpen;
        }
    }
}
</script>

<style>
.project-list-enter-active, .project-list-leave-active {
  transition: all .4s;
}
.project-list-enter, .project-list-leave-to /* .list-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(30px);
}
.separator {
    width: 1px;
    background-color: #999;
    height: 100%;
}

.project-tile .card-body {
    padding: 2rem 1.25rem;
}

.project-tile h3 {
    font-size: 16px;
    font-weight: 900;
}

.project-tile p {
    font-size: 11px;
}

</style>
