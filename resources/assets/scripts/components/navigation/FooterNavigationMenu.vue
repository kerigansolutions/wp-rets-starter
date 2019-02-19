<template>
    <div class="row">
        <div v-for="navitem in navItems" v-bind:key="navitem.ID" class="col-md-4" >
            <h3 class="cookie text-info" ><a class="text-info" :href="navitem.url" :class="navitem.classes" :target="navitem.target" >{{ navitem.title }}</a></h3>
            <p v-if="navitem.children.length > 0" class="nav-item" >
                <a 
                    v-for="(child, i) in navitem.children" v-bind:key="i"
                    :href="child.url" 
                    :class="'footer-nav-item ' + child.classes"
                    :target="child.target"
                    >
                    {{ child.title }}
                </a>
            </p>
        </div>
    </div>
</template>

<script>
    export default {

        props: {
            navItems: {}
        },
        data(){
            return {
                'navData': {}
            }
        },
        created(){
            this.navData = Object.keys(this.navItems).map((key) => {
                return this.navItems[key]
            })
        }

    }
</script>
<style>
    .main-navigation .dropdown:hover .dropdown-menu {
        display: block;
    }
</style>