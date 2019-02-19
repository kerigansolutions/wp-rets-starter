<template>
    <ul>
        <li v-for="(navitem, index) in mobileNavData" v-bind:key="index" class="nav-item" :class="{'dropdown': navitem.children.length > 0 }">
            <a :href="navitem.url" :class="'nav-link'" :target="navitem.target" >{{ navitem.title }}</a>
            <span class="nav-icon" v-if="navitem.children.length > 0" @click="toggleSubMenu(index)">
                <i class="fa" :class="{
                    'fa-plus-circle': !navitem.subMenuOpen,
                    'fa-minus-circle': navitem.subMenuOpen
                    }" ></i>
            </span>
            <div class="dropdown-menu" v-if="navitem.subMenuOpen" >
                <li v-for="(child, i) in navitem.children" v-bind:key="i">
                    <a :href="child.url" :class="'nav-link'" :target="child.target" >{{ child.title }}</a>
                </li>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {

        props: {
            mobileNav: {
                type: Object,
                default: () => []
            }
        },

        data() {
            return {
                mobileNavData: {}
            }
        },

        created(){
            this.mobileNavData = Object.keys(this.mobileNav).map((key) => {
                this.mobileNav[key].subMenuOpen = false;
                if(this.mobileNav[key].children.length > 0){
                    this.mobileNav[key].subMenuOpen = true;
                }
                return this.mobileNav[key]
            })
        },

        methods: {
            toggleSubMenu(navitem){
                this.mobileNavData[navitem].subMenuOpen = !this.mobileNavData[navitem].subMenuOpen;
                console.log(navitem);
            }
        }

    }
</script>
<style lang="scss" >
.mobile-menu {
    transition: all ease-in 1s;
    display: none;
    background-color: #20c997;
    
    &.open {
        display: block;
        height: 100vh;
        width:100%;
        z-index: 5;
        padding: 8rem 2rem 2rem;
        color: #FFF;
        position: fixed;
        right: 0;
        text-align: center;

        @media screen and (min-width: 576px){
            width: auto;
            text-align: left;
            padding: 6rem 2rem 2rem;
        }

        @media screen and (min-width: 993px){
            padding: 8rem 2rem 2rem;
        }

        ul.navbar-nav li a {
            font-size: 18px;
            color: #FFF;
        }
    } 

    .nav-icon {
        font-size:1.2em;
        padding: .25rem .5rem;
        position: absolute;
        right: 0;
        margin-top:-2.5rem;
        cursor: pointer;
    }

    .dropdown-menu {
        border: 0;
        display: block;
        padding: .5rem 1rem;
        background-color: #1aa37b;
    }
}
</style>
